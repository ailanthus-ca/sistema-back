<?php
header('Access-Control-Allow-Origin: *');
ini_set('session.cookie_domain', 'sistema.ailanthus.com.ve/' );
//session_start();
if (isset($_SESSION['id_usuario'])) {
    echo 'funciona';
    echo $_SESSION['usuario'];
} else {
    echo 'intenta otra ves';
}    