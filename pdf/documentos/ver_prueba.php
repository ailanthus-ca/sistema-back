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
      $mtop = $row['margen_sup'];
      $mder = $row['margen_der'];
      $mizq = $row['margen_izq'];
      $mbot = $row['margen_inf'];
      $papel = $row['tipo_papel'];
    }


	require_once(dirname(__FILE__).'/../html2pdf.class.php');
    // get the HTML
     ob_start();
     include(dirname('__FILE__').'/res/ver_prueba_html.php');
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
        unlink('../output/Prueba.pdf');
        // guardar pdf nuevo
        $html2pdf->Output('../output/Prueba.pdf', 'F');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
