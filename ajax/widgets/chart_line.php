<?php  
/* Conectar a la base de datos*/
include '../../config/conexion.php';

$mes_actual = date("n");
$ano_actual = date("Y");

$sql_mayor = $con->query("	SELECT SUM( subtotal ) AS ventas, MONTH( fecha ) AS mes
							FROM factura
							WHERE YEAR( fecha ) =$ano_actual
							AND estatus = 2
							GROUP BY mes
							ORDER BY ventas DESC 
							LIMIT 0 , 1");

if ($row = mysqli_fetch_array($sql_mayor)) 
{
 	$mes = $row['mes'];
}
else
{
	$mes = 0;
}

$data   = array();
$mayor  = array();
$actual = array();

$ventas_mayor = $con->query("	SELECT subtotal
								FROM factura
								WHERE MONTH(fecha) = $mes
								AND estatus = 2
								AND YEAR( fecha ) =$ano_actual");

while ($row = mysqli_fetch_array($ventas_mayor))
{
	$monto = $row['subtotal'];
	array_push($mayor, $monto); 

}



/////////////////////////////////////////////////////////////////
$ventas_actual = $con->query("	SELECT subtotal
								FROM factura
								WHERE MONTH(fecha) = $mes_actual
								AND estatus = 2
								AND YEAR( fecha ) =$ano_actual");

while ($row2 = mysqli_fetch_array($ventas_actual))
{
	$monto2 = $row2['subtotal'];
	array_push($actual, $monto2); 

}


$data[0]  = $mayor;
$data[1] = $actual;
echo json_encode($data); 

?>