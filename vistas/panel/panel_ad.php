<?php include '../templates/template.php' ?>
<?php
include '../../config/conexion.php';

$sql = $con->query("SELECT count(*) as productos from producto");
if ($row = $sql->fetch_array()) {
    $num_productos = $row['productos'];
}

$sql = $con->query("SELECT count(*) as cotizaciones from cotizacion");
if ($row = $sql->fetch_array()) {
    $num_cotizaciones = $row['cotizaciones'];
}

$sql = $con->query("SELECT subtotal from factura order by codigo desc limit 1");
if ($row = $sql->fetch_array()) {
    $ult_factura = $row['subtotal'];
} else {
    $ult_factura = 0;
}
$query = $con->query("select * from dolares order by id desc limit 1");
if($data = $query->fetch_array())
$valor = (float) $data['valor'];
?>
<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Panel de control <small>Administrador</small></a>
                </h1>
            </div>
        </div>    
        <!-- /.row -->
        <!-- /.row -->
        <br>
        <div class="row">
            <!--Accesos directos-->
            <div class="col-lg-3 col-md-3">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <a style="text-decoration: none; color: white;" href="ver_productos">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-desktop fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div><h3>Inventario</h3></div>
                                </div>
                            </div>
                        </a>    
                    </div>
                    <div class="panel-footer">
                        <span class="pull-left"><?php
                            echo $num_productos;
                            echo " ";
                            ?> Productos registrados</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <a style="text-decoration: none; color: white;" href="ver_cotizaciones">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-usd fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div><h3>Cotizaciones</h3></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="panel-footer">
                        <span class="pull-left"><?php
                            echo $num_cotizaciones;
                            echo " ";
                            ?> Cotizaciones</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <a style="text-decoration: none; color: white;" href="ver_facturas">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file-text-o fa-4x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div><h3>Facturas</h3></div>
                                </div>
                            </div>
                        </a>    
                    </div>
                    <div class="panel-footer">
                        <span class="pull-left">Última venta: <?php echo $ult_factura; ?></span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </div>                        
            </div>
            <!--Fin de accesos directos-->    
            <!--Charts indicadores Google-->
            <div class="col-lg-3 col-md-3">
                <div id="chart_equi" style="width: 400px; height: 120px;"></div>
                <label style="padding-left: 25px; padding-top: 55px;">Punto de equilibrio</label>
                <br>
                <div id="chart_util" style="width: 400px; height: 120px;"></div>
                <label style="padding-left: 20px; padding-top: 55px;">Promedio de utilidad</label>
                <br>
                <div id="chart_otro" style="width: 400px; height: 120px;"></div>
            </div>
            <!--Fin charts-->
            <!--Charts tabla Google-->
            <div class="col-lg-6 col-md-6">  
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <label style="padding-left: 150px;">Cotizaciones pendientes</label>
                    </div>    
                    <div id="table_div"></div>
                </div>    
                <br>
                <!--Chart line Google-->
                <div id="bar" style="width: 500px; height: 200px;"></div>                        
            </div>
            <!--Fin tabla-->
        </div>
        <br><br>
        <div class="col-md-6">
            <h2>Cambios del Dolar</h2>
        </div>
        <div class="col-md-6">
            <div style= "width: 100%" class="mb-3 input-group">
                <span style=" width: 100px; position: relative; background-color: #eee" class="form-control">
                    Tasa actual
                </span>
                <span style=" width: calc(50% - 150px); position: relative; background-color: #eee" class="form-control">
                    <?php echo $valor; ?>
                </span>
                <span style=" width: 100px; position: relative; background-color: #eee" class="form-control">
                    Actualizar a 
                </span>
                <input style=" width: calc(50% - 150px); position: relative;" class="form-control" type="number" step="0.01" id='nuevaTasaDolar' value="<?php echo $valor; ?>" />
                <button style="width: 100px" style="border-top-left-radius: 0;border-bottom-left-radius: 0"
                        class="btn btn-primary" onclick="setDolar()">
                    Actualizar
                </button>
            </div>
        </div>
        <br><br>
        <div class="col-md-10"><canvas id="dolar"></canvas></div>
        <br><br>
        <div class="col-md-6">
            <h2>Ventas del mes</h2>
        </div>
        <br><br>
        <div class="col-md-10"><canvas id="grafico"></canvas></div>
    </div>        
</div>
<!-- /#page-wrapper -->

<?php include "../templates/template_footer.php" ?>
<script type="text/javascript" src="./js/chart/Chart.min.js"></script>
<script type="text/javascript" src="./js/graficar_ventas_dia.js"></script>

<!--Charts Google-->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="./js/dashboard.js"></script>
