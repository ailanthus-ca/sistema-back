<?php
session_start();
if (empty($_SESSION['usuario'])) {
    header('Location: index.php');
}




/* Conectar a la base de datos */
include '../../config/conexion.php';

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';


if ($action == 'ajax') {
    $observacion = (isset($_POST["observacion"]) && $_POST["observacion"] != NULL) ? $_POST["observacion"] : ' ';
    $garantia = mysqli_real_escape_string($con,(strip_tags($_POST["garantia"], ENT_QUOTES)));
    $observacion = mysqli_real_escape_string($con,(strip_tags($observacion, ENT_QUOTES)));
    $envio = mysqli_real_escape_string($con,(strip_tags($_POST["envio"], ENT_QUOTES)));


    if ($garantia != "" && $observacion != "" && $envio != "") {
        $sql1 = "UPDATE conf_venta SET garantia = UPPER('$garantia'), observacion = UPPER('$observacion'), envio = $envio ";

        $query1 = $con->query($sql1);
        $messages[] = "Se han modficado los datos de venta";

        //Se guarda el cambio en la tabla configuracion como historial
        $cod_usuario = $_SESSION['id_usuario'];
        $con->query("INSERT into configuracion VALUES ('', $cod_usuario, 'configuracion de ventas', NOW())");
    } else
        $errors[] = "Ocurrio un error durante la operación";

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