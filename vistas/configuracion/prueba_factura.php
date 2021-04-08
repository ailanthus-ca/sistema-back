<?php

 include '../templates/template.php';
 include '../../config/conexion.php';

?>

<!DOCTYPE html>
<html lang="en">
  <head>

  </head>
  <br><br><br>
  <body>

      <!--En 192.168.1.31/ailanthus/--> 
        -<embed  style="margin-left: 20px;" src="pdf/output/Prueba.pdf" width="1000" height="800"
                 alt="pdf" pluginspage="https://www.adobe.com/products/acrobat/readstep2.html">

      <!--En servidor-->
      
      <!--<iframe id="pdfviewer" style="margin-left: 20px; margin-top: -30px;" src="https://docs.google.com/gview?embedded=true&url=//pdf/output/Prueba.pdf&amp;embedded=true" frameborder="0" width="1000" height="800"></iframe>
        -->
    <?php
    include("../templates/template_footer.php");
    ?>
  </body>
</html>