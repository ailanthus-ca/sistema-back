<?php

/* Conectar a la base de datos */
include '../../config/conexion.php';
session_start();
$level = $_SESSION['nivel'];
$id = $_SESSION['id_usuario'];

$mes_actual = date("n");
$ano_actual = date("Y");




if ($level == 0) {


    if ($mes == 1) {
        $mes = 12;
        $ano = $ano_actual - 1;
    } else {
        $mes = $mes_actual - 1;
        $ano = $ano_actual;
    }
    $sql = "SELECT ventas FROM mejor_mes WHERE mes= $mes AND año= $ano";
    $query = $con->query($sql) or die('Error SQL ' . $sql . '1 Mensaje:' . $con->error);
    if ($row = mysqli_fetch_array($query)) {
        $comprovante = 'existe';
    } else {
        $comprovante = 'crealo';
        $sql = "SELECT SUM(subtotal) AS ventas FROM factura WHERE estatus = 2 AND MONTH(fecha)=$mes AND YEAR(fecha)='$ano'";
        $query = $con->query($sql) or die('Error SQL ' . $sql . '2 Mensaje:' . $con->error);
        if ($row = mysqli_fetch_array($query)) {
            $con->query("INSERT INTO `mejor_mes`(`id`, `ventas`, `mes`, `año`) VALUES (null," . $row['ventas'] . ",$mes,$ano)") or die('Error SQL ' . $sql . '3 Mensaje:' . $con->error);
        }
    }

    $sql_mayor = $con->query("SELECT max( ventas ) AS ventas, mes,año FROM mejor_mes");
    if ($row = mysqli_fetch_array($sql_mayor)) {
        $mejor = array(
            'ventas' => $row['ventas'],
            'mes' => $row['mes'],
            'ano' => $row['ano']);
    } else {
        $mejor = array(
            'ventas' => 0,
            'mes' => 0,
            'ano' => 0);
    }
    $ventas_actual = $con->query("SELECT SUM(subtotal) as subtotal FROM factura WHERE MONTH(fecha) = $mes_actual AND estatus = 2 AND YEAR( fecha ) =$ano_actual");
    while ($row2 = mysqli_fetch_array($ventas_actual)) {
        $actual = $row2['subtotal'];
    }


    $data[0] = array(doubleval($mejor['ventas']));
    $data[1] = array(doubleval($actual));
    $data[2] = "Mes actual";
    $data[3] = "Mejor mes";
    $data[4] = "Comparación de ventas del mes actual con el mejor mes";
    $data[5] = $comprovante;
} else {
    $sql_cotizacion = $con->query("	SELECT COUNT( codigo ) AS total
							FROM cotizacion
							WHERE usuario = $id
							AND YEAR( fecha ) = $ano_actual  
							AND  MONTH( fecha ) = $mes_actual
							LIMIT 0 , 1");
    if ($row = mysqli_fetch_array($sql_cotizacion)) {
        $total = $row['total'];
    } else {
        $total = 0;
    }
    $sql_procesadas = $con->query("	SELECT COUNT( codigo ) AS total
							FROM cotizacion
							WHERE usuario = $id
							AND YEAR( fecha ) = $ano_actual  
							AND  MONTH( fecha ) = $mes_actual
							AND estatus = 2
							LIMIT 0 , 1");
    if ($row = mysqli_fetch_array($sql_procesadas)) {
        $procesadas = $row['total'];
    } else {
        $procesadas = 0;
    }

    $data[0] = $total;
    $data[1] = $procesadas;
    $data[2] = "Procesadas";
    $data[3] = "Total";
    $data[4] = "Cotizaciones del mes actual";
}
echo json_encode($data);
?>