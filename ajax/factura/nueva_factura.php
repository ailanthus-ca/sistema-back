<?php

session_start();
$id_user = $_SESSION['id_usuario'];
if (empty($_SESSION['usuario'])) {
    header('Location: index.php');
}
/* Conectar a la base de datos */
include '../../config/conexion.php';
$num_factura = $con->real_escape_string(strip_tags($_POST["num_factura"], ENT_QUOTES));
$codigo_cliente = $con->real_escape_string(strip_tags($_POST["codigo_cliente"], ENT_QUOTES));
$condicion = $con->real_escape_string(strip_tags($_POST["condicion"], ENT_QUOTES));
$observacion = $con->real_escape_string(strip_tags($_POST["observacion"], ENT_QUOTES));
$porc_impuesto = (isset($_REQUEST['porc_impuesto']) && $_REQUEST['porc_impuesto'] != NULL) ? $_REQUEST['porc_impuesto'] : '';
$id_cotizacion = (isset($_REQUEST['id_cotizacion']) && $_REQUEST['id_cotizacion'] != NULL) ? $_REQUEST['id_cotizacion'] : '';
$id_nota = (isset($_REQUEST['id_nota']) && $_REQUEST['id_nota'] != NULL) ? $_REQUEST['id_nota'] : '';

//prosesar cotizacion
if ($id_cotizacion != '') {
    $sql = $con->query("UPDATE cotizacion SET estatus = 2 WHERE codigo = '$id_cotizacion' ");
    $sql = $con->query("select usuario from cotizacion WHERE codigo = '$id_cotizacion'");
    if ($row = $sql->fetch_array()) {
        $user = $row['usuario'];
    }
} else {
    $user = $_SESSION['id_usuario'];
}

//prosesar nota
if ($id_nota != '') {
    $sql = $con->query("UPDATE notasalida SET estatus = 2 WHERE codigo = '$id_cotizacion' ");
    $sql = $con->query("select usuario from notasalida WHERE codigo = '$id_cotizacion'");
    if ($row = $sql->fetch_array()) {
        $user = $row['usuario'];
    }
} else {
    $user = $_SESSION['id_usuario'];
}

//calcular total
$sql = $con->query("select SUM(cantidad_tmp*precio_tmp) AS total,SUM(costo*cantidad_tmp) as costo from  producto,tmp_fact_prod where producto.codigo=tmp_fact_prod.id_producto") or die("total: " . $con->error);
while ($row = $sql->fetch_array()) {
    $subtotal_r = $row['total'];
    $costo_total = $row['costo'];
}
//iva
$sql = $con->query("SELECT *from conf_region");
if ($row = $sql->fetch_array()) {
    $impuesto = $row['impuesto'];
}
//calculos
$impuesto_r = $subtotal_r * $impuesto / 100;
$total_r = $subtotal_r + $impuesto_r;
$fecha = date('Y-m-d');
$sql = "INSERT into factura values($num_factura,UPPER('$codigo_cliente'), '$fecha', '$condicion',$porc_impuesto, $costo_total, $impuesto_r, $subtotal_r, $total_r, UPPER('$observacion'), $user ,2)";

$query = $con->query($sql) or die("factura: " . $con->error);

$sql = $con->query("select * from tmp_fact_prod") or die("tmp_fact_prod: " . $con->error);
while ($row = $sql->fetch_array()) {
    $con->query("INSERT INTO detallefactura VALUES ('$num_factura','" . $row['id_producto'] . "','" . $row['cantidad_tmp'] . "', '" . $row['precio_tmp'] . "', '" . $row['precio_tmp'] * $row['cantidad_tmp'] . "') ") or die("detallefactura " . $row['id_producto'] . ": " . $con->error);
    if ($id_nota == '') {
        $sql_pro = $con->query("SELECT tipo from producto WHERE codigo = '" . $row['id_producto'] . "' ") or die("producto SELECT" . $row['id_producto'] . ": " . $con->error);
        $row_pro = mysqli_fetch_array($sql_pro);
        $tipo = $row_pro['tipo'];
        if ($tipo == "1") {
            $con->query("UPDATE producto set cantidad = cantidad - ('" . $row['cantidad_tmp'] . "') WHERE codigo = '" . $row['id_producto'] . "' ") or die("producto UPDATE" . $row['id_producto'] . ": " . $con->error);
        }
    }
}

$con->query("TRUNCATE TABLE tmp_fact_prod");
echo 1;
?>

