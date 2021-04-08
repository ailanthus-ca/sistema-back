<?php


 session_start();
$id_user = $_SESSION['id_usuario'];
  if(empty($_SESSION['usuario']))
  {
    header('Location: login.php');
  }
	
	
	/* Connect To Database*/
	include '../../config/conexion.php';

    $sql_conf = $con->query("SELECT *from conf_factura");
    if ($row = mysqli_fetch_array($sql_conf)) 
    {
      $mtop = $row['margen_sup'];
      $mder = $row['margen_der'];
      $mizq = $row['margen_izq'];
      $mbot = $row['margen_inf'];
      $papel = $row['tipo_papel'];
    }

	$id_orden= $_GET['id_orden'];
	$sql_orden=$con->query("select * from ordencompra where codigo='".$id_orden."'");
	$count=mysqli_num_rows($sql_orden);
	if ($count==0)
	{
	echo "<script>alert('Orden no encontrada')</script>";
  echo $id_orden;
	echo "<script>window.close();</script>";
	exit;
	}
	
	$row=mysqli_fetch_array($sql_orden);
	$id_orden=$row['codigo'];
	$cod_proveedor=$row['cod_proveedor'];
  $fecha_orden = date_create($row['fecha']);
  $impuesto = $row['impuesto'];
  $subtotal = $row['subtotal'];
  $total = $row['total'];
  $forma_pago = $row['forma_pago'];
  $entrega = $row['tiempo_entrega'];
  $validez = $row['validez'];
  $nota = $row['nota'];

	require_once(dirname(__FILE__).'/../html2pdf.class.php');
    // get the HTML
     ob_start();
     include(dirname('__FILE__').'/res/ver_orden_html.php');
    $content = ob_get_clean();

    try
    {
        // init HTML2PDF
        $html2pdf = new HTML2PDF('P', $papel, 'es', true, 'UTF-8', array($mizq, $mtop, $mder, $mbot));
        // display the full page
        $html2pdf->pdf->SetDisplayMode('fullpage');
        // convert
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        // eleminar pdf anterior
        unlink('../output/Orden-'.$id_user.'.pdf');
        // guardar pdf nuevo
        $html2pdf->Output('../output/Orden-'.$id_user.'.pdf', 'F');

    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
