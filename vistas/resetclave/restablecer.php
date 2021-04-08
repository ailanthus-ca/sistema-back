<?php
/**
 * Created by PhpStorm.
 * User: Ailanthus
 * Date: 23-01-2018
 * Time: 10:10 AM
 */

$token = $_GET['token'];
$idusuario = $_GET['idusuario'];

include '../../config/conexion.php';

$sql = "SELECT * FROM resetclave WHERE token = '$token'";
$resultado = $con->query($sql);

if($usuario = mysqli_fetch_array($resultado)){
    if( sha1($usuario['id_usuario']) == $idusuario ){
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title> Recuperar contraseña </title>
            <link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css" media="screen" />
        </head>

        <body>
        <br><br><br><br>
        <div class="container" role="main">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <form action="cambiarclave.php" method="post">
                    <div class="panel panel-default">
                        <div class="panel-heading"> Restaurar contraseña </div>
                        <div class="panel-body">
                            <p></p>
                            <div class="form-group">
                                <label for="password"> Nueva contraseña </label>
                                <input type="password" class="form-control" name="password1" required>
                            </div>
                            <div class="form-group">
                                <label for="password2"> Confirmar contraseña </label>
                                <input type="password" class="form-control" name="password2" required>
                            </div>
                            <input type="hidden" name="token" value="<?php echo $token ?>">
                            <input type="hidden" name="idusuario" value="<?php echo $idusuario ?>">
                            <div class="form-group">
                                <input type="submit" style="background-color: #506E77; color: #fff; border-color: #506E77;" class="btn btn-primary" value="Recuperar contraseña" >
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4"></div>
        </div> <!-- /container -->

        <script type="text/javascript" src="./js/jquery-3.2.1.js"></script>
        <script type="text/javascript" src="/bootstrapjs/bootstrap.js"></script>
        </body>
        </html>
        <?php
    }
    else{
        header('Location:index.php');
    }
}
else{
    header('Location:index.php');
}
?>