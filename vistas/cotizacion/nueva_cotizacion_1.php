<?php


include '../templates/template.php';
include '../../config/conexion.php';

$id_usuario = $_SESSION['id_usuario'];

 $con->query("DELETE from tmp_cot_prod WHERE usuario_tmp = '$id_usuario'");
 $resultado = $con->query("SELECT *from cotizacion order by codigo DESC LIMIT 1");

?>

<br><br><br>

<input type="hidden" id="nivel" name="nivel" value="<?php echo $_SESSION['nivel'] ?>">
 <div class="col-md-10 col-md-offset-1">
     <div id="mensaje" style="display: none;" class="alert alert-success" role="alert" >
         <button type="button" class="close" data-dismiss="alert">&times;</button>
         <strong>¡Se ha guardado la cotización!</strong>
     </div>
	<div class="panel panel-info">
		<div class="panel-heading">
			<h4><i class='glyphicon glyphicon-edit'></i> Nueva Cotizacion </h4>
		</div>
		<div class="panel-body">
                    
		<?php 
			include("../modals/producto_cotizacion.php");
			include("../modals/buscar_cotizaciones.php");
			include("../modals/editar_factura.php");
			include("../modals/registro_productos.php");
			include("../modals/registro_clientes.php");
			include("../modals/comentario_cotizacion.php");
			include("../modals/buscar_cotizacion_espera.php");
        		?>

            <form class="form-horizontal" role="form" id="datos_cotizacion">

			<strong>Datos del cliente</strong>
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="form-group row">

				  	<label for="codigo_cliente" class="col-md-1 control-label">RIF</label>
				  	<div class="col-md-3">
					  <input type="text" class="form-control input-sm" id="codigo_cliente" name="codigo_cliente" placeholder="Ingresa el rif o cedula" required>
					  <input id="id_cliente" type='hidden'>	
				  	</div>
				  	<label for="nombre_cliente" class="col-md-1 control-label">Nombre</label>
				  	<div class="col-md-3">
					  <input type="text" class="form-control input-sm" id="nombre_cliente" placeholder="nombre del cliente" required>
				 	 </div>
				  	<label for="tel1" class="col-md-1 control-label">Teléfono</label>
					<div class="col-md-2">
					<input type="text" class="form-control input-sm" id="tel1" placeholder="Teléfono" readonly required>
					</div>
				 </div>
				 <div class="form-group row">
					<label for="direccion_cliente" class="col-md-1 control-label">Dirección</label>
						<div class="col-md-10">
							<input type="text" class="form-control input-sm" id="direccion_cliente" placeholder="Dirección" readonly required>
						</div>			 	
					<!--<label for="mail" class="col-md-1 control-label">Email</label>
						<div class="col-md-3">
							<input type="text" class="form-control input-sm" id="mail" placeholder="Email" readonly>
						</div>	-->		 	
				 </div>
                    <input type="hidden" id="cod_cotizacion" name="cod_cotizacion" value="-1">
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
			<br><br>			
				<div class="col-md-12">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-lg" data-toggle="modal" onclick="retomar_cotizacion();" data-target="#cargarCotizacionEspera" data-placement="top" title="Retomar Cotizacion" >
                            <span class="glyphicon glyphicon-folder-open"></span>
                        </button>
                        <button type="button" class="btn btn-default btn-lg" data-toggle="tooltip" onclick="cotizacion_espera();" data-placement="top" title="Guardar cotizacion" >
                            <span class="glyphicon glyphicon-floppy-disk"></span>
                        </button>
                    </div>
                    <span class="btn"></span>
                        <button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#cargarCotizacion" data-placement="top" title="Copiar Cotizacion" onclick="cotizacion();">
                            <span class="glyphicon glyphicon-duplicate"></span>
                        </button>
                    <div class="pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#nuevoCliente" onclick="limpiar_modal();"  data-placement="top" title="Nuevo cliente">
                                <span class="glyphicon glyphicon-user"></span>
                            </button>
                            <button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#nuevoProducto" onclick="limpiar_modal();" data-placement="top" title="Nuevo producto">
                                <span class="glyphicon glyphicon-shopping-cart"></span>
                            </button>
                            <button type="button" class="btn btn-default btn-lg " data-toggle="modal" data-target="#myModal" onclick="producto();"  data-placement="top" title="Buscar productos">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </div>
                        <span class="btn"></span>
                        <button id="procesar" type="submit" class="btn btn-default btn-lg" disabled="true" data-toggle="tooltip" data-placement="top" title="Procesar">
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
    <script type="text/javascript" src="./js/nueva_cotizacion.js"></script>
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