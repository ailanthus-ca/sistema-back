<?php

  //CORREGIR PROBLEMA CON LA VARIABLE DE SESION 
  
  session_start();
 

  include '../templates/template.php';
  
?>

<!DOCTYPE html>
<html lang="en">
  <head>

  </head>
  <br><br><br>
  <body>

      <!--En 192.168.1.31/ailanthus/-->

      <embed style="margin-left: 20px; margin-top: -30px;" src="./pdf/output/Reporte_inventario.pdf" width="1000" height="800" alt="pdf" pluginspage="https://www.adobe.com/products/acrobat/readstep2.html">
      
      <!--Servidor-->
    
      <!--<iframe id="pdfviewer" style="margin-left: 20px; margin-top: -30px;" src="https://docs.google.com/gview?embedded=true&url=///pdf/output/Reporte_inventario.pdf&amp;embedded=true" frameborder="0" width="1000" height="800"></iframe>
        -->

  	<?php
	include("../templates/template_footer.php");
	?>
  </body>
</html>