<?php

namespace Modelos;

class Cotizacion extends \Prototipo\Operaciones {

    var $estado = 'Cotizacion';
    var $cod_cliente = '';

    function fechaCambios() {
        $sql = $this->query('SELECT MAX(actualizado) AS cant FROM cotizacion_lista');
        while ($row = $sql->fetch_array()) {
            return $row['cant'];
        }
        return '';
    }
    public function cambios($fecha, $hora) {
        $pen = array();
        $act = $this->fechaCambios();
        $sol = ($fecha !== '') ? "WHERE `actualizado` > '$fecha $hora'" : '';
        $query = $this->query("SELECT * FROM cotizacion_lista $sol");
        while ($row = $query->fetch_array()) {
            $detalle = array();
            $sql = $this->query('SELECT codProducto FROM detallecotizacion WHERE codCotizacion = ' . $row['codFact']);
            while ($row2 = $sql->fetch_array()) {
                $detalle[] = $row2['codProducto'];
            }
            $pen[] = array(
                (int) $row['codFact'],
                $row['cod_cliente'],
                $row['nombre'],
                $row['fecha'],
                (float) $row['total'],
                (int) $row['usuario'],
                (int) $row['status'],
                $detalle,
                (float) $row['tasa'],
            );
        }
        return $this->getResponse([
                    'fecha' => $act,
                    'data' => $pen
        ]);
    }

    public function lista() {
        $pen = array();
        $query = $this->query("SELECT * FROM cotizacion_lista");
        while ($row = $query->fetch_array()) {
            $detalle = array();
            $sql = $this->query('SELECT codProducto FROM detallecotizacion WHERE codCotizacion = ' . $row['codFact']);
            while ($row2 = $sql->fetch_array()) {
                $detalle[] = $row2['codProducto'];
            }
            $pen[] = array(
                (int) $row['codFact'],
                $row['cod_cliente'],
                $row['nombre'],
                $row['fecha'],
                (float) $row['total'],
                (int) $row['usuario'],
                (int) $row['status'],
                $detalle,
                (float) $row['tasa'],
            );
        }
        return $this->getResponse($pen);
    }

    public function detalles($id) {
        $sql = "SELECT * FROM cotizacion where codigo = $id";
        $query = $this->query($sql);
        $cotizacion = array();
        if ($row = $query->fetch_array()) {
            //datos del cliente
            $cliente = new Cliente();
            $cotizacion = $cliente->detalles($row['cod_cliente']);
            $cotizacion['cod_cliente'] = $row['cod_cliente'];
            //datos del usuario
            $usuario = new Usuario();
            $usuario = $usuario->detalles($row['usuario']);
            $cotizacion['usuario'] = $usuario['nombre'];
            $cotizacion['cod_usuario'] = $row['usuario'];
            //datos de la cotizacion
            $cotizacion['codigo'] = (int) $row['codigo'];
            $cotizacion['forma_pago'] = $row['forma_pago'];
            $cotizacion['tiempo_entrega'] = $row['tiempo_entrega'];
            $cotizacion['validez'] = $row['validez'];
            $cotizacion['nota'] = $row['nota'];
            $cotizacion['cod_cliente'] = $row['cod_cliente'];
            $cotizacion['fecha'] = $row['fecha'];
            $cotizacion['subtotal'] = (float) $row['subtotal'];
            $cotizacion['total'] = (float) $row['total'];
            $cotizacion['impuesto'] = (float) $row['iva'];
            $cotizacion['tasa'] = (float) $row['tasa'];
            $cotizacion['estatus'] = (int) $row['estatus'];
            //Detalle de la cotizacion
            $query = $this->query("SELECT * from detallecotizacion where codCotizacion = $id");
            $cotizacion['detalles'] = array();
            $producto = new Producto();
            while ($row = $query->fetch_array()) {
                $detalle = $producto->ver($row['codProducto']);
                $detalle['unidades'] = (float) $row['cantidad'];
                $detalle['precio'] = (float) $row['precio_unit'];
                $detalle['comentario'] = $row['comentario'];
                $cotizacion['detalles'][] = $detalle;
            }
        }
        return $this->getResponse($cotizacion);
    }

