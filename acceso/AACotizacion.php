<?php

class cotizacion {

    function __construct() {

        require "../config/conexion.php";
    }

    function pendientes() {
        $pen = array();
        $sql = "SELECT cotizacion.codigo as codFact, fecha, nombre,total  FROM cotizacion,cliente WHERE cotizacion.cod_cliente = cliente.codigo and cotizacion.estatus = 1 order by fecha desc ";
        $query = $con->query($sql);
        while ($row = mysqli_fetch_array($query)) {
            $fecha = date("d/m/Y", strtotime($row['fecha']));
            $pen[] = array(
                'codigo' => $row['codFact'],
                'fecha' => $fecha,
                'nombre' => $row['nombre'],
                'monto' => (float) $row['total'],
            );
        }
        echo json_encode($pen);
    }

    function listar() {
        $sql = "SELECT cotizacion.codigo as codFact, fecha, nombre,telefono,total,cotizacion.estatus as status  FROM cotizacion,cliente WHERE cotizacion.cod_cliente = cliente.codigo order by fecha desc "or die(mysqli_error());
        $query = $con->query($sql);
        $pen = array();
        while ($row = mysqli_fetch_array($query)) {
            $detalle = array();
            $sql = $con->query('SELECT codProducto FROM detallecotizacion WHERE codCotizacion = ' . $row['codFact'])or die(mysqli_error());
            while ($row2 = $sql->fetch_array()) {
                $detalle[] = $row2['codProducto'];
            }
            $pen[] = array(
                'codigo' => $row['codFact'],
                'fecha' => date("d/m/Y", strtotime($row['fecha'])),
                'nombre' => $row['nombre'],
                'telefono' => $row['telefono'],
                'monto' => (float) $row['total'],
                'status' => $row['status'],
                'detalles' => $detalle
            );
        }
        echo json_encode($pen);
    }

    public function detalles($id) {
        $comentario;
        $detalle = array();
        $cliente = array();
        $sql = $con->query('SELECT cod_cliente from cotizacion WHERE codigo = ' . $id);
        while ($row = $sql->fetch_array()) {
            $cod = $row['cod_cliente'];
        }
        //detalles
        $sql = $con->query('SELECT detallecotizacion.codProducto,producto.descripcion,detallecotizacion.cantidad,detallecotizacion.monto,detallecotizacion.comentario FROM detallecotizacion,producto WHERE detallecotizacion.codCotizacion = ' . $id . ' and detallecotizacion.codProducto = producto.codigo');
        while ($row = $sql->fetch_array()) {
            $detalle[] = array(
                'codigo' => $row['codProducto'],
                'descripcion' => $row['descripcion'],
                'cantidad' => (int) $row['cantidad'],
                'monto' => (float) $row['monto'],
                'comentario' => $row['comentario']
            );
        }
        //cliente
        $sql = $con->query("SELECT nombre,telefono,direccion,contacto FROM cliente WHERE codigo='$cod'");
        while ($row = $sql->fetch_array()) {
            $cliente[] = array(
                'nombre' => $row['nombre'],
                'telefono' => $row['telefono'],
                'direccion' => $row['direccion'],
                'contacto' => $row['contacto']
            );
        }
        //comentario
        $sql = $con->query('SELECT * FROM cotizacion_seguimiento WHERE cod_cotizacion = ' . $id . ' ORDER BY  `cotizacion_seguimiento`.`id` DESC limit 0,1');
        if ($row = $sql->fetch_array()) {
            $comentario = $row['descripcion'];
        } else {
            $comentario = '';
        }


        $cotizacion = array(
            'detalle' => $detalle,
            'comentario' => $comentario,
            'cliente' => $cliente
        );
        echo json_encode($cotizacion);
    }

    function nuevo() {
        $data = file_get_contents('php://input');
        //  var_dump(json_decode($data, true));
        $data = (json_decode($data, true));
        $cliente = $data['cliente'];
        $subtotal = $data['subtotal'];
        $impuesto = $data['impuesto'];
        $total = $data['total'];
        $forma_pago = $data['forma_pago'];
        $tiempo_entrega = $data['tiempo_entrega'];
        $validez = $data['validez'];
        $otros = $data['otros'];
        $detalles = $data['detalles'];
        $user = $_SESSION['id_usuario'];
        echo json_encode($data);
        echo json_encode($user);
        $sql = $con->query("INSERT INTO cotizacion VALUES (null,UPPER('$cliente'),'" . date('Y-m-d') . "',$impuesto,$subtotal,$total, UPPER('$forma_pago'), UPPER('$tiempo_entrega'), UPPER('$validez'), UPPER('$otros'), 1,$user)")or die(mysqli_error());
        $id_cotizacion_ult = mysqli_insert_id();

        foreach ($detalles as $pro) {
            $con->query("INSERT INTO detallecotizacion VALUES ('$id_cotizacion_ult','" . $pro['id'] . "','" . $pro['cantidad'] . "','" . $pro['precio'] . "', '" . $pro['precio'] * $pro['cantidad'] . "', '" . $pro['descripcion'] . "') ")or die(mysqli_error());
        }
    }

    /*function nuevo_victor() {
        if (isset($_POST['data'])) {
            $data = json_decode($_POST['data']);
            $fecha = date('Y-m-d');
            $con->query("INSERT into cotizacion values(null,UPPER('$data->cliente'), '$fecha', $data->impuesto, $data->subtotal, $data->total, UPPER('$data->forma_pago'), UPPER('$data->tiempo_entrega'), UPPER('$data->validez'), UPPER('$data->otros'), 1,13)")or die(mysqli_error());
            $cotizacion = mysqli_insert_id();
            $detalles = $data->detalles;
            foreach ($detalles as $pro) {
                $con->query("INSERT INTO detallecotizacion VALUES ('$cotizacion','" . $pro->id . "','" . $pro->cantidad . "', '" . $pro->precio . "', '" . ($pro->precio * $pro->cantidad ) . "', '" . $pro->descripcion . "') ")or die(mysqli_error());
                if ($data->tmp != "-1") {
                    $con->query("DELETE FROM tmp_cotizacion WHERE codigo=$data->tmp")or die(mysqli_error());
                    $con->query("DELETE FROM tmp_detalle_cotizacion WHERE codCotizacion = $data->tmp")or die(mysqli_error());
                }
            }
            echo json_encode($cotizacion);
        }
    }*/

}
?>
