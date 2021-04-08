<!DOCTYPE html>
<html>
    <?php
    include 'config/conexion.php';
    $sql2 = $con->query("SELECT * FROM `conf_empresa`");
    if ($row = $sql2->fetch_array()) {
        $logo = $row['logo'];
    }else{
        header("Location: /install");
    }
    ?>
    <head>
        <meta charset="utf-8">
        <title>Login</title>
        <!-- archivo CSS del login -->
        <link rel="stylesheet" href="public/css/login.css" type="text/css" media="screen" >
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css" type="text/css" media="screen" >
        <link rel="icon" href="public/imagenes/logo estandar.png" type="image/x-icon">
    </head>
    <body style="background: #FFF; margin: 0px;">

        <div class="container" >
            <div class="col-xs-6 col-xs-offset-3 col-md-4 col-md-offset-4">
                <img src="public/imagenes/<?php echo $logo ?>" alt="Responsive image" class="img-responsive" alt="Logo"  >
            </div>
            <form class="col-xs-12 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4 row" name="form_login" id="form_login" method="POST">
                <div id="resultados_ajax" ></div>
                <br>
                <br>
                <div class="row loginbox">
                    <div class="col-xs-12">
                        <span class="singtext" >Ingresar </span>
                    </div>

                    <div class="col-xs-12">
                        <input class="form-control" type="text" placeholder="Por favor ingrese su correo" name="correo" required>
                    </div>
                    <div class="col-xs-12">
                        <input class="form-control" type="password" placeholder="Por favor ingrese su contraseña" name="clave" required>
                    </div>
                    <div class="col-xs-12">
                        <input type="submit" class="btn  submitButton" name="submit" value="Aceptar">
                    </div>

                </div><div class="row forGotPassword">
                    <a href="resetclave" id="recuperar" name="recuperar" > ¿olvido su contraseña? </a>
                </div>
                <br>
                <!--footer Section ends-->
                </div>

            </form>
            <footer  class="footer">
                <a href='#'>Terminos de uso</a>  |  
                <a href='#'>Contacto</a>  
                <p >©2017   Ailanthus Sistems C.A Todos los derechos reservados </p>
            </footer>
            <?php
            include 'vistas/templates/template_footer.php';
            ?>
            <script type="text/javascript" src="js/login.js"></script>
    </body>


</html>