    function checkCodigo($cod) {
        $sql = $this->query('SELECT count(*) AS exist FROM cotizacion WHERE codigo="' . $cod . '"');
        if ($row = $sql->fetch_array()) {
            return boolval($row['exist']);
        }
    }

    public function nuevo() {
        $this->getCondiciones();
        $this->cod_cliente = $this->postString('cod_cliente');
        $plantilla_id = $this->postIntenger('plantilla');
        $id_usuario = $_SESSION['id_usuario'];
        $dolar = new \Modelos\Dolares();
        $tasa = $dolar->valor();
        $query = $this->query("INSERT into cotizacion values("
                . "null,"
                . "UPPER('$this->cod_cliente'),"
                . " NOW(),"
                . " NOW(),"
                . " $this->impuesto,"
                . " $this->subtotal,"
                . " $this->total,"
                . " UPPER('$this->forma_pago'),"
                . " UPPER('$this->tiempo_entrega'),"
                . " UPPER('$this->validez'),"
                . " UPPER('$this->nota'),"
                . "$tasa,"
                . " 1,"
                . "$id_usuario)");
        $id_cotizacion = $this->con->insert_id;
        foreach ($this->detalles as $pro) {
            $monto = $pro->unidades * $pro->precio;
            $this->query("INSERT INTO detallecotizacion VALUES ("
                    . "'$id_cotizacion',"
                    . "'$pro->codigo',"
                    . "'$pro->unidades',"
                    . "'$pro->precio', "
                    . "'$monto',"
                    . "'$pro->comentario') ");
        }
        if ($plantilla_id > 0) {
            $plantilla = new Plantilla();
            $plantilla->borrar($plantilla_id);
        }
        $this->actualizarEstado();
        return $this->getResponse($id_cotizacion);
    }

    public function guardar() {
        $plantilla_id = $this->postIntenger('plantilla');
        $plantilla = new \Modelos\Plantilla;
        return $plantilla->guardar($plantilla_id);
    }

    public function seguimiento($id) {
        // $id_usuario = $_SESSION['id_usuario'];
        $sql = "SELECT descripcion,nombre,fecha,correo FROM cotizacion_seguimiento,usuario where usuario=codigo AND cod_cotizacion = $id";
        $query = $this->query($sql);
        $cotizacion = array();
        while ($row = $query->fetch_array()) {
            $cotizacion[] = array(
                'descripcion' => $row['descripcion'],
                'usuario' => $row['nombre'],
                'correo' => $row['correo'],
                'fecha' => $row['fecha'],
            );
        }
        return $this->getResponse($cotizacion);
    }

    public function seguimiento_nuevo($id, $descripcion) {
        $id_usuario = $_SESSION['id_usuario'];
        $fecha = date('Y-m-d H:i:s');
        $sql = "INSERT INTO cotizacion_seguimiento (cod_cotizacion,descripcion,usuario,fecha) VALUES ($id,UPPER('$descripcion'),$id_usuario,'$fecha')";
        $query = $this->query($sql);
        return $this->getResponse(1);
    }

    function cancelar($id) {
        $sql = "UPDATE `cotizacion` SET `estatus`= 0 WHERE codigo = $id";
        $query = $this->query($sql);
        $this->actualizarEstado();
        return $this->getResponse($this->detalles($id));
    }

    public function procesar($id) {
        $query = $this->query("UPDATE `cotizacion` SET `estatus`= 2 WHERE codigo = $id");
        $sql = $this->query("select usuario from cotizacion WHERE codigo = $id");
        if ($row = $sql->fetch_array()) {
            $user_id = (int) $row['usuario'];
        }
        $this->actualizarEstado();
        return $this->getResponse($user_id);
    }

