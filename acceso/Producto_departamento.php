<?php

header('Access-Control-Allow-Origin: *');
ini_set('session.cookie_domain', 'sistema.test/' );
//session_start();
//if (empty($_SESSION['usuario'])) {}else{
    require_once 'AAProducto.php';
    $p = new producto();
    $p->departamentos();
    unset($p);
//}