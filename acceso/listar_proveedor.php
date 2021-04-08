<?php

header('Access-Control-Allow-Origin: *');
ini_set('session.cookie_domain', 'sistema.ailanthus.com.ve/' );
//session_start();
//if (empty($_SESSION['usuario'])) {}else{
    require_once 'AAProveedor.php';
    $p = new proveedor();
    $p->lista();
    unset($p);
//}