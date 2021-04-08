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
            <h4><i class='glyphicon glyphicon-search'></i>Reporte de Rubros vendidos por mes</h4>
        </div>
        <div class="panel-body">
                    <form class="form-horizontal" role="form" id="form_rubros">
                        <div class="row">
                            <div class="col-md-3 col-md-offset-2">
                                <select class="selectpicker form-control" id="mes" name="mes">
                                    <option value="1"     >Enero</option>
                                    <option value="2"   >Febrero</option>
                                    <option value="3"     >Marzo</option>
                                    <option value="4"     >Abril</option>
                                    <option value="5"      >Mayo</option>
                                    <option value="6"     >Junio</option>
                                    <option value="7"     >Julio</option>
                                    <option value="8"    >Agosto</option>
                                    <option value="9">Septiembre</option>
                                    <option value="10"   >Octubre</option>
                                    <option value="11" >Noviembre</option>
                                    <option value="12" >Diciembre</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="selectpicker form-control" id="ano" name="ano">
                                    <?php
                                    $timestamp = getdate();
                                    $ano = $timestamp['year'];
                                    $i = 2017;
                                    while($i <= $ano){
                                        ?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php
                                        $i++;
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="submit" class="btn btn-default" value="Generar reporte">
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
<script type="text/javascript" src="./js/rubros.js"></script>
</body>
</html>