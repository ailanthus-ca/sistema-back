<?php
session_start();
include '../../config/conexion.php';
$query = $con->query("select * from dolares order by id desc limit 1") or die(array("st"=>0,"msn"=>$con->error));
$valor = $query->fetch_array();
echo json_encode(array("st"=>1,"data"=>$valor));