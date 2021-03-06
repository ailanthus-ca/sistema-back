<?php

namespace Modelos;

class Compra extends \Prototipo\Operaciones {

    var $estado = 'Compra';
    var $id_orden = 0;
    var $cod_proveedor = '';
    var $cod_documento = '';
    var $fecha_doc = '';
    var $num_con = '';
    var $dolar = 0;

    function fechaCambios() {
        $sql = $this->query('SELECT MAX(actualizado) AS cant FROM compra_lista');
        while ($row = $sql->fetch_array()) {
            return $row['cant'];
        }
        return '';
    }

    public function cambios($fecha, $hora) {
        $pen = array();
        $act = $this->fechaCambios();
        $sol = ($fecha !== '') ? "WHERE `actualizado` > '$fecha $hora'" : '';
        $query = $this->query("SELECT * FROM compra_lista $sol");
        while ($row = $query->fetch_array()) {
            $detalle = array();
            $sql = $this->query("SELECT cod_producto FROM detallecompra WHERE cod_compra = " . $row['codFact']);
            while ($row2 = $sql->fetch_array()) {
                $detalle[] = $row2['cod_producto'];
            }
            $pen[] = array(
                (int) $row['codFact'],
                $row['cod_proveedor'],
                $row['nombre'],
                $row['fecha'],
                (float) $row['total'],
                (int) $row['usuario'],
                (int) $row['status'],
                $detalle
            );
        }
        if (count($pen) > 1) {
            $producto = new Producto();
            $producto->actualizarUltimosMovimientos();
        }
        return $this->getResponse([
                    'fecha' => $act,
                    'data' => $pen
        ]);
    }

    public function lista() {
        $pen = array();
        $query = $this->query("SELECT * FROM compra_lista");
        while ($row = $query->fetch_array()) {
            $detalle = array();
            $sql = $this->query("SELECT cod_producto FROM detallecompra WHERE cod_compra = " . $row['codFact']);
            while ($row2 = $sql->fetch_array()) {
                $detalle[] = $row2['cod_producto'];
            }
            $pen[] = array(
                (int) $row['codFact'],
                $row['cod_proveedor'],
                $row['nombre'],
                $row['fecha'],
                (float) $row['total'],
                (int) $row['usuario'],
                (int) $row['status'],
                $detalle
            );
        }
        return $this->getResponse($pen);
    }

    function detalles($id) {
        $sql = "SELECT * FROM compra where codigo = $id";
        $query = $this->query($sql);
        $compra = array();
        if ($row = $query->fetch_array()) {
            //datos del proveedor
            $proveedor = new Proveedor();
            $compra = $proveedor->detalles($row['cod_proveedor']);
            $compra['cod_proveedor'] = $row['cod_proveedor'];
            //datos del usuario
            $usuario = new Usuario();
            $user = $usuario->detalles($row['usuario']);
            $compra['usuario'] = $user['nombre'];
            $compra['cod_usuario'] = (int) $row['usuario'];
            //datos de la compra
            $compra['codigo'] = (int) $row['codigo'];
            $compra['fecha'] = $row['fecha'];
            $compra['cod_documento'] = $row['cod_documento'];
            $compra['nun_control'] = $row['nun_control'];
            $compra['fecha_documento'] = $row['fecha_documento'];
            $compra['nota'] = $row['nota'];
            $compra['tasa'] = (float) $row['dolar'];
            $compra['estatus'] = (int) $row['estatus'];
            $compra['impuesto'] = (float) $row['impuesto'];
            $compra['tasa'] = (float) $row['dolar'];
            //Detalle de la compra
            $compra['detalles'] = array();
            $sql = "SELECT * from detallecompra where cod_compra = '" . $compra['codigo'] . "'";
            $query = $this->query($sql);
            $producto = new Producto();
            while ($row = $query->fetch_array()) {
                $detalle = $producto->ver($row['cod_producto']);
                $detalle['unidades'] = (float) $row['cantidad'];
                $detalle['precio'] = (float) $row['precio_unit'];
                $compra['detalles'][] = $detalle;
            }
            return $compra;
        } else {
            return $this->getNotFount('compra no encontrada');
        }
    }

    function checkCodigo($cod) {
        $sql = $this->query('SELECT count(*) AS exist FROM compra WHERE codigo="' . $cod . '"');
        if ($row = $sql->fetch_array()) {
            return boolval($row['exist']);
        }
    }

