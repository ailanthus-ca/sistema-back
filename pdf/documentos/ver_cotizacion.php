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

	$id_cotizacion= $_GET['id_cotizacion'];
	$sql_cot=$con->query("select * from cotizacion where codigo='".$id_cotizacion."'");
	$count=mysqli_num_rows($sql_cot);
	if ($count==0)
	{
	//echo "<script>alert('Cotizacion no encontrada')</script>";
  //echo $id_cotizacion;
	echo "<script>window.location.reload();</script>";
	exit;
	}
	
	$row=mysqli_fetch_array($sql_cot);
	$num_cotizacion=$row['codigo'];
	$id_cliente=$row['cod_cliente'];
	$fecha_cotizacion=$row['fecha'];
	$condiciones=$row['forma_pago'];
  $tiempo_entrega = $row['tiempo_entrega'];
	require_once(dirname(__FILE__).'/../html2pdf.class.php');
    // get the HTML
     ob_start();
     include(dirname('__FILE__').'/res/ver_cotizacion_html.php');
    $content = ob_get_clean();

    try
    {
        // init HTML2PDF
        $html2pdf = new HTML2PDF('P', $papel, 'es', true, 'UTF-8', array(15, 15, 15, 15));
        // display the full page
        $html2pdf->pdf->SetDisplayMode('fullpage');
        // convert
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        // eleminar pdf anterior
        unlink('../output/Cotizacion-'.$id_user.'.pdf');
        // guardar pdf nuevo
        $html2pdf->Output('../output/Cotizacion-'.$id_user.'.pdf', 'F');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