    function listaWhere($where) {
        $pen = array();
        $query = $this->query("SELECT "
                . "cotizacion.codigo as codFact, "
                . "fecha, "
                . "telefono, "
                . "correo, "
                . "contacto, "
                . "nombre, "
                . "total, "
                . "cotizacion.estatus as status, "
                . "cotizacion.usuario "
                . "FROM cotizacion,cliente "
                . "WHERE cotizacion.cod_cliente = cliente.codigo "
                . " $where "
                . " order by fecha DESC");
        while ($row = $query->fetch_array()) {
            $pen[] = array(
                'codigo' => (int) $row['codFact'],
                'fecha' => $row['fecha'],
                'nombre' => $row['nombre'],
                'telefono' => $row['telefono'],
                'correo' => $row['correo'],
                'contacto' => $row['contacto'],
                'monto' => (float) $row['total'],
                'usuario' => (int) $row['usuario'],
                'status' => (int) $row['status'],
            );
        }
        return $this->getResponse($pen);
    }

    function listaWithProducto($codigo, $where) {
        $pen = array();
        $query = $this->query("SELECT "
                . "cotizacion.codigo as codFact, "
                . "fecha,telefono, "
                . "correo, "
                . "contacto, "
                . "nombre, "
                . "total, "
                . "cotizacion.estatus as status, "
                . "cotizacion.usuario, "
                . "detallecotizacion.cantidad, "
                . "detallecotizacion.precio_unit "
                . "FROM cotizacion, cliente, detallecotizacion "
                . "WHERE cotizacion.cod_cliente = cliente.codigo "
                . "AND detallecotizacion.codCotizacion = cotizacion.codigo "
                . "AND codProducto = '$codigo' "
                . " $where "
                . "order by fecha DESC ");
        while ($row = $query->fetch_array()) {
            $pen[] = array(
                'operacion' => 'COTIZACION',
                'tipo' => 'SALIDA',
                'orden' => strtotime($row['fecha']),
                'codigo' => (int) $row['codFact'],
                'fecha' => $row['fecha'],
                'nombre' => $row['nombre'],
                'telefono' => $row['telefono'],
                'correo' => $row['correo'],
                'contacto' => $row['contacto'],
                'monto' => (float) $row['total'],
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
                . "detallecotizacion.codProducto as codigo, "
                . "producto.descripcion as descripcion, "
                . "SUM( detallecotizacion.cantidad ) as cantidad, "
                . "SUM( detallecotizacion.monto ) as monto "
                . "FROM detallecotizacion,  producto, cotizacion WHERE "
                . "producto.codigo = codProducto AND "
                . "cotizacion.codigo = codCotizacion "
                . "$where "
                . "GROUP BY codProducto");
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

    // ---------------------------------------- GRAFICAS -------------------------------------------------

    public function totalCotizaciones() {
        $query = $this->query("SELECT COUNT(*) AS total FROM `cotizacion`");
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
                . "FROM cotizacion "
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

    public function cotizacionAno($ano) {
        $query = $this->query("SELECT "
                . "SUM(subtotal) AS r,"
                . "MONTH(fecha) AS mes "
                . "FROM cotizacion WHERE "
                . "YEAR(fecha)=$ano AND "
                . "estatus = 2 "
                . "GROUP BY mes");
        $pen = array();
        while ($row = $query->fetch_array()) {
            // $pen[] = (float) $row['r'];
            $pen[(int) $row['mes']] = (float) $row['r'];
        }
        return $this->getResponse($pen);
    }

    public function cotizacionMes($ano, $mes) {
        $query = $this->query("SELECT "
                . "SUM(subtotal) AS r, "
                . "DAY(fecha) as dia "
                . "FROM cotizacion WHERE "
                . "MONTH(fecha)=$mes AND "
                . "YEAR(fecha)=$ano AND "
                . "estatus > 0 "
                . "GROUP BY dia");
        $pen = array();
        while ($row = $query->fetch_array()) {
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