    function nuevo() {
        //usuario
        $user = $_SESSION['id_usuario'];
        $sql = $this->query('SELECT COUNT(*) as cant FROM `compra`');
        $row = $sql->fetch_array();
        $cod_compra = $row['cant'] + 1;
        $dolar = new \Modelos\Dolares();
        $tasa = $dolar->valor();
        $this->query("INSERT INTO compra VALUES ("
                . "'$cod_compra',"
                . "'$this->cod_proveedor',"
                . "'$this->cod_documento',"
                . "'$this->num_con',"
                . "NOW(),"
                . "NOW(),"
                . "'$this->fecha_doc',"
                . "$this->subtotal, "
                . "$this->impuesto,"
                . "$this->total,"
                . "'$this->nota',"
                . "$user,"
                . "$this->etatus,"
                . "$tasa)");
        //;
        $productos = new \Modelos\Producto();
        foreach ($this->detalles as $iten) {
            $monto = $iten->unidades * $iten->precio;
            $this->query("INSERT INTO `detallecompra` VALUES("
                    . "$cod_compra,"
                    . "'$iten->codigo',"
                    . "$iten->unidades,"
                    . "$iten->precio,"
                    . "$monto)");
            $config = new \Config('costo');
            $productos->cargar($iten->codigo);
            $productos->cargarStock($iten->codigo);
            $costo = $config->get();
            if ($costo['costo'] < 3) {
                if ($costo['costo'] === 2 && $productos->checkCosto($iten->precio, $tasa))
                    $productos->costo($iten->codigo, $iten->precio, $tasa);
                elseif ($costo['costo'] === 1)
                    $productos->costo($iten->codigo, $iten->precio, $tasa);
            }
        }
        if ($this->id_orden > 0) {
            $orden = new \Modelos\Orden();
            $orden->procesar($this->id_orden);
        }
        $this->actualizarEstado();
        return $this->getResponse($cod_compra);
    }

    function cancelar($id) {
        $query = $this->query("UPDATE `compra` SET `estatus`= 0 WHERE codigo = $id");
        $sql2 = $this->query("select * from detallecompra where cod_compra = '$id' ");
        $productos = new \Modelos\Producto();
        while ($row = $sql2->fetch_array()) {
            $productos->cargarStock($row['cod_producto']);
        }
        $this->actualizarEstado();
        return 1;
    }

    function facturar($id) {
        $query = $this->query("UPDATE `compra` SET  "
                . "nun_control='$this->num_con',"
                . "`cod_documento`='$this->cod_documento',`"
                . "fecha_documento`='$this->fecha_doc',"
                . "`estatus`= $this->etatus WHERE codigo = $id");
        $this->actualizarEstado();
        return 1;
    }

    function listaWhere($where) {
        $pen = array();
        $query = $this->query("SELECT "
                . "compra.codigo as codFact,"
                . "telefono,correo,contacto, "
                . "fecha,"
                . " nombre,"
                . "total,"
                . "cod_documento,"
                . "fecha_documento,"
                . "nun_control,"
                . "compra.estatus as status,"
                . "compra.nota,"
                . "compra.usuario  "
                . "FROM compra,proveedor "
                . "WHERE compra.cod_proveedor = proveedor.codigo "
                . $where
                . " order by fecha DESC ");
        while ($row = $query->fetch_array()) {
            $pen[] = array(
                'codigo' => (int) $row['codFact'],
                'fecha' => $row['fecha'],
                'nombre' => $row['nombre'],
                'telefono' => $row['telefono'],
                'correo' => $row['correo'],
                'contacto' => $row['contacto'],
                'cod_documento' => $row['cod_documento'],
                'fecha_documento' => $row['fecha_documento'],
                'nun_control' => $row['nun_control'],
                'monto' => (float) $row['total'],
                'nota' => $row['nota'],
                'usuario' => (int) $row['usuario'],
                'status' => (int) $row['status']
            );
        }
        return $this->getResponse($pen);
    }

