<?php
session_start();
include '../../config/conexion.php';

$query = $con->query("SELECT * FROM dolares WHERE  WEEK(NOW(),0)=WEEK(fecha,0)") or die(array("st" => 0, "msn" => $con->error));
$valor = array();
while ($row = $query->fetch_array()) {
    $valor[] = array(
        "valor" => $row["valor"],
        "fecha" => $row["fecha"]
    );
}
echo json_encode(array("st" => 1, "data" => $valor));
