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
                <h4><i class='glyphicon glyphicon-search'></i>Historico de producto</h4>
            </div>
            <div class="panel-body">
                <?php
                include("../modals/buscar_productos_historico.php");
                ?>
                    <div class="form-group row">
                        <div class="col-sm-1">
                            <label>Codigo:</label>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="cod" disabled>
                        </div>
                        <div class="col-sm-1">
                            <label>Producto:</label>
                        </div>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="des" disabled>
                        </div>
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#historico">
                            <span class="glyphicon glyphicon-search" onclick="validarTipo()"></span> Buscar productos
                        </button>
                    </div>
                </div>
            <div class="panel-body">
                <div class="row">
                    <label  class="col-md-4"><input type="radio" name="tipo" id="tipo" value="hoy" onclick="option(this.value);" checked> Todo</label>
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
        <div class="col-md-12">
            <div class="pull-right">
                <button type="button" class="btn btn-default" onclick="javascript:window.location.reload();">
                    <span class="glyphicon glyphicon-repeat"></span> Nuevo reporte
                </button>
                <button id="guardar_ajuste" class="btn btn-default" onclick="imprimir();">
                    <span class="glyphicon glyphicon-print"></span> Imprimir
                </button>
            </div>
        </div>
    </div>
    </div>
        </div>

    </div>
    <hr>
    <?php
    include("../templates/template_footer.php");
    ?>
    <script type="text/javascript" src="./js/VentanaCentrada.js"></script>
    <script type="text/javascript" src="./js/historico.js"></script>
    </body>
    </html>
<?php
/**
 * Created by PhpStorm.
 * User: Ailanthus
 * Date: 12-03-2018
 * Time: 10:22 AM
 */