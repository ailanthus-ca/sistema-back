<?php
/**
 * Created by PhpStorm.
 * User: Ailanthus
 * Date: 23-01-2018
 * Time: 10:36 AM
 */

$password1 = $_POST['password1'];
$password2 = $_POST['password2'];
$idusuario = $_POST['idusuario'];
$token = $_POST['token'];

include '../../config/conexion.php';

if( $password1 != "" && $password2 != "" && $idusuario != "" && $token != "" ){
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title> Recuperar contraseña </title>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
    </head>

    <body>
    <br><br><br><br>
    <div class="container" role="main">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <?php

            $sql = "SELECT * FROM resetclave WHERE token = '$token' ";
            $resultado = $con->query($sql);
            if( $usuario = mysqli_fetch_array($resultado)){
                if( sha1( $usuario['id_usuario'] === $idusuario ) ){
                    if( $password1 === $password2 ){
                        $sql = "UPDATE usuario SET clave = '".crypt($password1)."' WHERE codigo = ".$usuario['id_usuario'];
                        $resultado = $con->query($sql);
                        if($resultado){
                            $sql2 = "DELETE FROM resetclave WHERE token = '$token';";
                            $resultado = $con->query($sql2)
                            ?>
                            <p class="alert alert-info"> La contraseña se actualizó con exito.
                                <strong><a href="index.php">Volver al inicio</a></strong>
                            </p>
                            <?php
                        }
                        else{
                            ?>
                            <p class="alert alert-danger"> Ocurrió un error al actualizar la contraseña, intentalo más tarde </p>
                            <?php
                        }
                    }
                    else{
                        ?>
                        <p class="alert alert-danger"> Las contraseñas no coinciden </p>
                        <?php
                    }
                }
                else{
                    ?>
                    <p class="alert alert-danger"> El token no es válido </p>
                    <?php
                }
            }
            else{
                ?>
                <p class="alert alert-danger"> El token no es válido </p>
                <?php
            }
            ?>
        </div>
        <div class="col-md-2"></div>
    </div> <!-- /container -->
    <script src="./js/jquery-1.11.1.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    </body>
    </html>
    <?php
}
else{
    header('Location:index.php');
}
?>