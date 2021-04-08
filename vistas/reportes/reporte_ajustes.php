<?php

 include '../templates/template.php';
 include '../../config/conexion.php';
  
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
				<a href="../inventario/ajuste_inventario.php" class="btn btn-info"><span class="glyphicon glyphicon-plus" ></span> Nuevo Ajuste</a>
			</div>
			<h4><i class='glyphicon glyphicon-search'></i> Ajustes de inventario</h4>
		</div>
			<div class="panel-body">
			<?php 
				include("../modals/ver_detallecompra.php");
			?>
			<div class="form-horizontal" role="form" id="reporte_ajustes">
					<div class="row">
						<h5 style="margin-left: 15px;">Seleccione el tipo de ajuste</h5>	
						<label  class="col-md-4"><input type="radio" name="tipo_ajuste" id="tipo_ajuste" value="entrada" onclick="load();"> Entrada</label>
						<label  class="col-md-4"><input type="radio" name="tipo_ajuste" id="tipo_ajuste" value="salida" onclick="load();"> Salida</label>
					</div>
					<br><br>
					<div class="row">
					<h5 style="margin-left: 15px;">Seleccione el tipo de reporte</h5>
						<label class="col-md-4"><input type="radio" name="tipo" id="tipo" value="mes" onclick="option(this.value);"> Por mes</label>
						<div class="col-md-4">
							<select id="mes" name="mes" class="form-control input-sm" disabled onchange="load();">
								<option value="0">-Seleccione el mes-</option>
								<option value="1">Enero</option>
								<option value="2">Febrero</option>
								<option value="3">Marzo</option>
								<option value="4">Abril</option>
								<option value="5">Mayo</option>
								<option value="6">Junio</option>
								<option value="7">Julio</option>
								<option value="8">Agosto</option>
								<option value="9">Septiembre</option>
								<option value="10">Octubre</option>
								<option value="11">Noviembre</option>
								<option value="12">Diciembre</option>
							</select>
						</div>
					</div>
					<br>
					<div class="row">
						<label class="col-md-4"><input type="radio" name="tipo" id="tipo" value="rango" onclick="option(this.value);"> Rango de fechas</label>
						<div class="col-md-4">
							<input type="date" name="fecha1" id="fecha1" class="form-control" disabled onchange="load(this.value);"> 
							<input type="date" name="fecha2" id="fecha2" class="form-control" disabled onchange="load(this.value);">
						</div>	
					</div>
					<br>
					
				
						<div class="form-group row">					
							
							
							<div class="col-md-3">
								<span id="loader"></span>
							</div>
							
						</div>
				
				
				
			</div>
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
	<script type="text/javascript" src="./js/reporte_ajustes.js"></script>
  </body>
</html>

<script type="text/javascript">

	function ver_detalle(id){
		console.log(id);
		$("#cargaCompra").fadeIn('slow');
		$.ajax({
			url:"./ajax/compra/ver_detallecompra.php?id=" + id,
			 beforeSend: function(objeto){
			 $('#cargaCompra').html('<img src="../../public/imagenes/ajax-loader.gif"> Cargando...');
		  },
			success:function(data){
				$(".detalleCompra").html(data).fadeIn('slow');
				$('#cargaCompra').html('');
				
			}
		})
	}

</script>