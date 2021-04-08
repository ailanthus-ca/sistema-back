<?php


 session_start();
  if(empty($_SESSION['usuario']))
  {
    header('Location: login.php');
  }
	
	
	/* conectar a la base de datos*/
	include '../../config/conexion.php';

  $sql_conf = $con->query("SELECT *from conf_factura");
    if ($row = mysqli_fetch_array($sql_conf)) 
    {
      $mtop  = $row['margen_sup'];
      $mder  = $row['margen_der'];
      $mizq  = $row['margen_izq'];
      $mbot  = $row['margen_inf'];
      $papel = $row['tipo_papel'];
    }

    $mes = $_POST['mes'];
    $ano = $_POST['ano'];
switch ($mes){
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
  //Query del reporte de rubros por mes especifico
$query = "SELECT detallefactura.codProducto as codigo, producto.descripcion as descripcion, SUM( detallefactura.cantidad ) as cantidad , SUM( detallefactura.monto ) as monto
            FROM detallefactura, producto, factura
            WHERE producto.codigo = codProducto
            and factura.codigo = codFactura
            AND MONTH( fecha ) = ".$mes."
            AND YEAR( fecha ) = ".$ano."
            AND factura.estatus =2
            AND `factura`.`estatus` = 2
            GROUP BY (detallefactura.codProducto)";
echo json_encode($query);
require_once(dirname(__FILE__).'/../html2pdf.class.php');
    // get the HTML
     ob_start();
     include(dirname('__FILE__').'/res/reporte_rubro_html.php');
    $content = ob_get_clean();

    try
    {
        // init HTML2PDF
        $html2pdf = new HTML2PDF('P', $papel, 'es', true, 'UTF-8', array($mizq, $mtop, $mder, $mbot));
        // display the full page
        $html2pdf->pdf->SetDisplayMode('fullpage');
        // convert
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        // send the PDF
        //$html2pdf->Output('Seguimiento.pdf');
        // eleminar pdf anterior
        unlink('../output/rubro.pdf');
        // guardar pdf nuevo
        $html2pdf->Output('../output/rubro.pdf', 'F');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }