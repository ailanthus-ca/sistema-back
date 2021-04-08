<?php

class Ordenes {

    function __construct() {

    }

    function listar() {
        require "../config/conexion.php";
        $pen = array();
        $sql = "SELECT ordencompra.codigo as codFact,telefono, fecha, nombre,total,ordencompra.estatus as status  FROM ordencompra,proveedor WHERE ordencompra.cod_proveedor = proveedor.codigo order by fecha DESC ";
        $query = $con->query($sql);
        while ($row = mysqli_fetch_array($query)) {
            $detalle = array();
            $sql = $con->query('SELECT cod_producto FROM detalleordencompra WHERE cod_orden = ' . $row['codFact'])or die(mysqli_error());
            while ($row2 = $sql->fetch_array()) {
                $detalle[] = $row2['cod_producto'];
            }
            $pen[] = array(
                'codigo' => $row['codFact'],
                'fecha' => $row['fecha'],
                'nombre' => $row['nombre'],
                'telefono' => $row['telefono'],
                'monto' => (float) $row['total'],
                'status' => $row['status'],
                'detalles' => $detalle
            );
        }
        echo json_encode($pen);
    }

    function detalles() {
        require "../config/conexion.php";
        $id = $_REQUEST['id'];
        $sql = "SELECT ordencompra.codigo as cod_orden, fecha, nombre,telefono,correo, ordencompra.estatus as estatus_orden,total,contacto  FROM  ordencompra, proveedor where ordencompra.codigo = $id and ordencompra.cod_proveedor = proveedor.codigo";
        $query = $con->query($sql);
        $datos = array();
        while ($row = mysqli_fetch_array($query)) {
            $detalles = array();
            $orden = array(
                'cod_orden' => $row['cod_orden'],
                'fecha' => date("d/m/Y", strtotime($row['fecha'])),
                'nombre_cliente' => $row['nombre'],
                'telefono_cliente' => $row['telefono'],
                'contacto' => $row['contacto'],
                'email_cliente' => $row['correo'],
                'estado_factura' => $row['estatus_orden'],
                'total_venta' => (float) $row['total']
            );
            $sql = $con->query("SELECT cod_producto,detalleordencompra.cantidad,detalleordencompra.monto,producto.descripcion from detalleordencompra,producto where cod_orden = $id and producto.codigo =cod_producto");
            while ($row = $sql->fetch_array()) {
                $detalles[] = array(
                    'codigo' => $row['cod_producto'],
                    'cantidad' => (int) $row['cantidad'],
                    'monto' => (float) $row['monto'],
                    'descripcion' => $row['descripcion'],
                );
            }
            $orden['detalles'] = $detalles;
            $datos[] = $orden;
        }
        echo json_encode($orden);
    }

    function nuevo() {
        require "../config/conexion.php";
        //$data = json_decode($_POST['data']);
        //echo json_encode($_REQUEST['data']);
        $data = file_get_contents('php://input');
        //  var_dump(json_decode($data, true));
        $data = (json_decode($data, true));
        $proveedor = $data['proveedor'];
        $subtotal = $data['subtotal'];
        $impuesto = $data['impuesto'];
        $total = $data['total'];
        $forma_pago = $data['forma_pago'];
        $tiempo_entrega = $data['tiempo_entrega'];
        $validez = $data['validez'];
        $otros = $data['otros'];
        $detalles = $data['detalles'];

        $sql = $con->query("INSERT INTO ordencompra VALUES (null,UPPER('$proveedor'),'" . date('Y-m-d') . "',$subtotal,$impuesto,$total, UPPER('$forma_pago'), UPPER('$tiempo_entrega'), UPPER('$validez'), UPPER('$otros'), 1)")or die(mysqli_error());
        $id_cotizacion_ult = mysqli_insert_id();

        foreach ($detalles as $pro) {
            $con->query("INSERT INTO detalleordencompra VALUES ('$id_cotizacion_ult','" . $pro['id'] . "','" . $pro['cantidad'] . "','" . $pro['precio'] . "', '" . $pro['precio'] * $pro['cantidad'] . "') ")or die(mysqli_error());
        }



        // $sql = $con->query("INSERT INTO ordencompra VALUES (null,UPPER('$data->proveedor'),'" . date('Y-m-d') . "',$data->subtotal,$data->impuesto,$data->total, UPPER('$data->forma_pago'), UPPER('$data->tiempo_entrega'), UPPER('$data->validez'), UPPER('$data->otros'), 1)")or die(mysqli_error());
        // $id_cotizacion_ult = mysqli_insert_id();
        // $detalles = $data->detalles;
        // foreach ($detalles as $pro) {
        //     $con->query("INSERT INTO detalleordencompra VALUES ('$id_cotizacion_ult','" . $pro->id . "','" . $pro->cantidad . "','" . $pro->precio . "', '" . $pro->precio * $pro->cantidad . "') ")or die(mysqli_error());
        // }
    }

}
