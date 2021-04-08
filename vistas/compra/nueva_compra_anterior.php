<?php

 include '../templates/template.php';
 include '../../config/conexion.php';

if ($_SESSION['nivel']==1)
{
    header('Location: panel_us');
}



//reinicia la tabla temporal que contiene productos de la factura anterior
 $con->query("truncate table tmp_comp_prod");

 $resultado = $con->query("SELECT *from compra order by codigo DESC LIMIT 1");
 //rutina para indicar cual es el numero de la siguiente factura, en formato de 6 digitos
 if($row = mysqli_fetch_array($resultado))
 {
 	$cod_compra = $row['codigo']+1;
 	if(strlen($cod_compra)<2)
    	$cod_compra="00000".$cod_compra;
	if(strlen($cod_compra)<3)
   		$cod_compra="0000".$cod_compra;
	if(strlen($cod_compra)<4)
    	$cod_compra="000".$cod_compra;
    if(strlen($cod_compra)<5)
    	$cod_compra = "00".$cod_compra;
    if(strlen($cod_compra)<6)
    	$cod_compra = "0".$cod_compra;

 }

else 
{
 	$cod_compra =1;
 	$cod_compra="00000".$cod_compra; 
}

$conf = $con->query("SELECT *from conf_region");
if ($row = mysqli_fetch_array($conf))
{
	$impuesto1 = $row['impuesto'];
	$impuesto2 = $row['impuesto2'];
	$imp_esp = $row['imp_esp'];

}

?>
<br><br><br>
 <div class="col-md-10 col-md-offset-1">
	<div class="panel panel-info">
		<div class="panel-heading">
			<h4><i class='glyphicon glyphicon-shopping-cart'></i> Nueva Compra </h4>
		</div>
		<div class="panel-body">
		<?php 
			include("../modals/buscar_productos.php");
			include("../modals/registro_productos.php");
			include("../modals/registro_proveedores.php");
			include("../modals/editar_factura.php");
			include("../modals/buscar_ordenes.php");

		?>
			<form class="form-horizontal" role="form" id="datos_compra">
			<strong>Datos del proveedor</strong>
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="form-group row">
				  	<label for="codigo_proveedor" class="col-md-1 control-label">RIF</label>
				  	<div class="col-md-3">
					  <input type="text" class="form-control input-sm" id="codigo_proveedor" placeholder="Ingresa el rif o cedula" required>
					  <input id="id_cliente" type='hidden'>
				  	</div>
				  	<label for="nombre_proveedor" class="col-md-1 control-label">Nombre</label>
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
			<strong>Datos de la compra</strong>
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="form-group row">
					<input type="hidden" name="cod_compra" id="cod_compra" value="<?php echo $cod_compra ?>">
					<label for="cod_documento" class="col-md-3 control-label">Nro. Documento</label>
					<div class="col-md-3">
						<input type="text" class="form-control input-sm" id="cod_documento" required>	
					</div>	
						<label for="fecha" class="col-sm-3 control-label">Fecha Documento</label>
						<div class="col-md-3">
							<input type="date" class="form-control input-sm" id="fecha" required>
						</div>
					</div>	
				</div>
			</div>

			<?php if ($imp_esp=="1") { ?>

			<a data-toggle="collapse" data-target="#cond" class="btn btn-info"><span class="glyphicon glyphicon-chevron-down" ></span>Impuesto</a>
			<br>
			<div id="cond" class="collapse" class="panel panel-default">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="form-group row">
						<label for="impuesto1" class="col-md-2 control-label">IVA primario (<?php echo $impuesto1 ?>%)</label>
						<div class="col-md-1">
							<input type="radio" id="impuesto1" name="porc_impuesto" onclick="cambiar_impuesto(this.value)" value="<?php echo $impuesto1 ?>" checked>	
						</div>	
							<label for="imp_esp" class="col-md-2 control-label">IVA especial</label>
							<div class="col-md-1">
								<input type="radio" id="imp_esp" name="porc_impuesto" onclick="cambiar_impuesto('imp_esp')" value="imp_esp">
							</div>

						</div>
					
					</div>
				</div>					
			</div>

			<?php } ?>
				
				<br><br>
				<div class="col-md-12">
					<div class="pull-right">
						</button>
						<button type="button" class="btn btn-default btn-lg" data-toggle="modal" onclick="cotizacion();" data-target="#cargarOrden" data-toggle="tooltip" data-placement="top" title="Cargar orden de compra">
						 <span class="glyphicon glyphicon-folder-open"></span> 
						</button>
						<!--Campo oculto para guardar el id de la orden de compra-->
						<input type="hidden" name="id_orden" id="id_orden">

						<button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#nuevoProducto" onclick="limpiar_modal();" data-toggle="tooltip" data-placement="top" title="Nuevo producto">
						 <span class="glyphicon glyphicon-shopping-cart"></span>
						</button>
						<button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#nuevoProveedor" onclick="limpiar_modal();" data-toggle="tooltip" data-placement="top" title="Nuevo proveedor">
						 <span class="glyphicon glyphicon-user"></span> 
						</button>
						<button type="button" class="btn btn-default btn-lg" onclick="producto();" data-toggle="modal" data-target="#myModal" data-toggle="tooltip" data-placement="top" title="Buscar productos">
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
	<script type="text/javascript" src="./js/VentanaCentrada.js"></script>
	<script type="text/javascript" src="./js/nueva_compra.js"></script>
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
