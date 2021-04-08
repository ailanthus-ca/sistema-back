<?php

session_start();
$id_user = $_SESSION['id_usuario'];
if (empty($_SESSION['usuario'])) {
    header('Location: login.php');
}


/* Connect To Database */
include '../../config/conexion.php';

$sql_conf = $con->query("SELECT *from conf_factura");
if ($row = mysqli_fetch_array($sql_conf)) {
    $mtop = $row['margen_sup'];
    $mder = $row['margen_der'];
    $mizq = $row['margen_izq'];
    $mbot = $row['margen_inf'];
    $papel = $row['tipo_papel'];
}

$id_factura = $_GET['id_factura'];
$sql_factura = $con->query("select * from factura where codigo='" . $id_factura . "'");
$count = mysqli_num_rows($sql_factura);
if ($count == 0) {
    //echo "<script>alert('Factura no encontrada')</script>";
    //echo $id_factura;
    echo "<script>window.location.reload();</script>";
    exit;
}
$rw_factura = mysqli_fetch_array($sql_factura);
$numero_factura = $rw_factura['codigo'];
$id_cliente = $rw_factura['cod_cliente'];
$fecha_factura = $rw_factura['fecha'];
$condiciones = $rw_factura['condicion'];
$porc_impuesto = $rw_factura['porc_impuesto'];
if ($porc_impuesto == 0.00) {
    $porc_impuesto = "12.00";
}

$sql_USER = $con->query("select * from usuario where codigo='" . $rw_factura["usuario"] . "'");
$rw_user = mysqli_fetch_array($sql_USER);

require_once(dirname(__FILE__) . '/../html2pdf.class.php');
// get the HTML
ob_start();
include(dirname('__FILE__') . '/res/ver_factura_html.php');
$content = ob_get_clean();

try {
    // init HTML2PDF
    $html2pdf = new HTML2PDF('P', $papel, 'es', true, 'UTF-8', array($mizq, $mtop, $mder, $mbot));
    // display the full page
    $html2pdf->pdf->SetDisplayMode('fullpage');
    // convert
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    // eleminar pdf anterior
    unlink('../output/Factura-' . $id_user . '.pdf');
    // guardar pdf nuevo
    $html2pdf->Output('../output/Factura-' . $id_user . '.pdf', 'F');
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}
