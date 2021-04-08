<?php
include '../../config/seccion.php';
/* if (empty($_SESSION['usuario'])) {
  header('Location: index.php');
  } */
/* Conectar a la base de datos */
include '../../config/conexion.php';

$codigo = mysqli_real_escape_string($con, (strip_tags($_POST["codigo"], ENT_QUOTES)));
$nombre = mysqli_real_escape_string($con, (strip_tags($_POST["nombre"], ENT_QUOTES)));
$telefono = mysqli_real_escape_string($con, (strip_tags($_POST["telefono"], ENT_QUOTES)));
$email = mysqli_real_escape_string($con, (strip_tags($_POST["correo"], ENT_QUOTES)));
$contacto = mysqli_real_escape_string($con, (strip_tags($_POST["contacto"], ENT_QUOTES)));
$direccion = mysqli_real_escape_string($con, (strip_tags($_POST["direccion"], ENT_QUOTES)));
$tipo_contribuyente = mysqli_real_escape_string($con, (strip_tags($_POST["tipo_contribuyente"], ENT_QUOTES)));

$retencion = intval($_POST['retencion']);
$estado = intval($_POST['estatus']);

$sql = $con->query("SELECT *from cliente WHERE codigo = '$codigo'");

if ($row = $sql->fetch_array()) {
    $errors[] = "Ya existe un cliente con el mismo codigo.";
} else {

    $sql = "INSERT INTO cliente (codigo,nombre,correo,direccion,contacto,telefono,tipo_contribuyente, retencion, estatus) VALUES (UPPER('$codigo'),UPPER('$nombre'), UPPER('$email'),UPPER('$direccion'),UPPER('$contacto'),'$telefono',
					UPPER('$tipo_contribuyente'),$retencion,$estado)";
    $query = $con->query($sql);
    if ($query) {
        $messages[] = "Cliente registrado satisfactoriamente.";
    }
}



if (isset($errors)) {
    ?>
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Error!</strong> 
        <?php
        foreach ($errors as $error) {
            echo $error;
            //input oculto para usarse como un booleano
            echo '<input id="bool" type="hidden" value="0"></input>';
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
            echo $message;
            //input oculto para usarse como un booleano
            echo '<input id="bool" type="hidden" value="1"></input>';
        }
        ?>
    </div>
    <?php
}
?>