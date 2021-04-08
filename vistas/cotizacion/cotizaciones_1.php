<?php include '../templates/template.php';?>

<br><br><br>
<!DOCTYPE html>
<html lang="en">
    <head>

    </head>
    <body> 
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="btn-group pull-right">
                        <a  href="nueva_cotizacion" class="btn btn-info"><span class="glyphicon glyphicon-plus" ></span> Nueva Cotización</a>
                    </div>
                    <h4><i class='glyphicon glyphicon-search'></i> Buscar Cotizaciones</h4>
                </div>
                <div class="panel-body">
                    <?php
                    include("../modals/ver_detallecotizacion.php");
                    include("../modals/ver_seguimiento_cotizacion.php");
                    include("../modals/buscar_productos_cotizaciones.php");
                    ?>	
                    <form class="form-horizontal" role="form" id="datos_cotizacion">

                        <div class="form-group row">
                            <label for="q" class="col-md-2 control-label">Cliente o nro. de cotización</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" id="q" placeholder="Nombre del cliente o nro. de cotización" onkeyup='load(1);'>
                            </div>
                            <div class="col-md-5">
                                <button type="button" class="btn btn-default" onclick='load(1);' data-placement="top" title="Buscar">
                                    <span class="glyphicon glyphicon-search" ></span></button>
                                <input type="hidden" class="form-control" id="cod" disabled>
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#historico" data-placement="top" title="Buscar productos">
                                    <span class="glyphicon glyphicon-shopping-cart"></span>
                                </button>
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
        <script type="text/javascript" src="./js/cotizaciones.js"></script>
    </body>
</html>

<script type="text/javascript">
                                    function ver_detalle(id) {
                                        console.log(id);
                                        $("#cargaC").fadeIn('slow');
                                        $.ajax({
                                            url: "./ajax/cotizacion/ver_detallecotizacion.php?id=" + id,
                                            beforeSend: function (objeto) {
                                                $('#cargaC').html('<img src="./public/imagenes/ajax-loader.gif"> Cargando...');
                                            },
                                            success: function (data) {
                                                $(".detalleC").html(data).fadeIn('slow');
                                                $('#cargaC').html('');
                                            }
                                        });
                                    }
</script>