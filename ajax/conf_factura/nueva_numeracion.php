<?php
include '../../config/seccion.php';
if (empty($_SESSION['usuario'])) {
    header('Location: index.php');
}




/* Conectar a la base de datos */
include '../../config/conexion.php';


$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';

if ($action == 'ajax') {

    $sql = $con->query("SELECT *from conf_factura");
    if ($row = $sql->fetch_array())
        $errors[] = "Ya se ha inicializado la numeración de la factura.";
    else {
        $num_factura = mysqli_real_escape_string($con, (strip_tags($_POST["num_factura"], ENT_QUOTES)));

        $sql1 = "INSERT into conf_factura values('',$num_factura,'','','','','','')";
        $query1 = $con->query($sql1);
        $messages[] = "Se ha modificado la numeración correctamente.";

        //Se guarda el cambio en la tabla configuracion como historial
        $cod_usuario = $_SESSION['id_usuario'];
        $con->query("INSERT into configuracion VALUES ('', $cod_usuario, 'configuracion de factura, numeracion', NOW())");
    }


    if (isset($errors)) {
        ?>
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Error!</strong>
        <?php
        foreach ($errors as $error) {
            echo $error;
        }
        ?>
        </div>
            <?php
        }

        if (isset($messages)) {
            ?>
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>¡Ajuste con exito!</strong>
        <?php
        foreach ($messages as $message) {
            echo $message;
        }
        ?>
        </div>
            <?php
        }
    } else
        
    ?>