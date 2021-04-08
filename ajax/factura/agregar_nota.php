<?php

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $nota = $id;
}
$porc_impuesto = (isset($_POST['porc_impuesto']) && $_POST['porc_impuesto'] != NULL) ? $_POST['porc_impuesto'] : '';
include '../../config/conexion.php';
$con->query("truncate table tmp_fact_prod")or die($con->error);
if (!empty($id)) {
    $productos = array();
    $sql = $con->query("select * from detallesNotas where nota = '$id'")or die($con->error);
    while ($row = $sql->fetch_array()) {
        $producto = $row['producto'];
        $cantidad = $row['cantidad'];
        $precio = $row['precio'];
        $con->query("INSERT INTO `tmp_fact_prod` VALUES (null, '$producto', $cantidad, $precio, null)")or die($con->error);
    }
}
include 'calcular_factura.php';
