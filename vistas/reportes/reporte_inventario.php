<?php

 include '../templates/template.php';
 include '../../config/conexion.php';

?>

<br><br><br>
 <div class="col-md-10 col-md-offset-1">
	<div class="panel panel-info">
		<div class="panel-heading">
			<h4><i class='glyphicon glyphicon-list-alt'></i> Reporte de inventario </h4>
		</div>
		<div class="panel-body">
		<div class="form-horizontal" role="form" id="form_reporte_inventario">
            <div class="col-md-12">
                <div class="col-sm-2">
                    <strong>Categoria:</strong>
                </div>
                <div class="col-sm-3">
                    <select class="selectpicker form-control" value="td" id="dp" name="dp">
                        <option value="td">TODOS</option>
                        <?php
                        $sql = "SELECT codigo, descripcion FROM departamento WHERE estatus = 1";
                        $query = $con->query($sql);
                        while($row = mysqli_fetch_array($query)){?>
                            <option value="<?php echo $row['codigo']; ?>"><?php echo $row['descripcion']; ?></option><?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div>
			<strong>Elija el tipo de producto</strong>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <label  class="col-md-4"><input type="radio" name="tipo" id="tipo" value="2" onclick="option(this.value);" checked> Todo</label>
                        </div>
                        <br>
                        <div class="row">
                            <label  class="col-md-4"><input type="radio" name="tipo" id="tipo" value="0" onclick="option(this.value);"> Venta</label>
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-md-4"><input type="radio" name="tipo" id="tipo" value="1" onclick="option(this.value);"> Enser</label>
                        </div>
                    </div>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" id="cero" checked>
                        Incluir Productos sin Stock
                    </label>
                </div>
            </div>
				<div class="col-md-12">
					<div class="pull-right">
						<button type="button" class="btn btn-default" onclick="javascript:window.location.reload();">
						 <span class="glyphicon glyphicon-repeat"></span> Nuevo reporte
						</button>					
						<button id="guardar_ajuste" class="btn btn-default" onclick="reporte_inventario();">
						  <span class="glyphicon glyphicon-print"></span> Imprimir
						</button>
					</div>	
				</div>
			</div>
			<div id="resultados"></div><!-- Carga los datos ajax -->			
		</div>
	</div>
 </div>
     <?php
	    include("../templates/template_footer.php");
	?>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script type="text/javascript" src="./js/reportes.js"></script>
	

  </body>
</html>