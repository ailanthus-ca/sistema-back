<?php

	include '../../config/conexion.php';

	$correo = $_GET['correo'];


	$sql = $con->query("SELECT *from usuario where correo = '$correo' ");
	if ($row = $sql->fetch_array()) 
	{
		$nombre = $row['nombre'];
		$nivel = $row['nivel'];

		if ($nivel == 0)
		{
			$option1 = 'Administrador';
			$option2 = 'Usuario';
			$value1 = 0;
			$value2 = 1;

		}
		elseif ($nivel == 1)
		{
			$option1 = 'Usuario';
			$option2 = 'Administrador';
			$value1 = 1;
			$value2 = 0;
		}	
	}

?>

	  <div class="form-group">
		<label for="nombre" class="col-sm-3 control-label">Nombre</label>
		<div class="col-sm-8">
		  <input type="text" class="form-control" id="nombre_<?php echo $nombre ?>" name="nombre" value="<?php echo $nombre ?>">
		</div>
	  </div>

	  <div class="form-group">
		<label for="correo" class="col-sm-3 control-label">Correo</label>
		<div class="col-sm-8">
		  <input type="text" class="form-control" id="correo_<?php echo $correo ?>" name="correo" value="<?php echo $correo ?>" readonly>
		</div>
	  </div>	  
	  
	  <div class="form-group">
		<label for="Nivel" class="col-sm-3 control-label">Nivel</label>
		<div class="col-sm-8">
			<select class="form-control" name="nivel" id="nivel_"<?php echo $correo ?>>
				<option value="<?php echo $value1 ?>"><?php echo $option1 ?></option>
				<option value="<?php echo $value2 ?>"><?php echo $option2 ?></option>
			</select>
		</div>
	  </div>

	  <div class="form-group">
		<label for="clave" class="col-sm-3 control-label">Cambiar clave</label>
		<div class="col-sm-8">
		  <input type="password" placeholder="Ingrese la nueva clave" class="form-control" id="clave_<?php echo $correo ?>" name="clave">
		</div>
	  </div>

<?php
	mysqli_close($con);
?>