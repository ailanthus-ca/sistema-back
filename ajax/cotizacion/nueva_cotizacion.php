<?php

session_start();
if (empty($_SESSION['usuario'])) {
    header('Location: index.php');
}
$id_usuario = $_SESSION['id_usuario'];
/* Conectar a la base de datos */
include '../../config/conexion.php';

$tmp_cotizacion = mysqli_real_escape_string($con,(strip_tags($_POST["cod_cotizacion"], ENT_QUOTES)));
$codigo_cliente = mysqli_real_escape_string($con,(strip_tags($_POST["codigo_cliente"], ENT_QUOTES)));
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


if ($codigo_cliente != "" && $fecha != "" && $impuesto != "" && $subtotal != "" && $total != "") {
    $sql = "INSERT into cotizacion values(null,UPPER('$codigo_cliente'), '$fecha', $impuesto_r, $subtotal_r, $total_r, UPPER('$forma_pago'), UPPER('$tiempo_entrega'), UPPER('$validez'), UPPER('$otros'),null, 1,$id_usuario)";
    $query = $con->query($sql)or die($con->error);
}
$id_cotizacion_ult = $con->insert_id;
$sql = $con->query("select * from tmp_cot_prod WHERE usuario_tmp = '$id_usuario'")or die($con->error);
while ($row = $sql->fetch_array()) {
        $con->query("INSERT INTO detallecotizacion VALUES ('$id_cotizacion_ult','" . $row['id_producto'] . "','" . $row['cantidad_tmp'] . "', '" . $row['precio_tmp'] . "', '" . $row['precio_tmp'] * $row['cantidad_tmp'] . "', '" . $row['descripcion_tmp'] . "') ")or die($con->error);
}
if ($tmp_cotizacion != "-1") {
    $sql = "DELETE FROM tmp_cotizacion WHERE codigo=$tmp_cotizacion";
    $query = $con->query($sql)or die($con->error);
    $sql = "DELETE FROM tmp_detalle_cotizacion WHERE codCotizacion = $tmp_cotizacion";
    $query = $con->query($sql)or die($con->error);
}
$con->query("DELETE from tmp_cot_prod WHERE usuario_tmp = '$id_usuario'");
echo json_encode($id_cotizacion_ult);
mysqli_close($con);
?>