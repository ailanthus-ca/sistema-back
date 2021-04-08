<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Recuperar contraseña</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css" media="screen" />
    <link rel="icon" href="../favicon.ico" type="image/x-icon">
</head>
<body>
<br><br><br><br>
<form id="frmRestablecer" action="" method="post">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading"> Restaurar contraseña </div>
            <div class="panel-body">
                <div class="form-group">
                    <label for="email"> Escribe el email asociado a tu cuenta para recuperar tu contraseña </label>
                    <input type="email" id="email" class="form-control" name="email" required>
                </div>
                <div class="form-group">
                    <input type="submit" style="background-color: #506E77; color: #fff; border-color: #506E77" class="btn btn-primary" value="Recuperar contraseña" >
                </div>
            </div>
        </div>
    </div>
</form>
<?php
include '../templates/template_footer.php';
?>

<div id="mensaje"></div>
<script type="text/javascript" src="./js/reset_clave.js"></script>
</body>
</html>