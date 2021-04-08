<?php

class compra {

    //put your code here
    function __construct() {

        require "../config/conexion.php";
    }

    function listar() {
        $pen = array();
        $sql = "SELECT compra.codigo as codFact,telefono, fecha, nombre,total,compra.estatus as status  FROM compra,proveedor WHERE compra.cod_proveedor = proveedor.codigo order by fecha DESC ";
        $query = $con->query($sql);
        while ($row = mysqli_fetch_array($query)) {
            $detalle = array();
            $sql = $con->query('SELECT cod_producto FROM detallecompra WHERE cod_compra = ' . $row['codFact'])or die(mysqli_error());
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

}
