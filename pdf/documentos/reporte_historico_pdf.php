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
$cod = $_POST['codigo'];
$des = $_POST['des'];
$sql_conf = $con->query("SELECT *from conf_factura");
if ($row = mysqli_fetch_array($sql_conf)) {
    $mtop = $row['margen_sup'];
    $mder = $row['margen_der'];
    $mizq = $row['margen_izq'];
    $mbot = $row['margen_inf'];
    $papel = $row['tipo_papel'];
}

if ($hoy != '') {
    $where = "";
    $titulo = "DESDE EL INICIO DE LOS TIEMPOS";
} elseif ($mes != '') {
    $where = "and month(fecha) = $mes";
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
    $titulo = "DEL MES " . $m;
} elseif ($fecha1 != '' && $fecha2 != '') {
    $where = "fecha between '$fecha1' AND '$fecha2'";
    $date1 = new DateTime($fecha1);
    $date2 = new DateTime($fecha2);
    $titulo = "DESDE " . $date1->format("d-m-Y") . " HASTA " . $date2->format("d-m-Y");
} elseif ($otro != '') {
    if ($otro == 1) {
        $where = "YEAR(fecha) = YEAR(CURDATE()) AND WEEKOFYEAR(fecha) = (WEEKOFYEAR(CURDATE()))";
        $titulo = "SEMANA ACTUAL";
    } elseif ($otro == 2) {
        $where = "YEAR(fecha) = YEAR(CURDATE()) AND WEEKOFYEAR(fecha) = (WEEKOFYEAR(CURDATE())-1)";
        $titulo = "SEMANA PASADA";
    } elseif ($otro == 3) {
        $where = "YEAR(fecha) = YEAR(CURDATE()) AND WEEKOFYEAR(fecha) = (WEEKOFYEAR(CURDATE())-2)";
        $titulo = "HACE 3 SEMANAS";
    }
}

$his = array();
$sql = $con->query("select fecha,compra.codigo as codigo,proveedor.nombre as nombre,cantidad from compra,detallecompra,proveedor WHERE proveedor.codigo=cod_proveedor and compra.codigo=cod_compra and compra.estatus = 2 and cod_producto = '$cod' " . $where);
while ($row = $sql->fetch_array()) {
    $his[] = array(
        'fecha' => $row['fecha'],
        'orden' => strtotime($row['fecha']),
        'tipo' => 'ENTRADA',
        'opera' => 'COMPRA',
        'codigo' => $row['codigo'],
        'nombre' => $row['nombre'],
        'cantidad' => $row['cantidad']
    );
}
$sql = $con->query("select fecha,factura.codigo as codigo,cliente.nombre as nombre,cantidad from factura,detallefactura,cliente WHERE cliente.codigo=cod_cliente and factura.codigo=codFactura and factura.estatus = 2 and codProducto = '$cod' " . $where);
while ($row = $sql->fetch_array()) {
    $his[] = array(
        'fecha' => $row['fecha'],
        'orden' => strtotime($row['fecha']),
        'tipo' => 'SALIDA',
        'opera' => 'VENTA',
        'codigo' => $row['codigo'],
        'nombre' => $row['nombre'],
        'cantidad' => $row['cantidad']
    );
}
$sql = $con->query("select fecha,ajusteinv.codigo as codigo,tipo_ajuste,usuario.nombre as nombre,cantidad from ajusteinv,detalleajusteinv,usuario WHERE usuario.codigo=usuario and ajusteinv.codigo=cod_ajuste and cod_producto = '$cod' " . $where);
while ($row = $sql->fetch_array()) {
    $his[] = array(
        'fecha' => $row['fecha'],
        'orden' => strtotime($row['fecha']),
        'tipo' => $row['tipo_ajuste'],
        'opera' => 'AJUSTE',
        'codigo' => $row['codigo'],
        'nombre' => $row['nombre'],
        'cantidad' => $row['cantidad']
    );
}

$sql = $con->query("select fecha,notasalida.codigo as codigo,cliente.nombre as nombre,cantidad from notasalida,detallesNotas,cliente WHERE cliente.codigo=notasalida.cod_cliente and notasalida.codigo=detallesNotas.nota and notasalida.estatus=1 and detallesNotas.producto = '$cod' " . $where);
while ($row = $sql->fetch_array()) {
    $his[] = array(
        'fecha' => $row['fecha'],
        'orden' => strtotime($row['fecha']),
        'tipo' => 'SALIDA',
        'opera' => 'NOTA DE ENTREGA',
        'codigo' => $row['codigo'],
        'nombre' => $row['nombre'],
        'cantidad' => $row['cantidad']
    );
}

function ordenar($a, $b) {
    return $a['orden'] - $b['orden'];
}

usort($his, 'ordenar');



require_once(dirname(__FILE__) . '/../html2pdf.class.php');
// get the HTML
ob_start();
include(dirname('__FILE__') . '/res/historico_html.php');
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
    unlink('../output/historico.pdf');
    // guardar pdf nuevo
    $html2pdf->Output('../output/historico.pdf', 'F');
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}
