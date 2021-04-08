<?php  
/* Conectar a la base de datos*/
include '../../config/conexion.php';

$mes_actual = date("n");
$ano_actual = date("Y");

$sql_util = $con->query("	SELECT SUM(subtotal) as ventas, SUM(costo) as costos 
							FROM factura
							WHERE MONTH(fecha) = $mes_actual
							AND estatus = 2
							AND YEAR(fecha) = $ano_actual");


if ($row = mysqli_fetch_array($sql_util)) 
{
 	$ventas = $row['ventas'];
 	$costos = $row['costos'];
 	$prom = round((($ventas-$costos)*100)/$costos);
}
else
{
	$prom = 0;
}



$data = array (0 => $prom);

echo json_encode($data); 

?>