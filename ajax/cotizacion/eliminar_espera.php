<?php
/**
 * Created by PhpStorm.
 * User: Ailanthus
 * Date: 21-03-2018
 * Time: 09:41 AM
 */

session_start();
$id_usuario = $_SESSION['id_usuario'];


include '../../config/conexion.php';
if (isset($_POST['id'])){
    $tmp_cotizacion =mysqli_real_escape_string($con,(strip_tags($_POST["id"],ENT_QUOTES)));
    if($tmp_cotizacion != "-1"){
        $sql   ="DELETE FROM tmp_cotizacion WHERE codigo=$tmp_cotizacion";
        $query = $con->query($sql);
        $sql   ="DELETE FROM tmp_detalle_cotizacion WHERE codCotizacion = $tmp_cotizacion";
        $query = $con->query($sql);
    }
}


