<?php
header('Access-Control-Allow-Origin: *');
ini_set('session.cookie_domain', 'sistema.ailanthus.com.ve/' );
//session_start();
//if (empty($_SESSION['usuario'])) {}else{

require "../config/conexion.php";
$cl = array();
$sql = $con->query('SELECT * FROM usuario');
while ($row = $sql->fetch_array()) {
    $cl[] = array(
        'codigo' => $row['codigo'],
        'nombre' => $row['nombre'],
        'correo' => $row['correo'],
        'clave' => $row['clave']
    );
}
echo json_encode($cl);
//}