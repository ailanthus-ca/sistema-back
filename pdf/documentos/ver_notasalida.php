<?php

session_start();
$user = $_SESSION['id_usuario'];
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
$id_nota = (isset($_REQUEST['id']) && $_REQUEST['id'] != NULL) ? $_REQUEST['id'] : 'null';

$sql_not = $con->query("select * from notasalida where codigo='" . $id_nota . "'") or die(mysqli_error());
if ($sql_not->num_rows == 0) {
    //echo "<script>alert('Cotizacion no encontrada')</script>";
    //echo $id_cotizacion;
    echo "<script>window.location.reload();</script>";
    exit;
}
$row = $sql_not->fetch_array();
$num_cotizacion = $row['codigo'];
$id_cliente = $row['cod_cliente'];
$fecha_cotizacion = $row['fecha'];
$nota = $row['nota'];
$usersql = $con->query("select nombre from usuario where codigo=" . $row['usuario']) or die(mysqli_error());
$userrow = $usersql->fetch_array();
$username = $userrow['nombre'];
require_once(dirname(__FILE__) . '/../html2pdf.class.php');
// get the HTML
ob_start();
include(dirname('__FILE__') . '/res/ver_notasalida_html.php');
$content = ob_get_clean();

try {
    // init HTML2PDF
    $html2pdf = new HTML2PDF('P', $papel, 'es', true, 'UTF-8', array(18, 20, 18, 20));
    // display the full page
    $html2pdf->pdf->SetDisplayMode('fullpage');
    // convert
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    // eleminar pdf anterior
    unlink('../output/notasalida-' . $_SESSION['id_usuario'] . '.pdf');
    // guardar pdf nuevo
    $html2pdf->Output('../output/notasalida-' . $_SESSION['id_usuario'] . '.pdf', 'F');
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}
