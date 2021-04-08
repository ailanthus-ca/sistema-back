<?php
 include '../../config/seccion.php';
  if(empty($_SESSION['usuario']))
  {
    header('Location: index.php');
  }  




		/* Conectar a la base de datos*/
		include '../../config/conexion.php';

		$codigo=mysqli_real_escape_string($con,(strip_tags($_POST["codigo"],ENT_QUOTES)));
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["nombre"],ENT_QUOTES)));
		$correo=mysqli_real_escape_string($con,(strip_tags($_POST["correo"],ENT_QUOTES)));
		$telefono=mysqli_real_escape_string($con,(strip_tags($_POST["telefono"],ENT_QUOTES)));
		$direccion=mysqli_real_escape_string($con,(strip_tags($_POST["direccion"],ENT_QUOTES)));
		$contacto=mysqli_real_escape_string($con,(strip_tags($_POST["contacto"],ENT_QUOTES)));

		$sql = $con->query("SELECT *from proveedor WHERE codigo = '$codigo'");

		if ($row=$sql->fetch_array()) 
		{

			$sql = "UPDATE proveedor SET nombre = UPPER('$nombre'), correo = UPPER('$correo'), telefono = '$telefono', direccion = UPPER('$direccion'), contacto = UPPER('$contacto') WHERE codigo = '$codigo' ";
			$query = $con->query($sql);
				if ($query){
					$messages[] = "Proveedor modificado satisfactoriamente.";
				}			
		}
		else 
		{			
			$errors[] = "No esta permitido modificar el codigo del proveedor.";	
		}


		
		if (isset($errors)){
			
			?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong> 
					<?php
						foreach ($errors as $error) {
								echo $error;
							}
						?>
			</div>
			<?php
			}
			if (isset($messages)){
				
				?>
				<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>¡Operación exitosa!</strong>
						<?php
							foreach ($messages as $message) {
									echo $message;
								}
							?>
				</div>
				<?php
			}

?>