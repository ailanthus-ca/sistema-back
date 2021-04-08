<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>instalar</title>
        <!-- archivo CSS del login -->
        <link rel="stylesheet" href="../public/css/login.css" type="text/css" media="screen" >
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.css" type="text/css" media="screen" >
        <link rel="icon" href="../public/imagenes/logo estandar.png" type="image/x-icon">
    </head>
    <body style="background: #FFF; margin: 0px;">
        <div class="row">
            <br><br><br><br><br>
            <form method="POST" enctype="multipart/form-data"  class="col-md-10 col-md-offset-1">
                <?php
                $guardar = true;
                include '../config/conexion.php';
                $sqluser = $con->query('SELECT * FROM `usuario`');
                $sqlempresa = $con->query('SELECT * FROM `conf_empresa`');
                $sqlregion = $con->query('SELECT * FROM `conf_region`');
                $sqlventa = $con->query('SELECT * FROM `conf_venta`');
                $sqlfactura = $con->query('SELECT * FROM `conf_factura`');
                if ($sqluser->num_rows == 0) {
                    include './user.php';
                } else if ($sqlempresa->num_rows == 0) {
                    include './empresa.php';
                } else if ($sqlregion->num_rows == 0) {
                    include './region.php';
                } else if ($sqlfactura->num_rows == 0) {
                    include './factura.php';
                } else if ($sqlventa->num_rows == 0) {
                    include './ventas.php';
                } else {
                    function rmDir_rf($carpeta) {
                        foreach (glob($carpeta . "/*") as $archivos_carpeta) {
                            if (is_dir($archivos_carpeta)) {
                                rmDir_rf($archivos_carpeta);
                            } else {
                                unlink($archivos_carpeta);
                            }
                        }
                        rmdir($carpeta);
                    }
                    rmDir_rf('../install');
                    header("Location: /");
                }
                ?>
                <div class="col-md-12">
                    <div class="pull-right">       
                        <button id="guardar" type="submit" class="btn btn-default btn-lg" data-toggle="tooltip" data-placement="top" title="Guardar cambios">
                            <span class="glyphicon glyphicon-floppy-disk"></span>
                        </button>
                    </div>  
                </div>
                <script>
                    $(document).ready(function () {
                        $('[data-toggle="tooltip"]').tooltip();
                    });
                </script>
            </form>
        </div>
        <br><br><br><br><br>
    </body>
</html>