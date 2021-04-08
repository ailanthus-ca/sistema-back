<?php
session_start();
include '../../config/conexion.php';
$type = $_REQUEST["type"];
$inicio=$_REQUEST["inicio"];
$fin=$_REQUEST["fin"];

$query = $con->query("") or die(array("st"=>0,"msn"=>$con->error));
foreach($query->fetch_array() as $t){

}
echo json_encode(array("st"=>1,"data"=>$valor));