<?php
session_start();
include '../../config/seccion.php';
if (empty($_SESSION['usuario'])) {
    header('Location: index.php');
}




/* Conectar a la base de datos */
include '../../../config/conexion.php';

$codigo = mysqli_real_escape_string($con, (strip_tags($_POST["codigo"], ENT_QUOTES)));
$descripcion = mysqli_real_escape_string($con, (strip_tags($_POST["descripcion"], ENT_QUOTES)));


$sql = $con->query("SELECT *from departamento WHERE descripcion = '$descripcion'");

if ($row = $sql->fetch_array()) {
    $errors[] = "Ya existe un registro con el mismo nombre.";
} else {

    $sql = "INSERT INTO departamento (codigo,descripcion, estatus) VALUES (UPPER('$codigo'),UPPER('$descripcion'),1)";
    $query = $con->query($sql);
    if ($query) {
        $messages[] = "Registrado con exito.";
    }
}
if (isset($errors)) {
    ?>
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Error!</strong> 
    <?php
    foreach ($errors as $error) {
        echo '<input id="bool" type="hidden" value="0"></input>';
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
        <strong></strong>
    <?php
    foreach ($messages as $message) {
        echo '<input id="bool" type="hidden" value="1"></input>';
        echo $message;
    }
    ?>
    </div>
        <?php
    }
    ?>