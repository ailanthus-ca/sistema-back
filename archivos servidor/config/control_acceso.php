<?php
	

	/* Conectar a la base de datos*/
	include '../config/conexion.php';

	#se inicia la sesion
	session_start();
	
	$correo= mysqli_real_escape_string((strip_tags($_POST["correo"],ENT_QUOTES)));
	$clave = mysqli_real_escape_string((strip_tags($_POST["clave"],ENT_QUOTES)));

	$sql = $con->query("SELECT *FROM usuario WHERE correo = '$correo' ");
		
		if($user=$sql->fetch_array())
		{
			if($user['clave'] == crypt($clave,$user['clave']) && $user['estatus']==1)
			{
				if($user['nivel']==0)
				{
					$_SESSION['usuario'] = $user['nombre'];
					$_SESSION['nivel'] = $user['nivel'];
					?><script>location.href ="http://ailanthus-sistems.com/sistema//panel_ad.php";</script><?php
				}
				elseif ($user['nivel']==1) 
				{
					$_SESSION['usuario'] = $user['nombre'];
					$_SESSION['nivel'] = $user['nivel'];
					?><script>location.href ="http://ailanthus-sistems.com/sistema//panel_us.php";</script><?php				}
			}
			
			elseif($user['clave'] == crypt($clave,$user['clave']) && $user['estatus']==0)
				{
					$messages[] = "Este usuario se encuentra inactivo. Por favor contacte con el administrador";
				}			
			
			else
			{
				
				$messages[] = "Clave incorrecta";				
			}	
		}

		else
		{
			$errors[] = "El correo no se encuentra registrado. Por favor ingrese un correo válido";
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
				<div class="alert alert-warning" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>¡Advertencia!</strong>
						<?php
							foreach ($messages as $message) {
									echo $message;
								}
							?>
				</div>
				<?php
			}
	
		mysqli_close($con);
?>