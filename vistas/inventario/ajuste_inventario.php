<?php

 include '../templates/template.php';
 include '../../config/conexion.php';
 
  //reinicia la tabla temporal
$id = $_SESSION['id_usuario'];
$con->query("DELETE from tmp_cot_prod WHERE usuario_tmp = '$id'");
?>

<br><br><br>
 <div class="col-md-10 col-md-offset-1">
     <div id="mensaje" style="display: none;" class="alert alert-success" role="alert" >
         <button type="button" class="close" data-dismiss="alert">&times;</button>
         <strong>¡Se ha guardado exitosamente!</strong>
     </div>
	<div class="panel panel-info">
		<div class="panel-heading">
			<h4><i class='glyphicon glyphicon-edit'></i> Ajuste de inventario </h4>
		</div>
		<div class="panel-body">
		<?php 
			include("../modals/buscar_productos.php");
			include("../modals/registro_productos_ajuste.php");
			include("../modals/editar_ajuste.php");
		?>
			<form class="form-horizontal" method="post" id="datos_ajuste" name="datos_ajuste">
			<div id="resultados_ajax_ajuste"></div>
			<strong>Datos del ajuste</strong>
			<div class="panel panel-default">
				<div class="panel-body">
						<label for="tipo" class="col-md-1 control-label">Tipo</label>
					<div class="col-md-4">
						<select id="tipo_ajuste" name="tipo_ajuste" class="form-control input-sm" required="">
							<option value="0">-Seleccione el tipo de ajuste-</option>
							<option value="ENTRADA">Entrada</option>
							<option value="SALIDA">Salida</option>
						</select>
					</div>	 	
				</div>				
            </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                <div class="col-md-1">
                    <label>Nota</label>
                </div>
                <div class="col-md-11">
                <input name="nota" type="text" class="form-control" id="nota" placeholder="Nota" maxlength="200" />
                </div>
                    </div>
                </div>
				<div class="col-md-12">
					<div class="pull-right">
						<button type="button" class="btn btn-default" onclick="javascript:window.location.reload();">
						 <span class="glyphicon glyphicon-repeat"></span> Nuevo ajuste
						</button>					
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#nuevoProducto">
						 <span class="glyphicon glyphicon-plus"></span> Nuevo producto
						</button>
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">
						 <span class="glyphicon glyphicon-search" onclick="validarTipo()"></span> Buscar productos
						</button>						
						<button id="guardar_ajuste" type="submit" class="btn btn-default" DISABLED>
						  <span class="glyphicon glyphicon-print"></span> Procesar
						</button>
					</div>	
				</div>
			</form>	
			
		<div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->			
		</div>
	</div>		
		  <div class="row-fluid">
			<div class="col-md-12">
			
	

			
			</div>	
		 </div>

	</div>
	<hr>

		<?php
	include("../templates/template_footer.php");
	?>
	<script type="text/javascript" src="./js/ajuste_inventario.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

  </body>
</html>