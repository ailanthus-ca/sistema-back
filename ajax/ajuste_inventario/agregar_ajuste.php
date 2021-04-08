<?php
	
if (isset($_POST['id'])){$id                   =$_POST['id'];}
if (isset($_POST['cantidad'])){$cantidad       =$_POST['cantidad'];}
if (isset($_POST['descripcion'])){$descripcion =$_POST['descripcion'];}
	

include '../../config/conexion.php';
	session_start();

if (!empty($id) and !empty($cantidad) and !empty($descripcion)){
    $cod_usuario = $_SESSION['id_usuario'];
	$sql=$con->query("select * from tmp_cot_prod where id_producto = '$id' and usuario_tmp = $cod_usuario")or die('Error SQL Mensaje:' . $con->error);
	if ($row=$sql->fetch_array())
	{
		$con->query("update tmp_cot_prod set cantidad_tmp = $cantidad, descripcion_tmp = '$descripcion' WHERE id_producto = '$id' and usuario_tmp = $cod_usuario")or die('Error SQL Mensaje:' . $con->error);
	}
	else
	{
		$insert_tmp=$con->query("INSERT into tmp_cot_prod (id_producto,cantidad_tmp,descripcion_tmp,usuario_tmp) VALUES ('$id','$cantidad','$descripcion',$cod_usuario)")or die('Error SQL Mensaje:' . $con->error);
	}
    $chek="true";
}
include 'calcular_ajuste.php';
?>
