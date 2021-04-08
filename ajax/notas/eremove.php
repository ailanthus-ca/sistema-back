<?php

session_start();
$user = $_SESSION['id_usuario'];
include '../../config/conexion.php';
$producto = (isset($_POST['producto']) && $_POST['producto'] != NULL) ? $_POST['producto'] : 'null';
$con->query("DELETE FROM `tempnotas` WHERE `productor`='$producto' AND `usuario`=$user");
include './eproducto.php';

