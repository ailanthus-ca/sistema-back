<?php

	include '../../config/conexion.php';

	$id = $_GET['id'];


	$sql = $con->query("SELECT *from cliente where codigo = '$id' ");
	if ($row = $sql->fetch_array()) 
	{
		$codigo = $row['codigo'];
		$nombre = $row['nombre'];
		$telefono = $row['telefono'];
		$correo = $row['correo'];
		$contacto = $row['contacto'];
		$direccion = $row['direccion'];
		$tipo_contribuyente = $row['tipo_contribuyente'];

	}

?>

<div class="table-responsive">

	  <div class="form-group">
		<label for="codigo" class="col-sm-3 control-label">Código</label>
		<div class="col-sm-8">
		  <input type="text" class="form-control" id="codigo_<?php echo $codigo ?>" name="codigo" value="<?php echo $codigo ?>" readonly>
		</div>
	  </div>

	  <div class="form-group">
		<label for="nombre" class="col-sm-3 control-label">Nombre</label>
		<div class="col-sm-8">
		  <input type="text" class="form-control" id="nombre_<?php echo $codigo ?>" name="nombre" value="<?php echo $nombre ?>" readonly>
		</div>
	  </div>

	  <div class="form-group">
		<label for="telefono" class="col-sm-3 control-label">Telefono</label>
		<div class="col-sm-8">
		  <input type="text" class="form-control" id="telefono_<?php echo $codigo ?>" name="telefono" value="<?php echo $telefono ?>" readonly>
		</div>
	  </div>

	  <div class="form-group">
		<label for="correo" class="col-sm-3 control-label">Correo</label>
		<div class="col-sm-8">
		  <input type="text" class="form-control" id="correo_<?php echo $codigo ?>" name="correo" value="<?php echo $correo ?>" readonly>
		</div>
	  </div>

	  <div class="form-group">
		<label for="contacto" class="col-sm-3 control-label">Contacto</label>
		<div class="col-sm-8">
		  <input type="text" class="form-control" id="contacto_<?php echo $codigo ?>" name="contacto" value="<?php echo $contacto ?>" readonly>
		</div>
	  </div>

	  <div class="form-group">
		<label for="direccion" class="col-sm-3 control-label">Dirección</label>
		<div class="col-sm-8">
		  <input type="text" class="form-control" id="direccion_<?php echo $codigo ?>" name="direccion" value="<?php echo $direccion ?>" readonly>
		</div>
	  </div>

	  <div class="form-group">
		<label for="tipo_contribuyente" class="col-sm-3 control-label">Tipo de contribuyente</label>
		<div class="col-sm-8">
		  <input type="text" class="form-control" id="direccion_<?php echo $codigo ?>" name="tipo_contribuyente" value="<?php echo $tipo_contribuyente ?>" readonly>
		</div>
	  </div>	
</div>	    

<?php
	mysqli_close($con);
?>