<?php

session_start();
$user = $_SESSION['id_usuario'];
include '../../config/conexion.php';
$producto = (isset($_POST['producto']) && $_POST['producto'] != NULL) ? $_POST['producto'] : 'null';
$cantidad = (isset($_POST['cantidad']) && $_POST['cantidad'] != NULL) ? $_POST['cantidad'] : 'null';
$precio = (isset($_POST['precio']) && $_POST['precio'] != NULL) ? $_POST['precio'] : 'null';
$sql = $con->query("select * FROM `tempnotas` WHERE `productor`='$producto' AND `usuario`=$user");
if ($row = $sql->fetch_array()) {
    $con->query("UPDATE `tempnotas` SET `catidad`=$cantidad,`precio`=$precio WHERE `productor`='$producto' AND `usuario`=$user");
} else {
    $con->query("INSERT INTO `tempnotas`(`productor`, `catidad`, `precio`, `usuario`) VALUES ('$producto',$cantidad,$precio,$user)")or die($con->error);
}
include './eproducto.php';
