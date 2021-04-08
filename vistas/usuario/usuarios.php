<?php

 include '../templates/template.php';
 include '../../config/conexion.php';
if ($_SESSION['nivel']==1)
{
    header('Location: panel_us');
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>

  </head>
  <br><br><br>
  <body> 
    <div class="col-md-10 col-md-offset-1">
		<div class="panel panel-info">
		<div class="panel-heading">
		    <div class="btn-group pull-right">
				<a href="nuevo_usuario" class="btn btn-info"><span class="glyphicon glyphicon-plus" ></span> Nuevo Usuario</a>
			</div>
			<h4><i class='glyphicon glyphicon-search'></i> Buscar usuario</h4>
		</div>
			<div class="panel-body">
			<?php 
				include("../modals/editar_usuario.php");
			?>	
					<form class="form-horizontal" role="form" id="datos_compra">
				
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">Nombre o correo</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="Ingrese el nombre o correo del usuario" onkeyup='load(1);'>
							</div>
							
							
							
							<div class="col-md-3">
								<button type="button" class="btn btn-default" onclick='load(1);'>
									<span class="glyphicon glyphicon-search" ></span> Buscar</button>
								<span id="loader"></span>
							</div>
							
						</div>
				
				
				
			</form>
				<div id="resultados"></div><!-- Carga los datos ajax -->
				<div class='outer_div'></div><!-- Carga los datos ajax -->
			</div>
		</div>	
		
	</div>
	<hr>
	<?php
	include("../templates/template_footer.php");
	?>
	<script type="text/javascript" src="./js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="./js/usuarios.js"></script>
  </body>
</html>