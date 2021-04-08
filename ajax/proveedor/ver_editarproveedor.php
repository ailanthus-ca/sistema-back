<?php

	include '../../config/conexion.php';

	$id = $_GET['id'];


	$sql = $con->query("SELECT *from proveedor where codigo = '$id' ");
	if ($row = $sql->fetch_array()) 
	{
		$codigo = $row['codigo'];
		$nombre = $row['nombre'];
		$telefono = $row['telefono'];
		$correo = $row['correo'];
		$contacto = $row['contacto'];
		$direccion = $row['direccion'];

	}

?>

	  <div class="form-group">
		<label for="codigo" class="col-sm-3 control-label">Código</label>
		<div class="col-sm-8">
		  <input type="text" class="form-control" id="codigo_<?php echo $codigo ?>" name="codigo" value="<?php echo $codigo ?>" readonly>
		</div>
	  </div>

	  <div class="form-group">
		<label for="nombre" class="col-sm-3 control-label">Nombre</label>
		<div class="col-sm-8">
		  <input type="text" class="form-control" id="nombre_<?php echo $codigo ?>" name="nombre" value="<?php echo $nombre ?>">
		</div>
	  </div>

	  <div class="form-group">
		<label for="telefono" class="col-sm-3 control-label">Telefono</label>
		<div class="col-sm-8">
		  <input type="text" class="form-control" id="telefono_<?php echo $codigo ?>" name="telefono" value="<?php echo $telefono ?>">
		</div>
	  </div>

	  <div class="form-group">
		<label for="correo" class="col-sm-3 control-label">Correo</label>
		<div class="col-sm-8">
		  <input type="email" class="form-control" id="correo_<?php echo $codigo ?>" name="correo" value="<?php echo $correo ?>">
		</div>
	  </div>

	  <div class="form-group">
		<label for="contacto" class="col-sm-3 control-label">Contacto</label>
		<div class="col-sm-8">
		  <input type="text" class="form-control" id="contacto_<?php echo $codigo ?>" name="contacto" value="<?php echo $contacto ?>">
		</div>
	  </div>

	  <div class="form-group">
		<label for="direccion" class="col-sm-3 control-label">Dirección</label>
		<div class="col-sm-8">
		  <input type="text" class="form-control" id="direccion_<?php echo $codigo ?>" name="direccion" value="<?php echo $direccion ?>">
		</div>
	  </div>

<?php
	mysqli_close($con);
?>