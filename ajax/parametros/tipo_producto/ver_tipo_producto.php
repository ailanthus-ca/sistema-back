<?php

session_start();
	include '../../../config/conexion.php';

	$id = $_GET['id'];

  $query = "SELECT descripcion FROM tipo_producto WHERE codigo = $id";

                      
	$sql = $con->query($query);
	if ($row = $sql->fetch_array()) 
	{
		$descripcion = $row['descripcion'];
	}

?>

	  <div class="form-group">
		<label for="descripcion" class="col-sm-3 control-label">Descripción</label>
		<div class="col-sm-8">
			<input type="text" class="form-control" id="edit_descripcion" name="edit_descripcion" placeholder="Descripcion" value="<?php echo $descripcion ?>" required ></input>
      <input type="hidden" name="codigo" value="<?php echo $id ?>">
		  
		</div>
	  </div>


<?php
	mysqli_close($con);
?>