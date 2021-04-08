<?php
 include '../../config/seccion.php';
  if(empty($_SESSION['usuario']))
  {
    header('Location: index.php');
  }  




		/* Conectar a la base de datos*/
		include '../../config/conexion.php';

		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["nombre"],ENT_QUOTES)));
		$nivel=mysqli_real_escape_string($con,(strip_tags($_POST["nivel"],ENT_QUOTES)));
		$clave=mysqli_real_escape_string($con,(strip_tags($_POST["clave"],ENT_QUOTES)));
		$correo=mysqli_real_escape_string($con,(strip_tags($_POST["correo"],ENT_QUOTES)));

		$sql = $con->query("SELECT *from usuario WHERE correo = '$correo'");

		if ($row=$sql->fetch_array()) 
		{

			if(empty($clave))
			{
				$sql="UPDATE usuario set nombre = UPPER('$nombre'), nivel = '$nivel' where correo = '$correo' ";	
			}
			else
			{
				//encriptar contraseña para guardar en la base de datos
				$clave = crypt($clave);
				$sql="UPDATE usuario set nombre = '$nombre', nivel = '$nivel', clave = '$clave' where correo = '$correo' ";					
				}


			$query = $con->query($sql);
				if ($query){
					$messages[] = "Usuario modificado satisfactoriamente.";
					$_SESSION['usuario'] = $nombre;
				}			
		}
		else 
		{			
			$errors[] = "No esta permitido modificar el correo de usuario.";	
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