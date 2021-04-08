<?php
session_start();
include '../../config/conexion.php';
$valor = $_REQUEST["valor"];
$con->query("INSERT INTO `dolares`(`id`, `valor`, `fecha`) VALUES (null,$valor,NOW())") or die(array("st"=>0,"msn"=>$con->error));
echo json_encode(array("st"=>1,"msn"=>"Nueva tasa Guardada"));