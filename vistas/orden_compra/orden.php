<?php
include '../templates/template.php';
$id_user = $_SESSION['id_usuario'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>

    </head>
    <br><br><br>
    <body>
        <embed  style="margin-left: 20px;" src="./pdf/output/Orden-<?php echo $_SESSION['id_usuario'] ?>.pdf" width="1000" height="800"
                alt="pdf" pluginspage="https://www.adobe.com/products/acrobat/readstep2.html">

<?php
include("../templates/template_footer.php");
?>
    </body>
</html>