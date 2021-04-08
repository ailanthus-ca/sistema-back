<?php
/* Conectar a la base de datos */
include '../../config/conexion.php';
include '../horarios/horarios.php';
#se inicia la sesion
session_cache_expire(1000000);
session_start();
$correo = $con->escape_string((strip_tags($_POST["correo"], ENT_QUOTES)));
$clave = $con->escape_string((strip_tags($_POST["clave"], ENT_QUOTES)));
$fecha_actual = strtotime(date("d-m-Y H:i:00"));
$fecha_entrada = strtotime(date("d-m-Y " . $dia->Entrada));
$fecha_salida = strtotime(date("d-m-Y " . $dia->Salida));

$sql = $con->query("SELECT *FROM usuario WHERE correo = '$correo' ");

if ($user = $sql->fetch_array()) {

    if ($user['clave'] == crypt($clave, $user['clave']) && $user['estatus'] == 1) {
        if ($user['nivel'] == 0) {
            $_SESSION['id_usuario'] = $user['codigo'];
            $_SESSION['usuario'] = $user['nombre'];
            $_SESSION['nivel'] = $user['nivel'];
            ?><script>location.href = "panel_ad";</script><?php
        } elseif ($user['nivel'] == 1) {
            if ($dia->Laborable == 'true') {
                if ($fecha_entrada <= $fecha_actual && $fecha_salida >= $fecha_actual) {
                    $_SESSION['id_usuario'] = $user['codigo'];
                    $_SESSION['usuario'] = $user['nombre'];
                    $_SESSION['nivel'] = $user['nivel'];
                    ?><script>location.href = "panel_us";</script><?php
                } else {
                    ?>
                    <div class = "alert alert-warning" role = "alert">
                        <button type = "button" class = "close" data-dismiss = "alert">&times;
                        </button>
                        <strong>¡Advertencia!</strong>
                        Fuera del horario
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="alert alert-warning" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>¡Advertencia!</strong>
                    Es un dia no laborable
                </div>
                <?php
            }
        }
    } elseif ($user['clave'] == crypt($clave, $user['clave']) && $user['estatus'] == 0) {
        $messages[] = "Este usuario se encuentra inactivo. Por favor contacte con el administrador";
    } else {

        $messages[] = "Clave incorrecta";
    }
} else {
    $errors[] = "El correo no se encuentra registrado. Por favor ingrese un correo válido";
}



if (isset($errors)) {
    ?>
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Error!</strong> 
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
    <div class="alert alert-warning" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>¡Advertencia!</strong>
        <?php
        foreach ($messages as $message) {
            echo $message;
        }
        ?>
    </div>
    <?php
}

mysqli_close($con);
?>