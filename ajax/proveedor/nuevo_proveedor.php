<?php
session_start();
/*if (empty($_SESSION['usuario'])) {
    header('Location: index.php');
}*/




/* Conectar a la base de datos */
include '../../config/conexion.php';

$codigo = mysqli_real_escape_string($con,(strip_tags($_POST["codigo"], ENT_QUOTES)));
$nombre = mysqli_real_escape_string($con,(strip_tags($_POST["nombre"], ENT_QUOTES)));
$telefono = mysqli_real_escape_string($con,(strip_tags($_POST["telefono"], ENT_QUOTES)));
$email = mysqli_real_escape_string($con,(strip_tags($_POST["email"], ENT_QUOTES)));
$contacto = mysqli_real_escape_string($con,(strip_tags($_POST["contacto"], ENT_QUOTES)));
$direccion = mysqli_real_escape_string($con,(strip_tags($_POST["direccion"], ENT_QUOTES)));
$estado = intval($_POST['estado']);

$sql = $con->query("SELECT *from proveedor WHERE codigo = '$codigo'");

if ($row = $sql->fetch_array()) {
    $errors[] = "Ya existe un proveedor con el mismo codigo.";
} else {

    $sql = "INSERT INTO proveedor (codigo,nombre,correo,direccion,contacto,telefono,estatus) VALUES (UPPER('$codigo'),UPPER('$nombre'), UPPER('$email'),UPPER('$direccion'),UPPER('$contacto'),'$telefono',$estado)";
    $query = $con->query($sql);
    if ($query) {
        $messages[] = "Proveedor registrado satisfactoriamente.";
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
        <strong>¡Registo con exito!</strong>
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