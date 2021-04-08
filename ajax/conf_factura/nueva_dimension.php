<?php
 include '../../config/seccion.php';
  if(empty($_SESSION['usuario']))
  {
    header('Location: index.php');
  }  




		/* Conectar a la base de datos*/
		include '../../config/conexion.php';


		$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

		if($action == 'ajax')
		{

			$sql = $con->query("SELECT *from conf_factura");
		 		if($row = $sql->fetch_array())
		 		{
					$pagina =mysqli_real_escape_string($con,(strip_tags($_POST["pagina"],ENT_QUOTES)));
					$top    =mysqli_real_escape_string($con,(strip_tags($_POST["top"],ENT_QUOTES)));
					$right  =mysqli_real_escape_string($con,(strip_tags($_POST["right"],ENT_QUOTES)));
					$left   =mysqli_real_escape_string($con,(strip_tags($_POST["left"],ENT_QUOTES)));
					$bottom =mysqli_real_escape_string($con,(strip_tags($_POST["bottom"],ENT_QUOTES)));
					$observacion =mysqli_real_escape_string($con,(strip_tags($_POST["observacion"],ENT_QUOTES)));

					$sql="UPDATE conf_factura set tipo_papel = '$pagina', margen_sup = '$top', margen_inf = '$bottom', margen_izq = '$left', margen_der = '$right', observacion = '$observacion'";
					$query = $con->query($sql);
					$messages[] = "Se ha modificado la factura correctamente.";

                    //Se guarda el cambio en la tabla configuracion como historial
					$cod_usuario = $_SESSION['id_usuario'];
                    $con->query("INSERT into configuracion VALUES ('', $cod_usuario, 'configuracion de factura, dimension', NOW())");
		 		}


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