<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include '../../config/conexion.php';
if (isset($_REQUEST['cod'])) {
    $cod = $_REQUEST['cod'];
    $num = $_REQUEST['num'];
    $ope = $_REQUEST['ope'];
    $query = $con->query("UPDATE `producto` SET `costo`= `costo`$ope $num where codigo = $cod");
    ?>
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>¡Registro con exito!</strong>
    </div>
    <?php
} else if (isset($_REQUEST['dpt'])) {
    $dpt = $_REQUEST['dpt'];
    $num = $_REQUEST['num'];
    $ope = $_REQUEST['ope'];
    $query = $con->query("UPDATE `producto` SET `costo`= `costo`$ope $num where codigo = $dpt");
    ?>
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>¡Registro con exito!</strong>
    </div>
    <?php
} else if (isset($_REQUEST['td'])) {
    $num = $_REQUEST['num'];
    $ope = $_REQUEST['ope'];
    $query = $con->query("UPDATE `producto` SET `costo`= `costo`$ope $num ");
    ?>
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>¡Registro con exito!</strong>
    </div>
    <?php
} else {
    ?>
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Error!</strong> 
        Nos se pudo realizar la operacion
    </div>
    <?php
}