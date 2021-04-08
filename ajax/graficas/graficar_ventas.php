<?php

/* Conectar a la base de datos*/
include '../../config/conexion.php';

$año = $_POST['año'];

	$enero = mysqli_fetch_array($con->query("SELECT SUM(subtotal) AS r FROM factura WHERE MONTH(fecha)=1 AND YEAR(fecha)='$año' AND estatus = 2"));
	$febrero = mysqli_fetch_array($con->query("SELECT SUM(subtotal) AS r FROM factura WHERE MONTH(fecha)=2 AND YEAR(fecha)='$año' AND estatus = 2"));
	$marzo = mysqli_fetch_array($con->query("SELECT SUM(subtotal) AS r FROM factura WHERE MONTH(fecha)=3 AND YEAR(fecha)='$año' AND estatus = 2"));
	$abril = mysqli_fetch_array($con->query("SELECT SUM(subtotal) AS r FROM factura WHERE MONTH(fecha)=4 AND YEAR(fecha)='$año' AND estatus = 2"));
	$mayo = mysqli_fetch_array($con->query("SELECT SUM(subtotal) AS r FROM factura WHERE MONTH(fecha)=5 AND YEAR(fecha)='$año' AND estatus = 2"));
	$junio = mysqli_fetch_array($con->query("SELECT SUM(subtotal) AS r FROM factura WHERE MONTH(fecha)=6 AND YEAR(fecha)='$año' AND estatus = 2"));
	$julio = mysqli_fetch_array($con->query("SELECT SUM(subtotal) AS r FROM factura WHERE MONTH(fecha)=7 AND YEAR(fecha)='$año' AND estatus = 2"));
	$agosto = mysqli_fetch_array($con->query("SELECT SUM(subtotal) AS r FROM factura WHERE MONTH(fecha)=8 AND YEAR(fecha)='$año' AND estatus = 2"));
	$septiembre = mysqli_fetch_array($con->query("SELECT SUM(subtotal) AS r FROM factura WHERE MONTH(fecha)=9 AND YEAR(fecha)='$año' AND estatus = 2"));
	$octubre = mysqli_fetch_array($con->query("SELECT SUM(subtotal) AS r FROM factura WHERE MONTH(fecha)=10 AND YEAR(fecha)='$año' AND estatus = 2"));
	$noviembre = mysqli_fetch_array($con->query("SELECT SUM(subtotal) AS r FROM factura WHERE MONTH(fecha)=11 AND YEAR(fecha)='$año' AND estatus = 2"));
	$diciembre = mysqli_fetch_array($con->query("SELECT SUM(subtotal) AS r FROM factura WHERE MONTH(fecha)=12 AND YEAR(fecha)='$año' AND estatus = 2"));
	
	$data = array(0 => round($enero['r'],2),
				  1 => round($febrero['r'],2),
				  2 => round($marzo['r'],2),
				  3 => round($abril['r'],2),
				  4 => round($mayo['r'],2),
				  5 => round($junio['r'],2),
				  6 => round($julio['r'],2),
				  7 => round($agosto['r'],2),
				  8 => round($septiembre['r'],2),
				  9 => round($octubre['r'],2),
				  10 => round($noviembre['r'],2),
				  11 => round($diciembre['r'],2)
				  );	

	echo json_encode($data);

 ?>
