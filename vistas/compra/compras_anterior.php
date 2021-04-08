<?php
include '../templates/template.php';
include '../../config/conexion.php';
if ($_SESSION['nivel'] == 1) {
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
                        <a  href="nueva_compra" class="btn btn-info"><span class="glyphicon glyphicon-plus" ></span> Nueva Compra</a>
                    </div>
                    <h4><i class='glyphicon glyphicon-search'></i> Buscar Compras</h4>
                </div>
                <div class="panel-body">
<?php
include("../modals/ver_detallecompra.php");
?>	
                    <form class="form-horizontal" role="form" id="datos_compra">

                        <div class="form-group row">
                            <label for="q" class="col-md-3 control-label">Proveedor o nro. de documento</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" id="q" placeholder="Nombre del proveedor o nro. del documento o factura" onkeyup='load(1);'>
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
        <script type="text/javascript" src="./js/compras.js"></script>
    </body>
</html>
