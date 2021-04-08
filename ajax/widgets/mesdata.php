<?php
include '../../config/conexion.php';
$mes = $_GET['mes'];
$ano = $_GET['ano'];
$sql = "SELECT ventas FROM mejor_mes WHERE mes= $mes AND año= $ano";
$query = $con->query($sql) or die('Error SQL ' . $sql . '1 Mensaje:' . $con->error);
if ($row = mysqli_fetch_array($query)) {
    echo 'existe';
} else {
    echo 'crealo';
    $sql = "SELECT SUM(subtotal) AS ventas FROM factura WHERE estatus = 2 AND MONTH(fecha)=$mes AND YEAR(fecha)='$ano'";
    $query = $con->query($sql) or die('Error SQL ' . $sql . '2 Mensaje:' . $con->error);
    if ($row = mysqli_fetch_array($query)) {
        $con->query("INSERT INTO `mejor_mes`(`id`, `ventas`, `mes`, `año`) VALUES (null," . $row['ventas'] . ",$mes,$ano)") or die('Error SQL ' . $sql . '3 Mensaje:' . $con->error);
    }
}
?>