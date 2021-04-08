<?php

 include '../templates/template.php';
 include '../../config/conexion.php';

?>

<br><br><br>
 <div class="col-md-10 col-md-offset-1">
	<div class="panel panel-info">
		<div class="panel-heading">
			<h4><i class='glyphicon glyphicon-list-alt'></i> Reporte de compras </h4>
		</div>
		<div class="panel-body">
		<div class="form-horizontal" role="form" id="form_reporte_compras">
			<div id="resultados_ajax_ajuste"></div>
			<strong>Tipo de reporte</strong>
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<label  class="col-md-4"><input type="radio" name="tipo" id="tipo" value="hoy" onclick="option(this.value);"> Hoy</label>
					</div>
					<br>
					<div class="row">
						<label class="col-md-4"><input type="radio" name="tipo" id="tipo" value="mes" onclick="option(this.value);"> Por mes</label>
						<div class="col-md-4">
							<select id="mes" name="mes" class="form-control input-sm" disabled>
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
							<input type="date" name="fecha1" id="fecha1" class="form-control" disabled>
							<input type="date" name="fecha2" id="fecha2" class="form-control" disabled>
						</div>	
					</div>
					<br>
					<div class="row">
						<label  class="col-md-4"><input type="radio" name="tipo" id="tipo" value="otro" onclick="option(this.value);"> Otro</label>
						<div class="col-md-4">
							<select id="otro" name="otro" class="form-control input-sm" disabled>
								<option value="0">-Seleccione-</option>
								<option value="1">Semana actual</option>
								<option value="2">Semana pasada</option>
								<option value="3">Hace 3 semanas</option>
							</select>
						</div>
					</div>		 	
				</div>

			</div>			
				
				<div class="col-md-12">
					<div class="pull-right">
						<button type="button" class="btn btn-default" onclick="javascript:window.location.reload();">
						 <span class="glyphicon glyphicon-repeat"></span> Nuevo reporte
						</button>					
						<button id="guardar_ajuste" class="btn btn-default" onclick="reporte_compras();">
						  <span class="glyphicon glyphicon-print"></span> Imprimir
						</button>
					</div>	
				</div>
			</div>	
			
		<div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->			
		</div>
	</div>		
		  <div class="row-fluid">
			<div class="col-md-12">
			
	

			
			</div>	
		 </div>

	<div class="col-md-12"><h4>Resumen de compras por año</h4></div>
	<br><br>
	<div class="col-md-3">
		
		<select class="form-control" onchange="graficar(this.value);">
		    <?php
		    $query = $con->query("SELECT MIN( YEAR(fecha) ) AS fechaMin, MAX(YEAR(fecha)) as fechaMax FROM factura"); 
		    
		    if ($row = mysqli_fetch_array($query))
		    {
		    	$fechaMin = $row['fechaMin'];
		    	$fechaMax = $row['fechaMax'];
		    }    
		        for ($i=$fechaMin; $i <= $fechaMax; $i++) 
		        { 
		            if ($i == date("Y"))
		                echo '<option value ="'.$i.'" selected>'.$i.'</option>';
		            else
		                echo '<option value ="'.$i.'">'.$i.'</option>';       
		        }
		     ?>
	    </select>	

	</div>
	<br><br><br><br>
	<div><canvas id="grafico"></canvas></div>

	</div>
	<hr>	

		<?php
	include("../templates/template_footer.php");
	?>
	<script type="text/javascript" src="./js/VentanaCentrada.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script type="text/javascript" src="./js/reportes.js"></script>
	<script type="text/javascript" src="./js/chart/Chart.min.js"></script>
	<script type="text/javascript" src="./js/graficar_compras.js"></script>

  </body>
</html>