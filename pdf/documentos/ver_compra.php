<?php

session_start();
$id_user = $_SESSION['id_usuario'];
if (empty($_SESSION['usuario'])) {
    header('Location: login.php');
}


/* conectar a la base de datos */
include '../../config/conexion.php';

$sql_conf = $con->query("SELECT *from conf_factura");
if ($row = mysqli_fetch_array($sql_conf)) {
    $mtop = $row['margen_sup'];
    $mder = $row['margen_der'];
    $mizq = $row['margen_izq'];
    $mbot = $row['margen_inf'];
    $papel = $row['tipo_papel'];
}


$id_compra = $_GET['id_compra'];
$sql_compra = $con->query("select * from compra where codigo='" . $id_compra . "'");
$count = mysqli_num_rows($sql_compra);
if ($count == 0) {
    echo "<script>alert('Compra no encontrada')</script>";
    echo $id_compra;
    echo "<script>window.close();</script>";
    exit;
}

$row_compra = mysqli_fetch_array($sql_compra);

$cod_compra = $row_compra['codigo'];
$cod_documento = $row_compra['cod_documento'];
$id_proveedor = $row_compra['cod_proveedor'];
$fecha2 = $row_compra['fecha'];
$fecha_documento = $row_compra['fecha_documento'];
require_once(dirname(__FILE__) . '/../html2pdf.class.php');
// get the HTML
ob_start();
include(dirname('__FILE__') . '/res/ver_compra_html.php');
$content = ob_get_clean();

try {
    // init HTML2PDF
    $html2pdf = new HTML2PDF('P', $papel, 'es', true, 'UTF-8', array($mizq, $mtop, $mder, $mbot));
    // display the full page
    $html2pdf->pdf->SetDisplayMode('fullpage');
    // convert
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    // eleminar pdf anterior
    unlink('../output/Compra-' . $id_user . '.pdf');
    // guardar pdf nuevo
    $html2pdf->Output('../output/Compra-' . $id_user . '.pdf', 'F');
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}
