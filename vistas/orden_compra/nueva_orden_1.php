<?php

 include '../templates/template.php';
 include '../../config/conexion.php';

$id_usuario = $_SESSION['id_usuario'];
  //reinicia la tabla temporal que contiene productos de la factura anterior
 $con->query("DELETE FROM tmp_ord_prod  WHERE usuario_tmp = '$id_usuario'");

 $resultado = $con->query("SELECT *from ordencompra order by codigo DESC LIMIT 1");
 //rutina para indicar cual es el numero de la siguiente factura, en formato de 6 digitos
 if($row = mysqli_fetch_array($resultado))
 {
 	$cod_orden = $row['codigo']+1;
 	if(strlen($cod_orden)<2)
    	$cod_orden="00000".$cod_orden;
	if(strlen($cod_orden)<3)
   		$cod_orden="0000".$cod_orden;
	if(strlen($cod_orden)<4)
    	$cod_orden="000".$cod_orden;
    if(strlen($cod_orden)<5)
    	$cod_orden = "00".$cod_orden;
    if(strlen($cod_orden)<6)
    	$cod_orden = "0".$cod_orden;

 }
 else 
 {
 	$cod_orden =1;
 	$cod_orden="00000".$cod_orden; 
}
?>
<br><br><br>
 <div class="col-md-10 col-md-offset-1">
	<div class="panel panel-info">
		<div class="panel-heading">
			<h4><i class='glyphicon glyphicon-shopping-cart'></i> Orden de compra </h4>
		</div>
		<div class="panel-body">
		<?php 
			include("../modals/buscar_productos.php");
			include("../modals/registro_productos.php");
			include("../modals/registro_proveedores.php");
			include("../modals/editar_factura.php");

		?>
			<form class="form-horizontal" role="form" id="datos_orden">
			<strong>Datos del proveedor</strong>
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="form-group row">
				  	<label for="codigo_proveedor" class="col-md-1 control-label">RIF</label>
				  	<div class="col-md-3">
					  <input type="text" class="form-control input-sm" id="codigo_proveedor" name="codigo_proveedor" placeholder="Ingresa el rif o cedula" required>
					  <input id="id_cliente" type='hidden'>
				  	</div>
				  	<label for="nombre_cliente" class="col-md-1 control-label">Nombre</label>
				  	<div class="col-md-3">
					  <input type="text" class="form-control input-sm" id="nombre_proveedor" placeholder="nombre del proveedor" required>
				 	 </div>
				  	<label for="tel1" class="col-md-1 control-label">Teléfono</label>
					<div class="col-md-2">
					<input type="text" class="form-control input-sm" id="tel1" placeholder="Teléfono" readonly required>
					</div>
				 </div>
				 <div class="form-group row">
					<label for="direccion_cliente" class="col-md-1 control-label">Dirección</label>
						<div class="col-md-10">
							<input type="text" class="form-control input-sm" id="direccion_proveedor" placeholder="Dirección" readonly required>
						</div>			 		 	
				 </div>	 	
				</div>				
			</div>
			<strong>Datos de la orden</strong>
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="form-group row">
					<label for="cod_orden" class="col-md-3 control-label">Código</label>
					<div class="col-md-3">
						<input type="text" class="form-control input-sm" id="cod_orden" name="cod_orden" value="<?php echo $cod_orden ?>" readonly>	
					</div>	
						<label for="fecha" class="col-sm-3 control-label">Fecha</label>
						<div class="col-md-3">
							<input type="text" class="form-control input-sm" id="fecha" name="fecha" value="<?php echo Date('d-m-Y') ?>" readonly>
						</div>
					</div>	
				</div>
			</div>

			<a data-toggle="collapse" data-target="#cond" class="btn btn-info"><span class="glyphicon glyphicon-chevron-down" ></span>Condiciones</a>
			<div id="cond" class="collapse" class="panel panel-default">
				<div class="panel-body">
					<div class="form-group row">
						<label for="condiciones" class="col-md-3 control-label">Forma de pago</label>
						<div class="col-md-3">
							<input type="text" name="forma_pago" id="forma_pago" name="forma_pago" class="form-control input-sm">
						</div>					
						<label for="tiempo_entrega" class="col-md-3 control-label">Tiempo de entrega</label>
						<div class="col-md-3">
							<input type="text" class="form-control input-sm" id="tiempo_entrega" name="tiempo_entrega">	
						</div>				
					</div>
					<div class="form-group row">
						<label for="validez" class="col-md-3 control-label">Validez de la oferta</label>
						<div class="col-md-3">
							<input type="text" class="form-control input-sm" id="validez" name="validez">
						</div>
						<label for="otros" class="col-md-3 control-label">Nota</label>
						<div class="col-md-3">
							<input type="text" class="form-control input-sm" id="otros" name="otros">
						</div>							
					</div>
				</div>					
			</div>
				
				
				<div class="col-md-12">
					<div class="pull-right">
						<button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#nuevoProducto" onclick="limpiar_modal();" data-toggle="tooltip" data-placement="top" title="Nuevo producto">
						 <span class="glyphicon glyphicon-shopping-cart"></span> 
						</button>
						<button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#nuevoProveedor" onclick="limpiar_modal();" data-toggle="tooltip" data-placement="top" title="Nuevo proveedor">
						 <span class="glyphicon glyphicon-user"></span> 
						</button>
						<button type="button" class="btn btn-default btn-lg" data-toggle="modal" onclick="producto();" data-target="#myModal" data-toggle="tooltip" data-placement="top" title="Buscar productos">
						 <span class="glyphicon glyphicon-search"></span> 
						</button>
						<button type="submit" class="btn btn-default btn-lg" data-toggle="tooltip" data-placement="top" title="Procesar">
						  <span class="glyphicon glyphicon-print"></span> 
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

    <script type="text/javascript" src="./js/nueva_orden_compra.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

  </body>
</html>

<script type="text/javascript" src="./js/maskedinput.js"></script>

<script>
  jQuery(function($){
   $("#codigo").mask("a-99999999-9");
});
</script>