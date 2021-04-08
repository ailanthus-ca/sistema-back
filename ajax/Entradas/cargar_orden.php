<?php

session_start();
$user = $_SESSION['id_usuario'];
include '../../config/conexion.php';
$producto = (isset($_POST['id']) && $_POST['id'] != NULL) ? $_POST['id'] : 'null';
$sql = $con->query('SELECT * FROM `detallecotizacion` WHERE codCotizacion=' . $producto)or die($con->error);
while ($row = $sql->fetch_array()) {
    $precio = $row['precio_unit'];
    $catidad = $row['cantidad'];
    $productor = $row['codProducto'];
    $con->query("INSERT INTO `tempnotas` VALUES ('$productor','$catidad',$precio,$user)")or die($con->error);
}
include './eproducto.php';
