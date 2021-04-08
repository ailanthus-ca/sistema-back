<?php

session_start();
$user = $_SESSION['id_usuario'];
include '../../config/conexion.php';
$cliente = (isset($_POST['codigo_cliente']) && $_POST['codigo_cliente'] != NULL) ? $_POST['codigo_cliente'] : 'null';
$nota = (isset($_POST['nota']) && $_POST['nota'] != NULL) ? $_POST['nota'] : 'null';
$cotizacion = (isset($_POST['cotizacion']) && $_POST['cotizacion'] != NULL) ? $_POST['cotizacion'] : 'null';
if ($cotizacion > 0) {
    $sql = $con->query("UPDATE cotizacion SET estatus = 2 WHERE codigo = '$cotizacion' ") or die("producto SELECT $productor: " . $con->error);
    $sql = $con->query("select usuario from cotizacion WHERE codigo = '$cotizacion'") or die("producto SELECT $productor: " . $con->error);
    if ($row = $sql->fetch_array()) {
        $user_id = $row['usuario'];
    }
} else {
    $user_id = $_SESSION['id_usuario'];
}
$sql = $con->query("SELECT * FROM `tempnotas`WHERE `usuario`=$user")or die($con->error);
$total = 0;
while ($row = $sql->fetch_array()) {
    $total += ($row['precio'] * $row['catidad']);
}
$con->query("INSERT INTO `notasalida` VALUES (null,'$cliente',NOW(),$total,'$nota',1,$user_id)")or die($con->error);
$codigo = $con->insert_id;
$sql2 = $con->query("SELECT * FROM `tempnotas`WHERE `usuario`=$user")or die("SELECT tempnotas: " . $con->error);
while ($row2 = $sql2->fetch_array()) {
    $precio = $row2['precio'];
    $catidad = $row2['catidad'];
    $productor = $row2['productor'];
    $con->query("INSERT INTO `detallesNotas` VALUES ($codigo,'$productor',$catidad,$precio)")or die($con->error);
    $sql_pro = $con->query("SELECT tipo from producto WHERE codigo = '$productor' ") or die("producto SELECT $productor: " . $con->error);
    $row_pro = $sql_pro->fetch_array();
    $tipo = $row_pro['tipo'];
    if ($tipo == "1") {
        $con->query("UPDATE producto set cantidad = cantidad - ($catidad) WHERE codigo = '$productor' ") or die("producto UPDATE $productor: " . $con->error);
    }
}
echo $codigo;
