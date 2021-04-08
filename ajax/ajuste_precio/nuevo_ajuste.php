<?php
 include '../../config/seccion.php';
  if(empty($_SESSION['usuario']))
  {
    header('Location: index.php');
  }  




		/* Conectar a la base de datos*/
		include '../../config/conexion.php';

		$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

		if (isset($_POST['id']))
		{


			$id_producto=$_POST['id'];
			$precio1=$_POST['precio1'];
			$precio2=$_POST['precio2'];
			$precio3=$_POST['precio3'];

			$sql="update producto set precio1='".$precio1."',precio2='".$precio2."',precio3='".$precio3."' where codigo='".$id_producto."'";

			if ($result=$con->query($sql)){
				?>
				<div class="alert alert-success alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <strong>¡Aviso!</strong> Precio del producto modificado exitosamente.
				</div>
				<?php

                //Se guarda el cambio en la tabla configuracion como historial
                $cod_usuario = $_SESSION['id_usuario'];
                $con->query("INSERT into configuracion VALUES ('', $cod_usuario, 'ajuste de precios', NOW())");

			}else {
				?>
				<div class="alert alert-danger alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  <strong>Error!</strong> No se pudo modificar el precio del producto.
				</div>
				<?php
				echo $sql;
			}

		}

		if($action == 'individual')
		{

			$precio1=mysqli_real_escape_string($con,(strip_tags($_POST["precio1"],ENT_QUOTES)));
			$precio2=mysqli_real_escape_string($con,(strip_tags($_POST["precio2"],ENT_QUOTES)));
			$precio3=mysqli_real_escape_string($con,(strip_tags($_POST["precio3"],ENT_QUOTES)));

			if($precio1!="")
			{	
				$sql1="UPDATE producto SET precio1 = $precio1";
				$query1 = $con->query($sql1);
			}
			if($precio2!="")
			{	
				$sql2="UPDATE producto SET precio2 = $precio2";
				$query2 = $con->query($sql2);
			}
			if($precio3!="")
			{	
				$sql3="UPDATE producto SET precio3 = $precio3";
				$query3 = $con->query($sql3);
			}		
			
				if ($precio1!="" || $precio2!="" || $precio3!=""){
					$messages[] = "Se ha modificado el precio de todos los productos.";

					//Se guarda el cambio en la tabla configuracion como historial
                    $cod_usuario = $_SESSION['id_usuario'];
                    $con->query("INSERT into configuracion VALUES ('', $cod_usuario, 'ajuste de precios, individual', NOW())");
				}
				else
					$errors[] = "Debe ingresar un valor para algún precio.";

				if (isset($errors)){
					
					?>
					<div class="alert alert-danger" role="alert">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<strong>¡Error!</strong>
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
							<strong>¡Ajuste con exito!</strong>
							<?php
								foreach ($messages as $message) {
										echo $message;
									}
								?>
					</div>
					<?php
				}
		}
		elseif($action=='general')
		{
			$precio=mysqli_real_escape_string($con,(strip_tags($_POST["precio"],ENT_QUOTES)));
			if($precio!="")
			{	
				$sql1="UPDATE producto SET precio1 = precio1 + $precio, precio2 = precio2 + $precio, precio3 = precio3 + $precio ";
				$messages[] = "Se ha modificado el precio de todos los productos.";
				$query1 = $con->query($sql1);

                //Se guarda el cambio en la tabla configuracion como historial
                $cod_usuario = $_SESSION['id_usuario'];
                $con->query("INSERT into configuracion VALUES ('', $cod_usuario, 'ajuste de precios de todos los productos', NOW())");
			}
			else
				$errors[] = "Debe ingresar un valor.";
				

				if (isset($errors)){
					
					?>
					<div class="alert alert-danger" role="alert">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<strong>¡Error!</strong>
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
							<strong>¡Ajuste con exito!</strong>
							<?php
								foreach ($messages as $message) {
										echo $message;
									}
								?>
					</div>
					<?php
				}			

		}

?>