    function listaWithProducto($codigo, $where) {
        $pen = array();
        $query = $this->query("SELECT "
                . "compra.codigo as codFact,"
                . "telefono,correo,contacto, "
                . "fecha,"
                . "nombre, "
                . "total, "
                . "cod_documento, "
                . "fecha_documento, "
                . "nun_control, "
                . "compra.estatus as status, "
                . "compra.nota, "
                . "compra.usuario, "
                . "detallecompra.cantidad, "
                . "detallecompra.precio_unit "
                . "FROM compra, detallecompra, proveedor "
                . "WHERE compra.cod_proveedor = proveedor.codigo "
                . "AND compra.codigo=cod_compra "
                . "AND cod_producto = '$codigo' "
                . $where
                . " order by fecha DESC ");
        while ($row = $query->fetch_array()) {
            $pen[] = array(
                'operacion' => 'COMPRA',
                'tipo' => 'ENTRADA',
                'orden' => strtotime($row['fecha']),
                'codigo' => (int) $row['codFact'],
                'fecha' => $row['fecha'],
                'nombre' => $row['nombre'],
                'telefono' => $row['telefono'],
                'correo' => $row['correo'],
                'contacto' => $row['contacto'],
                'cod_documento' => $row['cod_documento'],
                'fecha_documento' => $row['fecha_documento'],
                'nun_control' => $row['nun_control'],
                'monto' => (float) $row['total'],
                'nota' => $row['nota'],
                'usuario' => (int) $row['usuario'],
                'status' => (int) $row['status'],
                'cantidad' => (float) $row['cantidad'],
                'precio_unit' => (float) $row['precio_unit']
            );
        }
        return $this->getResponse($pen);
    }

    function productos($where) {
        $query = $this->query("SELECT "
                . "detallecompra.cod_producto as codigo, "
                . "producto.descripcion as descripcion, "
                . "SUM( detallecompra.cantidad ) as cantidad, "
                . "SUM( detallecompra.monto ) as monto "
                . "FROM detallecompra,  producto, compra WHERE "
                . "producto.codigo = cod_producto AND "
                . "compra.codigo = cod_compra "
                . "$where "
                . "GROUP BY cod_producto");
        $pen = array();
        while ($row = $query->fetch_array()) {
            $pen[] = array(
                'codigo' => $row['codigo'],
                'descripcion' => $row['descripcion'],
                'cantidad' => (float) $row['cantidad'],
                'monto' => (float) $row['monto'],
            );
        }
        return $this->getResponse($pen);
    }

    function entradasValidas($codigo, $where = '') {
        $query = $this->query("SELECT "
                . "SUM( cantidad ) as cantidad "
                . "FROM detallecompra, compra WHERE "
                . "cod_producto = '$codigo' AND "
                . "codigo = cod_compra AND $where "
                . "estatus > 0");
        while ($row = $query->fetch_array()) {
            return (float) $row['cantidad'];
        }
        return 0;
    }

    // -------------------------- GRAFICAS -----------------------------------

    public function totalCompras() {
        $query = $this->query("SELECT COUNT(*) AS total FROM `compra`");
        $pen = 0;
        while ($row = $query->fetch_array()) {
            $pen = (int) $row['total'];
        }
        return $this->getResponse($pen);
    }

    public function torta($where) {
        $query = $this->query("SELECT "
                . "estatus AS RANK, "
                . "COUNT(estatus) AS CANT "
                . "FROM compra "
                . "WHERE $where "
                . "GROUP BY estatus");
        $pen = array();
        while ($row = $query->fetch_array()) {
            $pen[] = array(
                'cantidad' => (int) $row['CANT'],
                'estatus' => (int) $row['RANK']
            );
        }
        return $this->getResponse($pen);
    }

    public function compraAno($ano) {
        $query = $this->query("SELECT "
                . "SUM(subtotal) AS r,"
                . "MONTH(fecha) AS mes "
                . "FROM compra WHERE "
                . "YEAR(fecha)=$ano AND "
                . "estatus > 0 "
                . "GROUP BY mes");
        $pen = array();
        while ($row = $query->fetch_array()) {
            $pen[(int) $row['mes']] = (float) $row['r'];
        }
        return $this->getResponse($pen);
    }

    public function compraMes($ano, $mes) {
        $query = $this->query("SELECT "
                . "SUM(subtotal) AS r, "
                . "DAY(fecha) as dia "
                . "FROM compra WHERE "
                . "MONTH(fecha)=$mes AND "
                . "YEAR(fecha)=$ano AND "
                . "estatus > 0 "
                . "GROUP BY dia");
        $pen = array();
        while ($row = $query->fetch_array()) {
            // $pen[(int) $row['dia']] = (float) $row['r'];
            $pen[(int) $row['dia']] = (float) $row['r'];
        }
        $dias = date('t', strtotime("$ano-$mes-1"));
        for ($i = 1; $i <= $dias; $i++) {
            if (empty($pen[$i])) {
                $pen[$i] = 0;
            }
        }
        return $this->getResponse($pen);
    }

}
