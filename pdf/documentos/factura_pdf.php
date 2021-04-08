<?php

 session_start();
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

  /*
	$sql_count=$con->query("select * from tmp");
	$count=mysqli_num_rows($sql_count);
	if ($count==0)
	{
	echo "<script>alert('No hay productos agregados a la factura')</script>";
	echo "<script>window.close();</script>";
	exit;
	}
*/
	require_once(dirname(__FILE__).'/../html2pdf.class.php');
		
	//Variables por GET
	$id_cliente=$_GET['id_cliente'];
	$num_factura=$_GET['num_factura'];
	$condicion=mysqli_real_escape_string((strip_tags($_REQUEST['condicion'], ENT_QUOTES)));

	//Fin de variables por GET
	//$sql=mysqlii_query($con, "select LAST_INSERT_ID(codigo) as last from factura order by codigo desc limit 0,1 ");
	//$rw=mysqlii_fetch_array($sql);
	//$numero_factura=$rw['last']+1;	
	//$simbolo_moneda=get_row('configuracion','moneda', 'id_perfil', 1);
    // get the HTML
     ob_start();
     include(dirname('__FILE__').'/res/factura_html.php');
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
        $html2pdf->Output('Factura.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

    mysqli_close($con);

?>    