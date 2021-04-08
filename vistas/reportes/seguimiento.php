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
                        <a href="nuevo_producto" class="btn btn-info"><span class="glyphicon glyphicon-plus" ></span> Nuevo Producto</a>
                    </div>
                    <h4><i class='glyphicon glyphicon-search'></i>Seguimiento de compras</h4>
                </div>
                <div class="panel-body">
                    <?php
                    include("../modals/ver_seguimiento.php");
                    ?>	
                    <form class="form-horizontal" role="form" id="form_seguimiento">

                        <div class="form-group row">
                            <label for="q" class="col-md-2 control-label">Codigo o Nombre</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" id="q" placeholder="Ingrese el codigo o nombre del producto" onkeyup='load(1);'>
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
        <!--<script type="text/javascript" src="./js/VentanaCentrada.js"></script>-->
        <script type="text/javascript" src="./js/seguimiento.js"></script>
    </body>
</html>