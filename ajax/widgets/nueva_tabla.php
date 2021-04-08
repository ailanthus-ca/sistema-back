<?php
include '../../config/conexion.php';

/*
  include '../../config/conexion.php';
  $query = $con->query("SELECT SUM( subtotal ) AS ventas, MONTH( fecha ) AS mes, YEAR( fecha ) AS ano FROM factura WHERE estatus = 2 GROUP BY mes ORDER BY ano asc");
  while ($row = mysqli_fetch_array($query)) {
  echo "INSERT INTO `mejor_mes`(`id`, `ventas`, `mes`, `año`) VALUES (null,".$row['ventas']/100000 .",".$row['mes'].",".$row['ano'].")";
  $con->query("INSERT INTO `mejor_mes`(`id`, `ventas`, `mes`, `año`) VALUES (null,".$row['ventas']/100000 .",".$row['mes'].",".$row['ano'].")");
  }
  echo 'listo';
  /*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$mes_actual = date("n");
$ano_actual = date("Y");

$mes_anterior = $mes_actual - 1;
if ($mes_anterior != 0) {
    echo 'sql';
    $sql = "SELECT * FROM mejor_mes WHERE mes=$mes_anterior AND año=$ano_actual";
} else {
    echo 'sql';
    $año_anterior = $ano_actual - 1;
    $mes_anterior = 12;
    $sql = "SELECT * FROM mejor_mes WHERE mes=12 AND año=$año_anterior";
}
$query = $con->query($sql) or die('Error SQL ' . $sql . ' Mensaje:' . $con->error);
if ($row = mysqli_fetch_array($query)) {
    echo 'existe';
    
} else {
    echo 'crealo';
    $sql = "SELECT SUM(subtotal) AS ventas FROM factura WHERE estatus = 2 AND MONTH(fecha)=$mes_anterior AND YEAR(fecha)='$año_anterior'";
    $query = $con->query($sql) or die('Error SQL ' . $sql . ' Mensaje:' . $con->error);
    if ($row = mysqli_fetch_array($query)) {
        $con->query("INSERT INTO `mejor_mes`(`id`, `ventas`, `mes`, `año`) VALUES (null," . $row['ventas'] . ",$mes_anterior,$año_anterior)");
    }
}
