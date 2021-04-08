<?php

include '../../config/conexion.php';
session_start();
$cod_usuario = $_SESSION['id_usuario'];
$delete =$con->query("DELETE from tmp_cot_prod WHERE id_tmp='".$_GET['id']."'");
$cont=$con->query("select * from tmp_cot_prod WHERE usuario_tmp = $cod_usuario");
if($t=mysqli_fetch_array($cont)){
    $chek="true";
}else{
    $chek="false";
}
include 'calcular_ajuste.php';
?>
