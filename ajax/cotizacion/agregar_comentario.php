<?php
	
	if (isset($_POST['id'])){$id=$_POST['id'];}
	if (isset($_POST['comentario'])){$comentario=$_POST['comentario'];}

	session_start();
	$id_usuario = $_SESSION['id_usuario'];
	

	include '../../config/conexion.php';
	
	$query = $con->query("update tmp_cot_prod set descripcion_tmp = '$comentario' 
                                WHERE id_producto = '$id' AND usuario_tmp = '$id_usuario'");

?>
<!--
	<div class="alert alert-success" role="alert">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>¡Comentario agregado!</strong>
		Se ha agregado el comentario exitosamente
	</div>
-->	

<?php 
	mysqli_close($con);

?>