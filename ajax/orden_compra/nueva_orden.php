<?php

include '../../config/seccion.php';
if (empty($_SESSION['usuario'])) {
    header('Location: index.php');
}




/* Conectar a la base de datos */
include '../../config/conexion.php';


$codigo_proveedor = mysqli_real_escape_string($con,(strip_tags($_POST["codigo_proveedor"], ENT_QUOTES)));
$cod_orden = mysqli_real_escape_string($con,(strip_tags($_POST["cod_orden"], ENT_QUOTES)));
$fecha = date('Y-m-d');

$impuesto = (isset($_REQUEST['impuesto']) && $_REQUEST['impuesto'] != NULL) ? $_REQUEST['impuesto'] : '';
//Reemplazo las comas	
$impuesto_r = str_replace(",", "", $impuesto);

$subtotal = (isset($_REQUEST['subtotal']) && $_REQUEST['subtotal'] != NULL) ? $_REQUEST['subtotal'] : '';
//Reemplazo las comas
$subtotal_r = str_replace(",", "", $subtotal);

$total = (isset($_REQUEST['total']) && $_REQUEST['total'] != NULL) ? $_REQUEST['total'] : '';
//Reemplazo las comas
$total_r = str_replace(",", "", $total);


$forma_pago = mysqli_real_escape_string($con,(strip_tags($_POST["forma_pago"], ENT_QUOTES)));
$tiempo_entrega = mysqli_real_escape_string($con,(strip_tags($_POST["tiempo_entrega"], ENT_QUOTES)));
$validez = mysqli_real_escape_string($con,(strip_tags($_POST["validez"], ENT_QUOTES)));
$otros = mysqli_real_escape_string($con,(strip_tags($_POST["otros"], ENT_QUOTES)));


if ($cod_orden != "" && $codigo_proveedor != "" && $fecha != "" && $impuesto != "" && $subtotal != "" && $total != "") {
    $sql = $con->query("INSERT INTO ordencompra VALUES ('$cod_orden',UPPER('$codigo_proveedor'),'$fecha',$subtotal_r,$impuesto_r,        $total_r, UPPER('$forma_pago'), UPPER('$tiempo_entrega'), UPPER('$validez'), UPPER('$otros'), 1)");

    $sql = $con->query("select * from tmp_ord_prod");
    while ($row = $sql->fetch_array()) {
        $con->query("INSERT INTO detalleordencompra VALUES ('$cod_orden','" . $row['id_producto'] . "','" . $row['precio_tmp'] . "','" . $row['cantidad_tmp'] . "', '" . $row['precio_tmp'] * $row['cantidad_tmp'] . "') ");
    }
    //reinicia la tabla temporal
    $con->query("DELETE FROM tmp_ord_prod  WHERE usuario_tmp = '$id_usuario'");
    mysqli_close($con);
}
?>