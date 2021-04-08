<?php

//CORREGIR PROBLEMA CON LA VARIABLE DE SESION

session_start();
/*
if(empty($_SESSION['usuario']))
{
  header('Location: index.php');
}
else
{
  if ($_SESSION['nivel']==0)
  {
   include '../templates/template.php';
  }
  elseif ($_SESSION['nivel']==1)
  {
   include 'templates/template.php';
  }
  else
  {
    include 'templates/template_vendedor.php';
  }
}*/

include '../templates/template.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>

</head>
<br><br><br>
<body>

<!--En 192.168.1.31/ailanthus/-->

<embed  style="margin-left: 20px;" src="./pdf/output/rubro.pdf" width="1000"
        height="800" alt="pdf" pluginspage="https://www.adobe.com/products/acrobat/readstep2.html">

    <!--Servidor

    <iframe id="pdfviewer" style="margin-left: 20px; margin-top: -30px;" src="https://docs.google.com/gview?embedded=true&url=///pdf/output/rubro.pdf&amp;embedded=true" frameborder="0" width="1000" height="800"></iframe>
    -->

    <?php
    include("../templates/template_footer.php");
    ?>
</body>
</html>