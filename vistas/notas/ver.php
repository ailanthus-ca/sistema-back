<?php
//CORREGIR PROBLEMA CON LA VARIABLE DE SESION 

include '../templates/template.php';
$id_user = $_SESSION['id_usuario'];
?>
<embed  style="margin-left: 20px;" src="./pdf/output/notasalida-<?php echo $id_user; ?>.pdf" width="1000" height="800"
        alt="pdf" pluginspage="https://www.adobe.com/products/acrobat/readstep2.html">
<?php
include("../templates/template_footer.php");
?>
</body>
</html>