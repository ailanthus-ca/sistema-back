<?php

	include '../../config/conexion.php';

	$id = $_GET['id'];

	$sql = $con->query("SELECT *from tmp_cot_prod where id_tmp = $id");

	if ($row = $sql->fetch_array()) 
	{
		$codigo = $row['id_producto'];
		$comentario = $row['descripcion_tmp'];

	}

?>
	
	<div class="row">
		<div class="col-xs-6 col-sm-10 col-md-10 col-lg-10">
			<textarea name="comentario" id="comentario<?php echo $codigo ?>" class="form-control"><?php echo $comentario; ?></textarea>	
		</div>

		<br>
			<button type="button" class="btn btn-info" data-dismiss="modal" onclick="agregarComentario('<?php echo $codigo ?>')">Aplicar</button>
	</div>

	<div class="row">
	
	</div>

<?php
	mysqli_close($con);
?>