<?php

header('Access-Control-Allow-Origin: *');
////ini_set('session.cookie_domain', '*.ailanthus.com.ve/' );
////session_start();
//if (empty($_SESSION['usuario'])) {}else{
    require_once 'AACotizacion.php';
    $c = new cotizacion();
    $c->listar();
    unset($c);
//}
