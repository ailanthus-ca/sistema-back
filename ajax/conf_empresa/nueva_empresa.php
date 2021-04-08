<?php
include '../../config/seccion.php';
if (empty($_SESSION['usuario'])) {
    header('Location: index.php');
}




/* Conectar a la base de datos */
include '../../config/conexion.php';

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';


if ($action == 'ajax') {

    $num_fiscal = mysqli_real_escape_string($con,(strip_tags($_POST["num_fiscal"], ENT_QUOTES)));
    $nombre = mysqli_real_escape_string($con,(strip_tags($_POST["nombre"], ENT_QUOTES)));
    $direccion = mysqli_real_escape_string($con,(strip_tags($_POST["direccion"], ENT_QUOTES)));
    $telefono = mysqli_real_escape_string($con,(strip_tags($_POST["telefono"], ENT_QUOTES)));
    $correo = mysqli_real_escape_string($con,(strip_tags($_POST["correo"], ENT_QUOTES)));
    $web = mysqli_real_escape_string($con,(strip_tags($_POST["web"], ENT_QUOTES)));
    $pago = mysqli_real_escape_string($con,(strip_tags($_POST["pago"], ENT_QUOTES)));
    $eslogan = mysqli_real_escape_string($con,(strip_tags($_POST["eslogan"], ENT_QUOTES)));

    $file = $_FILES["logo"];
    $logo = $file["name"];
    if ($logo != "") {
        $file = $_FILES["logo"];
        $logo = $file["name"];
        $tipo = $file["type"];
        $ruta_provisional = $file["tmp_name"];
        $size = $file["size"];
        $ruta_provisional = $file["tmp_name"];
        $dimensiones = getimagesize($ruta_provisional);
        $width = $dimensiones[0];
        $height = $dimensiones[1];
        $carpeta = "../../public/imagenes/";
        $src = $carpeta . $logo;
        move_uploaded_file($ruta_provisional, $src);
    }

    if ($num_fiscal != "" && $nombre != "" && $direccion != "" && $telefono != "" && $correo != "" && $web != "" && $pago != "") {
        if ($logo != "")
            $sql1 = "UPDATE conf_empresa SET nombre = UPPER('$nombre'), numero_fiscal = UPPER('$num_fiscal'), direccion = UPPER('$direccion'), telefono = UPPER('$telefono'), correo = UPPER('$correo'), web = UPPER('$web'), pago = UPPER('$pago'), logo = '$logo', eslogan = UPPER('$eslogan') ";
        else
            $sql1 = "UPDATE conf_empresa SET nombre = UPPER('$nombre'), numero_fiscal = UPPER('$num_fiscal'), direccion = UPPER('$direccion'), telefono = UPPER('$telefono'), correo = UPPER('$correo'), web = UPPER('$web'), pago = UPPER('$pago'), eslogan = UPPER('$eslogan') ";

        $query1 = $con->query($sql1);
        $messages[] = "Se han modficado los datos de la empresa";

        //Se guarda el cambio en la tabla configuracion como historial
        $cod_usuario = $_SESSION['id_usuario'];
        $con->query("INSERT into configuracion VALUES ('', $cod_usuario, 'configuracion de empresa', NOW())");
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