<?php

namespace Modelos;

class Factura extends \Prototipo\Operaciones {

    var $estado = 'Factura';
    var $costo = 0;
    var $cod_cliente = '';
    var $porc_impuesto = 0;
    var $condicion = '';
    var $id_cotizacion = 0;
    var $id_nota = 0;
    var $user = 0;

    function fechaCambios() {
        $sql = $this->query('SELECT MAX(actualizado) AS cant FROM factura_lista');
        while ($row = $sql->fetch_array()) {
            return $row['cant'];
        }
        return '';
    }

    public function cambios($fecha, $hora) {
        $pen = array();
        $act = $this->fechaCambios();
        $sol = ($fecha !== '') ? "WHERE `actualizado` > '$fecha $hora'" : '';
        $query = $this->query("SELECT * FROM factura_lista $sol");
        while ($row = $query->fetch_array()) {
            $detalle = array();
            $sql = $this->query('SELECT codProducto FROM detallefactura WHERE codFactura = ' . $row['codFact']);
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


    function lista() {
        $pen = array();
        $sql = "SELECT * FROM factura_lista";
        $query = $this->query($sql);
        while ($row = $query->fetch_array()) {
            $detalle = array();
            $sql = $this->query('SELECT codProducto FROM detallefactura WHERE codFactura = ' . $row['codFact']);
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
                $detalle
            );
        }
        return $this->getResponse($pen);
    }

    function detalles($id) {
        $query = $this->query("SELECT * FROM factura where codigo = $id");
        $factura = array();
        if ($row = $query->fetch_array()) {
            //datos del cliente
            $cliente = new Cliente();
            $factura = $cliente->detalles($row['cod_cliente']);
            $factura['cod_cliente'] = $row['cod_cliente'];
            //datos del usuario
            $usuario = new Usuario();
            $usuario = $usuario->detalles($row['usuario']);
            $factura['usuario'] = $usuario['nombre'];
            $factura['cod_usuario'] = $row['usuario'];
            //datos de la factura
            $factura['codigo'] = $row['codigo'];
            $factura['fecha'] = $row['fecha'];
            $factura['impuesto'] = $row['iva'];
            $factura['condicion'] = $row['condicion'];
            $factura['nota'] = $row['observacion'];
            $factura['tasa'] = 0;
            //detalle de la factura observacion
            $query = $this->query("SELECT * from detallefactura where codFactura = '$id'");
            $producto = new Producto();
            while ($row = $query->fetch_array()) {
                $detalle = $producto->ver($row['codProducto']);
                $detalle['unidades'] = (float) $row['cantidad'];
                $detalle['precio'] = (float) $row['precio_unit'];
                $factura['detalles'][] = $detalle;
            }
            return $this->getResponse($factura);
        }
    }

    function checkCodigo($cod) {
        $sql = $this->query('SELECT count(*) AS exist FROM factura WHERE codigo="' . $cod . '"');
        if ($row = $sql->fetch_array()) {
            return boolval($row['exist']);
        }
    }

    function nuevo() {
        $sql = $this->query('SELECT MAX(codigo) AS cant FROM factura');
        $row = $sql->fetch_array();
        $num_factura = $row['cant'] + 1;
        $sql = $this->query("INSERT into factura values("
                . "$num_factura,"
                . "UPPER('$this->cod_cliente'),"
                . " NOW(),"
                . " NOW(),"
                . " '$this->condicion',"
                . " $this->porc_impuesto,"
                . " $this->costo,"
                . " $this->impuesto,"
                . " $this->subtotal,"
                . " $this->total,"
                . " UPPER('$this->nota'), "
                . "$this->user ,"
                . "2)");

        $producto = new Producto();

        foreach ($this->detalles as $pro) {
            $monto = $pro->unidades * $pro->precio;
            $this->query("INSERT INTO detallefactura VALUES " .
                    "('$num_factura',"
                    . "'$pro->codigo',"
                    . "$pro->unidades,"
                    . "$pro->precio,"
                    . "$monto )");
            $producto->cargar($pro->codigo);
            $producto->cargarStock($pro->codigo);
        }
        $this->actualizarEstado();
        return $this->getResponse($num_factura);
    }

    function cancelar($id) {
        $this->query("UPDATE `factura` SET `estatus`= 0 WHERE codigo = $id");
        $producto = new Producto();
        $query = $this->query("select * from detallefactura where codFactura = $id ");
        while ($row = $query->fetch_array()) {
            $producto->cargarStock($row['codProducto']);
        }
        $this->actualizarEstado();
        return $this->getResponse(1);
    }

    function listaWhere($where) {
        $pen = array();
        $query = $this->query("SELECT "
                . "factura.codigo as codFact,"
                . " fecha,telefono,"
                . " correo,"
                . "contacto,"
                . "nombre,"
                . "total,"
                . "subtotal,"
                . "factura.estatus as status,"
                . "factura.usuario  "
                . "FROM factura,cliente "
                . "WHERE factura.cod_cliente = cliente.codigo"
                . " $where "
                . "order by fecha DESC ");
        while ($row = $query->fetch_array()) {
            $pen[] = array(
                'codigo' => (int) $row['codFact'],
                'fecha' => $row['fecha'],
                'nombre' => $row['nombre'],
                'telefono' => $row['telefono'],
                'correo' => $row['correo'],
                'contacto' => $row['contacto'],
                'monto' => (float) $row['total'],
                'imponible' => (float) $row['subtotal'],
                'usuario' => (int) $row['usuario'],
                'status' => (int) $row['status'],
            );
        }
        return $this->getResponse($pen);
    }

    function listaWithProducto($codigo, $where) {
        $pen = array();
        $query = $this->query("SELECT DISTINCT "
                . "factura.codigo as codFact, "
                . "fecha,telefono, "
                . "correo, "
                . "contacto, "
                . "nombre, "
                . "total, "
                . "factura.estatus as status, "
                . "factura.usuario, "
                . "detallefactura.cantidad, "
                . "detallefactura.precio_unit "
                . "FROM factura, cliente, detallefactura "
                . "WHERE factura.cod_cliente = cliente.codigo "
                . "AND detallefactura.codFactura = factura.codigo "
                . "AND detallefactura.codProducto = '$codigo' "
                . " $where "
                . "order by fecha DESC ");
        while ($row = $query->fetch_array()) {
            $pen[] = array(
                'operacion' => 'FACTURA',
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
                . "detallefactura.codProducto as codigo, "
                . "producto.descripcion as descripcion, "
                . "SUM( detallefactura.cantidad ) as cantidad, "
                . "SUM( detallefactura.monto ) as monto "
                . "FROM detallefactura,  producto, factura WHERE "
                . "producto.codigo = codProducto AND "
                . "factura.codigo = codFactura "
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

    function salidasValidas($codigo, $where = '') {
        $query = $this->query("SELECT "
                . "SUM( cantidad ) as cantidad "
                . "FROM detallefactura, factura WHERE "
                . "codProducto = '$codigo' AND $where "
                . "codigo = codFactura AND "
                . "estatus > 0");
        if ($row = $query->fetch_array()) {
            return (float) $row['cantidad'];
        }
        return 0;
    }

    // ------------------------------------ GRAFICAS ------------------------------------

    public function totalFacturas() {
        $query = $this->query("SELECT COUNT(*) AS total FROM `factura`");
        $pen = 0;
        while ($row = $query->fetch_array()) {
            $pen = (int) $row['total'];
        }
        return $this->getResponse($pen);
    }

    public function torta($where) {
        $query = $this->query("SELECT "
                . "status AS RANK, "
                . "COUNT(status) AS CANT "
                . "FROM factura_lista "
                . "WHERE true $where "
                . "GROUP BY status");
        $pen = array();
        while ($row = $query->fetch_array()) {
            $pen[] = array(
                'cantidad' => (int) $row['CANT'],
                'estatus' => (int) $row['RANK']
            );
        }
        return $this->getResponse($pen);
    }

    public function ventaAno($ano) {
        $query = $this->query("SELECT equilibrio.mes as mes,r as monto,equilibrio.monto as equi FROM equilibrio, (SELECT SUM(subtotal) AS r,MONTH(fecha) AS mes FROM factura WHERE YEAR(fecha)=$ano AND estatus = 2 GROUP BY mes) as f WHERE f.mes=equilibrio.mes AND equilibrio.ano=$ano");
        $pen = array();
        while ($row = $query->fetch_array()) {
            $pen[] = array((int) $row['mes'], (float) $row['monto'], (float) $row['equi']);
        }
        return $this->getResponse($pen);
    }

    public function ventaMes($ano, $mes) {
        $query = $this->query("SELECT "
                . "SUM(subtotal) AS r, "
                . "DAY(fecha) as dia "
                . "FROM factura WHERE "
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
            if (empty($pen[$i]))
                $pen[$i] = 0;
        }
        $data = array();
        foreach ($pen as $key => $value) {
            $data[] = array($key, $value);
        }
        return $this->getResponse($data);
    }

    public function utilidad($ano, $mes) {
        $query = $this->query("SELECT 
            SUM(((subtotal/costo) - 1) * 100) as uti, 
            COUNT(costo) as con
            FROM factura
            WHERE MONTH(fecha) = $mes
            AND estatus = 2
            AND YEAR(fecha) = $ano");
        $prom = 0;
        while ($row = $query->fetch_array()) {
            $uti = (float) $row['uti'];
            $con = (float) $row['con'];
            $prom = round($uti / $con);
        }
        return $this->getResponse($prom);
    }

    public function prueba($ano) {
        $query = $this->query("SELECT `ventas`,`monto`,`equilibrio`.`mes` FROM `mejor_mes`,`equilibrio` 
            WHERE `mejor_mes`.`mes`=`equilibrio`.`mes` 
            AND `mejor_mes`.`año`= $ano AND `equilibrio`.`ano`= $ano");
        $pen = array();
        while ($row = $query->fetch_array()) {
            $pen[] = array(
                $this->numberToMes($row['mes']),
                (int) $row['monto'], //equilibrio
                (int) $row['ventas'], //ventas del mes
            );
        }
        return $this->getResponse($pen);
    }

    public function mes_actual() {
        $mes = date("n");
        $ano = date("Y");
        $query = $this->query("SELECT SUM(subtotal) AS ventas FROM factura WHERE estatus = 2 AND MONTH(fecha)=$mes AND YEAR(fecha)=$ano");
        if ($row = $query->fetch_array()) {
            return (int) $row['ventas'];
        }
        return 0;
    }

    public function mejor_mes() {
        $query = $this->query("SELECT ventas,mes,año FROM mejor_mes,(SELECT MAX(ventas) as v FROM mejor_mes) as m WHERE v=ventas");
        $mejor = array('ventas' => 0, 'mes' => 0, 'ano' => 0);
        if ($row = $query->fetch_array()) {
            $mejor = array('ventas' => (int) $row['ventas'], 'mes' => $this->numberToMes($row['mes']), 'ano' => (int) $row['año']);
        }
        return $mejor;
    }

    public function guardar_mes() {
        $mes = date("n");
        $ano = date("Y");
        if ($mes == 1) {
            $mes = 12;
            $ano = $ano - 1;
        } else {
            $mes = $mes - 1;
        }
        $query = $this->query("SELECT ventas FROM mejor_mes WHERE mes= $mes AND año= $ano");
        if ($row = $query->fetch_array()) {
            
        } else {
            $nota = new Nota();
            $total = $this->mes_actual() + $nota->mes_actual();
            $this->query("INSERT INTO `mejor_mes`(`id`, `ventas`, `mes`, `año`) VALUES (null,$total,$mes,$ano)");
        }
    }

}
