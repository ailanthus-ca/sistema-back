<?php

session_start();
if (empty($_SESSION['usuario'])) {
    header('Location: login.php');
}


/* conectar a la base de datos */
include '../../config/conexion.php';


$hoy = $_POST['hoy'];
$mes = $_POST['mes'];
$fecha1 = $_POST['fecha1'];
$fecha2 = $_POST['fecha2'];
$otro = $_POST['otro'];
$user = $_POST['user'];
$ano = $_POST['ano'];

$sql_conf = $con->query("SELECT *from conf_factura");
if ($row = mysqli_fetch_array($sql_conf)) {
    $mtop = $row['margen_sup'];
    $mder = $row['margen_der'];
    $mizq = $row['margen_izq'];
    $mbot = $row['margen_inf'];
    $papel = $row['tipo_papel'];
}

if ($hoy != '') {
    $query = "SELECT factura.codigo AS codigo ,cliente.nombre AS nombre, fecha, total from factura,cliente WHERE fecha = '$hoy' AND cliente.codigo = factura.cod_cliente AND usuario=$user AND `factura`.`estatus` = 2";
    $date1 = new DateTime($hoy);
    $titulo = " DEL " . $date1->format("d-m-Y");
} elseif ($mes != '') {
    $query = "SELECT factura.codigo AS codigo ,cliente.nombre AS nombre, fecha, total from factura,cliente WHERE month(fecha) = $mes and YEAR(fecha) = $ano AND cliente.codigo = factura.cod_cliente AND usuario=$user AND `factura`.`estatus` = 2";
    switch ($mes) {
        case 1:
            $m = "ENERO";
            break;
        case 2:
            $m = "FEBRERO";
            break;
        case 3:
            $m = "MARZO";
            break;
        case 4:
            $m = "ABRIL";
            break;
        case 5:
            $m = "MAYO";
            break;
        case 6:
            $m = "JUNIO";
            break;
        case 7:
            $m = "JULIO";
            break;
        case 8:
            $m = "AGOSTO";
            break;
        case 9:
            $m = "SEPTIEMBRE";
            break;
        case 10:
            $m = "OCTUBRE";
            break;
        case 11:
            $m = "NOVIEMBRE";
            break;
        case 12:
            $m = "DICIEMBRE";
    }
    $titulo = "DEL MES " . $m ." ".$ano;
} elseif ($fecha1 != '' && $fecha2 != '') {
    $query = "SELECT factura.codigo AS codigo ,cliente.nombre AS nombre, fecha, total from factura,cliente WHERE fecha between '$fecha1' AND '$fecha2'  AND cliente.codigo = factura.cod_cliente AND usuario=$user AND `factura`.`estatus` = 2";
    $date1 = new DateTime($fecha1);
    $date2 = new DateTime($fecha2);
    $titulo = "DESDE " . $date1->format("d-m-Y") . " HASTA " . $date2->format("d-m-Y");
} elseif ($otro != '') {
    if ($otro == 1) {
        $query = "SELECT factura.codigo AS codigo ,cliente.nombre AS nombre, fecha, total from factura,cliente WHERE YEARWEEK(fecha) = YEARWEEK(CURDATE()) AND cliente.codigo = factura.cod_cliente AND usuario=$user AND `factura`.`estatus` = 2";
        $titulo = "SEMANA ACTUAL";
    } elseif ($otro == 2) {
        $query = "SELECT factura.codigo AS codigo ,cliente.nombre AS nombre, fecha, total from factura,cliente WHERE YEAR(fecha) = YEAR(CURDATE()) AND WEEKOFYEAR(fecha) = (WEEKOFYEAR(CURDATE())-1) AND cliente.codigo = factura.cod_cliente AND usuario=$user AND `factura`.`estatus` = 2";
        $titulo = "SEMANA PASADA";
    } elseif ($otro == 3) {
        $query = "SELECT factura.codigo AS codigo ,cliente.nombre AS nombre, fecha, total from factura,cliente WHERE YEAR(fecha) = YEAR(CURDATE()) AND WEEKOFYEAR(fecha) = (WEEKOFYEAR(CURDATE())-2) AND cliente.codigo = factura.cod_cliente AND usuario=$user AND `factura`.`estatus` = 2";
        $titulo = "HACE 3 SEMANAS";
    }
}
$ven = $con->query("select nombre from usuario WHERE codigo = $user");
if ($row = mysqli_fetch_array($ven)) {
    $vendedor = $row['nombre'];
}

require_once(dirname(__FILE__) . '/../html2pdf.class.php');
// get the HTML
ob_start();
include(dirname('__FILE__') . '/res/ver_reporte_vendedor_html.php');
$content = ob_get_clean();

try {
    // init HTML2PDF
    $html2pdf = new HTML2PDF('P', $papel, 'es', true, 'UTF-8', array($mizq, $mtop, $mder, $mbot));
    // display the full page
    $html2pdf->pdf->SetDisplayMode('fullpage');
    // convert
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    // send the PDF
    //$html2pdf->Output('Reporte_ventas.pdf');
    // eleminar pdf anterior
    unlink('../output/Reporte_vendedor.pdf');
    // guardar pdf nuevo
    $html2pdf->Output('../output/Reporte_vendedor.pdf', 'F');
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}
