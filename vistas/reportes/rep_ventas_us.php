<?php

  //CORREGIR PROBLEMA CON LA VARIABLE DE SESION 
  
  include '../templates/template.php';
  
?>

<!DOCTYPE html>
<html lang="en">
  <head>

  </head>
  <br><br><br>
  <body>
        <embed style="margin-left: 20px; margin-top: -30px;" src="./pdf/output/Reporte_vendedor.pdf" width="1000" height="800" alt="pdf" pluginspage="https://www.adobe.com/products/acrobat/readstep2.html">

  	<?php
	include("../templates/template_footer.php");
	?>
  </body>
</html>