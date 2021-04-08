<?php

class facturacion {

    //put your code here
    function __construct() {

        require "../config/conexion.php";
    }

    function listar() {
        $pen = array();
        $sql = "SELECT factura.codigo as codFact, fecha,telefono, nombre,total,factura.estatus as status  FROM factura,cliente WHERE factura.cod_cliente = cliente.codigo order by fecha DESC ";
        $query = $con->query($sql);
        while ($row = mysqli_fetch_array($query)) {
            $detalle = array();
            $sql = $con->query('SELECT codProducto FROM detallefactura WHERE codFactura = ' . $row['codFact'])or die(mysqli_error());
            while ($row2 = $sql->fetch_array()) {
                $detalle[] = $row2['codProducto'];
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

}
