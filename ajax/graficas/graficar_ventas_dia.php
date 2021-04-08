<?php

/* Conectar a la base de datos*/
include '../../config/conexion.php';

$dia = Date("d");
$mes = Date("m");
$año = $_POST['año'];

$query = "SELECT DAY( fecha ) AS dia, SUM( subtotal ) AS total
			FROM factura
			WHERE MONTH( fecha ) ='$mes'
			AND YEAR( fecha ) ='$año'
			AND estatus = 2
			GROUP BY dia";

$data = array();

for ($i=1; $i <= $dia; $i++) 
{

	$query = "SELECT SUM( subtotal ) AS total
			FROM factura
			WHERE MONTH( fecha ) ='$mes'
			AND DAY(fecha) = '$i'
			AND estatus = 2
			AND YEAR( fecha ) ='$año'";
	
	$sql = $con->query($query);

	if($row=$sql->fetch_array())
	{
		$data[$i-1] = round($row['total'],2);
	}

			
}

	echo json_encode($data);

 ?>
