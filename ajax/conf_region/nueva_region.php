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

			$cod_fiscal=mysqli_real_escape_string($con,(strip_tags($_POST["cod_fiscal"],ENT_QUOTES)));
			$moneda=mysqli_real_escape_string($con,(strip_tags($_POST["moneda"],ENT_QUOTES)));
			$impuesto=mysqli_real_escape_string($con,(strip_tags($_POST["impuesto"],ENT_QUOTES)));
			$imp_esp=mysqli_real_escape_string($con,(strip_tags($_POST["impuesto_esp"],ENT_QUOTES)));
			$impuesto1 = (isset($_POST['impuesto1'])&& $_POST['impuesto1'] !=NULL)?$_POST['impuesto1']:'0.00';
			$impuesto2 = (isset($_POST['impuesto2'])&& $_POST['impuesto2'] !=NULL)?$_POST['impuesto2']:'0.00';
			$monto1 = (isset($_POST['hasta'])&& $_POST['hasta'] !=NULL)?$_POST['hasta']:'0.00';
			$monto2 = (isset($_POST['mayor'])&& $_POST['mayor'] !=NULL)?$_POST['mayor']:'0.00';



			if($cod_fiscal!="" && $moneda!="" && $impuesto!="")
			{	
				$sql1="UPDATE conf_region SET codigo_fiscal = UPPER('$cod_fiscal'), moneda = '$moneda', impuesto = $impuesto, imp_esp = $imp_esp, impuesto1 = $impuesto1, monto1 = $monto1, impuesto2 = $impuesto2, monto2 = $monto2";
				$query1 = $con->query($sql1);
				$messages[] = "Se ha registrado correctamente el ajuste";

                //Se guarda el cambio en la tabla configuracion como historial
                $cod_usuario = $_SESSION['id_usuario'];
                $con->query("INSERT into configuracion VALUES ('', $cod_usuario, 'configuracion de region', NOW())");
			}
			else
				$errors[] = "Ocurrio un error durante la operación";

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
		else

?>