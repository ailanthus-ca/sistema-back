<?php
session_start();
include '../templates/template.php';
include("../modals/parametros/editar_unidad.php"); ?>
<br><br><br><br><br><br><br><br><br><br>
<form class="form" role="form" method="POST" id="form_unidad" name="form_unidad" enctype="multipart/form-data">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-md-offset-1">
                <div class="panel-group" id="accordion">
                    <div id="resultados_ajax"></div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><span class="glyphicon glyphicon-file">
                                    </span>Monedas</a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input name="descripcion" type="text" class="form-control" id="descripcion" placeholder="Descripcion" required maxlength="300" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button id="guardar" name="guardar" type="submit" class="btn btn-primary"> <i class="fa fa-check-square"></i> Guardar</button>
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div id="resultados"></div><!-- Carga los datos ajax -->
                <div class='outer_div'></div><!-- Carga los datos ajax -->
            </div>
        </div>
    </div>
</form>

<?php
include '../templates/template_footer.php';
?>
<script type="text/javascript" src="./js/moneda.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>