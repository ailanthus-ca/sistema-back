<?php

function login() {
    /* Conectar a la base de datos */
    include '../config/conexion.php';
    #se inicia la sesion
    header('Access-Control-Allow-Origin: *');
ini_set('session.cookie_domain', 'sistema.ailanthus.com.ve/' );
//session_start();
    $correo = mysqli_real_escape_string($con,(strip_tags($_REQUEST["correo"], ENT_QUOTES)));
    $clave = mysqli_real_escape_string($con,(strip_tags($_REQUEST["clave"], ENT_QUOTES)));
    $resp = new stdClass();
    // $format = strtolower($_GET['format']) == 'json' ? 'json' : 'xml'; //xml es por defecto   
    $sql = $con->query("SELECT *FROM usuario WHERE correo = '$correo' ");
    if ($user = $sql->fetch_array()) {
        if ($user['clave'] == crypt($clave, $user['clave']) && $user['estatus'] == 1) {
            $resp->respuesta = true;
            $resp->msn = 'Usuario Logueado con exito';
            $resp->codigo = $user['codigo'];
            $resp->usuario = $user['nombre'];
            $resp->nivel = $user['nivel'];
            $resp->session = session_id(); 
            $_SESSION['id_usuario'] = $user['codigo'];
            $_SESSION['usuario'] = $user['nombre'];
            $_SESSION['nivel'] = $user['nivel'];
            // header('Content-type: application/json');
        } elseif ($user['clave'] == crypt($clave, $user['clave']) && $user['estatus'] == 0) {
            $resp->respuesta = FALSE;
            $resp->msn = "Este usuario se encuentra inactivo. Por favor contacte con el administrador";
        } else {
            $resp->respuesta = FALSE;
            $resp->msn = "Clave incorrecta";
        }
    } else {
        $resp->respuesta = FALSE;
        $resp->error = "El correo no se encuentra registrado. Por favor ingrese un correo válido";
    }
    echo json_encode($resp);
    if (isset($errors)) {
        if ($format == 'json') {
            header('Content-type: application/json');
            echo json_encode($errors);
        }
        if (isset($messages)) {
            if ($format == 'json') {
                header('Content-type: application/json');
                echo json_encode($messages);
            }
        }
        mysqli_close($con);
    }
}

login();
?>