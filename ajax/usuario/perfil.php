<?php

session_start();
if(empty($_SESSION['usuario']))
{
    header('Location: index.php');
}


include '../../config/conexion.php';

$id_usuario = $_SESSION['id_usuario'];

$nombre = mysqli_real_escape_string($con,(strip_tags($_POST["nombre"],ENT_QUOTES)));
$clave = mysqli_real_escape_string($con,(strip_tags($_POST["clave"],ENT_QUOTES)));
$nueva = mysqli_real_escape_string($con,(strip_tags($_POST["nueva"],ENT_QUOTES)));



$sql = $con->query("SELECT clave from usuario WHERE  codigo='".$id_usuario."'") or die(mysqlii_errno());
if($row = $sql->fetch_array())
{
    $confirma = $row['clave'];
}
if($clave!= ""){
if($confirma == crypt($clave,$confirma)){
    $con->query("UPDATE usuario SET nombre='".$nombre."',clave= '".crypt($nueva)."' WHERE codigo='".$id_usuario."'") or die(mysqlii_errno());
    echo json_encode(1);
}else{
    echo json_encode(0);
}
}else{
        $con->query("UPDATE usuario SET nombre='".$nombre."' WHERE codigo='".$id_usuario."'") or die(mysqlii_errno());
        $_SESSION['usuario'] = $nombre;
        echo json_encode(1);
}