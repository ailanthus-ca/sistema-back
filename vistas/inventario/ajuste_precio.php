<?php
include '../templates/template.php';
include '../../config/conexion.php';

//reinicia la tabla temporal
$con->query("TRUNCATE TABLE tmp");
?>

<br><br><br>
<div class="col-md-10 col-md-offset-1">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h4><i class='glyphicon glyphicon-edit'></i> Ajuste de utilidad </h4>
        </div>
        <div class="panel-body">
            <strong> Ajustar el precio de todos los productos</strong><p style="color: red">Para reducir el porcentaje coloque un signo negativo (-) en el valor ingresado </p>

            <form class="form-horizontal" method="post" id="ajuste_general" name="ajuste_general">
                <div id="resultados_ajax_ajuste"></div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <strong><small>Ajuste general (aumentar o disminuir el precio de todos los productos)</small></strong>
                        <div class="form-group row">
                            <label for="precio" class="col-md-2 control-label">Precio 1-2-3:</label>
                            <div class="col-md-2">
                                <input type="number" step="any" name="precio" id="precio" class="form-control input-sm" placeholder="Porcentaje" required=""></div>
                            <button id="guardar_ajusteG" type="submit" class="btn btn-info">
                                </span> Aplicar
                            </button>
                        </div>
                    </div>			
                </div>				
            </form>

            <form class="form-horizontal" method="post" id="ajuste_todos" name="ajuste_todos">
                <div id="resultados_ajax_ajuste"></div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <strong><small>Ajuste individual</small></strong>
                        <div class="form-group row">
                            <label for="precio1" class="col-md-2 control-label">Precio 1 (%):</label>
                            <div class="col-md-2">
                                <input type="number" step="any" name="precio1" id="precio1" class="form-control input-sm" placeholder="Porcentaje"></div>						

                            <label for="precio2" class="col-md-2 control-label">Precio 2 (%):</label>
                            <div class="col-md-2">
                                <input type="number" step="any" name="precio2" id="precio2" class="form-control input-sm" placeholder="Porcentaje"></div> 	

                            <label for="precio3" class="col-md-2 control-label">Precio 3 (%):</label>
                            <div class="col-md-2">
                                <input type="number" step="any" name="precio3" id="precio3" class="form-control input-sm" placeholder="Porcentaje"></div> 							 	
                        </div>	
                    </div>			
                </div>				
                <div class="col-md-12">
                    <div class="pull-right">					
                        <button id="guardar_ajusteT" type="submit" class="btn btn-info">
                            Aplicar
                        </button>
                    </div>	
                </div>
            </form>

            <br><br><br><br>

            <form class="form-horizontal" method="post" id="ajuste_seleccion" name="ajuste_seleccion">
                <div id="resultados_ajax_ajuste"></div>
                <strong> Ajustar precio de productos seleccionados</strong>
                <div class="panel panel-default">
                    <div class="panel-body">

                        <div class="form-group">
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="q" placeholder="Buscar productos" onkeyup="load(1)">
                            </div>
                            <button type="button" class="btn btn-default" onclick="load(1)"><span class='glyphicon glyphicon-search'></span> Buscar</button>
                        </div>


                        <div id="loader" style="position: absolute;	text-align: center;	top: 55px;	width: 100%;display:none;"></div><!-- Carga gif animado -->
                        <div class="outer_div" ></div><!-- Datos ajax Final -->
                    </div>				
                </div>			
            </form>			
        </div>
        <hr>
    </div>
</div>

<?php
include("../templates/template_footer.php");
?>
<script type="text/javascript" src="./js/ajuste_precio.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>

                                $(function () {
                                    $("#codigo_producto").autocomplete({
                                        source: "ajax/autocomplete/productos.php",
                                        minLength: 2,
                                        select: function (event, ui) {
                                            event.preventDefault();
                                            $('#codigo_producto').val(ui.item.id_producto);
                                            $('#nombre_producto').val(ui.item.nombre_producto);
                                            $('#stock').val(ui.item.cantidad_producto);



                                        }
                                    });


                                });

                                $("#codigo_producto").on("keydown", function (event) {
                                    if (event.keyCode == $.ui.keyCode.LEFT || event.keyCode == $.ui.keyCode.RIGHT || event.keyCode == $.ui.keyCode.UP || event.keyCode == $.ui.keyCode.DOWN || event.keyCode == $.ui.keyCode.DELETE || event.keyCode == $.ui.keyCode.BACKSPACE)
                                    {
                                        $("#id_producto").val("");
                                        $("#nombre_producto").val("");
                                        $("#stock").val("");

                                    }
                                    if (event.keyCode == $.ui.keyCode.DELETE) {
                                        $("#nombre_producto").val("");
                                        $("#id_cliente").val("");
                                        $("#stock").val("");
                                    }
                                });

                                function editarAjuste(id) {
                                    console.log(id);
                                    $("#carga").fadeIn('slow');
                                    $.ajax({
                                        url: "./ajax/ajuste_precio/editar_ajuste.php?id=" + id,
                                        beforeSend: function (objeto) {
                                            $('#carga').html('<img src="../../public/imagenes/ajax-loader.gif"> Cargando...');
                                        },
                                        success: function (data) {
                                            $(".edit").html(data).fadeIn('slow');
                                            $('#carga').html('');

                                        }
                                    })
                                }
</script>

</body>
</html>