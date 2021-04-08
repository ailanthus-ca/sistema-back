<?php
 include '../../config/seccion.php';
  if(empty($_SESSION['usuario']))
  {
    header('Location: index.php');
  }  




		/* Conectar a la base de datos*/
		include '../../config/conexion.php';

		$codigo=mysqli_real_escape_string($con,(strip_tags($_POST["codigo"],ENT_QUOTES)));
		$descripcion=mysqli_real_escape_string($con,(strip_tags($_POST["descripcion"],ENT_QUOTES)));
		$tipo=mysqli_real_escape_string($con,(strip_tags($_POST["tipo"],ENT_QUOTES)));
		$unidad=mysqli_real_escape_string($con,(strip_tags($_POST["unidad"],ENT_QUOTES)));
		$costo=mysqli_real_escape_string($con,(strip_tags($_POST["costo"],ENT_QUOTES)));
		$precio1=mysqli_real_escape_string($con,(strip_tags($_POST["porcentaje1"],ENT_QUOTES)));
		$precio2=mysqli_real_escape_string($con,(strip_tags($_POST["porcentaje2"],ENT_QUOTES)));
		$precio3=mysqli_real_escape_string($con,(strip_tags($_POST["porcentaje3"],ENT_QUOTES)));

		if (isset($_POST['enser']))
			{
				$enser=$_POST['enser'];
			}
		else
			$enser=0;	

		$sql = $con->query("SELECT *from producto WHERE codigo = '$codigo'");

		if ($row=$sql->fetch_array()) 
		{

			$sql = "UPDATE producto SET descripcion = UPPER('$descripcion'), tipo = UPPER('$tipo'), enser = '$enser', unidad = UPPER('$unidad'), costo = $costo, precio1 = $precio1, precio2 = $precio2, precio3 = $precio3 WHERE codigo = '$codigo' ";
			$query = $con->query($sql);
				if ($query){
					$messages[] = "Producto modificado satisfactoriamente.";
				}			
		}
		else 
		{			
			$errors[] = "No esta permitido modificar el codigo del producto.";	
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