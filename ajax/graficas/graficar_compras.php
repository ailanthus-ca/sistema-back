<?php

/* Conectar a la base de datos*/
include '../../config/conexion.php';

$año = $_POST['año'];

	$enero = mysqli_fetch_array($con->query("SELECT SUM(total) AS r FROM compra WHERE MONTH(fecha)=1 AND YEAR(fecha)='$año'"));
	$febrero = mysqli_fetch_array($con->query("SELECT SUM(total) AS r FROM compra WHERE MONTH(fecha)=2 AND YEAR(fecha)='$año'"));
	$marzo = mysqli_fetch_array($con->query("SELECT SUM(total) AS r FROM compra WHERE MONTH(fecha)=3 AND YEAR(fecha)='$año'"));
	$abril = mysqli_fetch_array($con->query("SELECT SUM(total) AS r FROM compra WHERE MONTH(fecha)=4 AND YEAR(fecha)='$año'"));
	$mayo = mysqli_fetch_array($con->query("SELECT SUM(total) AS r FROM compra WHERE MONTH(fecha)=5 AND YEAR(fecha)='$año'"));
	$junio = mysqli_fetch_array($con->query("SELECT SUM(total) AS r FROM compra WHERE MONTH(fecha)=6 AND YEAR(fecha)='$año'"));
	$julio = mysqli_fetch_array($con->query("SELECT SUM(total) AS r FROM compra WHERE MONTH(fecha)=7 AND YEAR(fecha)='$año'"));
	$agosto = mysqli_fetch_array($con->query("SELECT SUM(total) AS r FROM compra WHERE MONTH(fecha)=8 AND YEAR(fecha)='$año'"));
	$septiembre = mysqli_fetch_array($con->query("SELECT SUM(total) AS r FROM compra WHERE MONTH(fecha)=9 AND YEAR(fecha)='$año'"));
	$octubre = mysqli_fetch_array($con->query("SELECT SUM(total) AS r FROM compra WHERE MONTH(fecha)=10 AND YEAR(fecha)='$año'"));
	$noviembre = mysqli_fetch_array($con->query("SELECT SUM(total) AS r FROM compra WHERE MONTH(fecha)=11 AND YEAR(fecha)='$año'"));
	$diciembre = mysqli_fetch_array($con->query("SELECT SUM(total) AS r FROM compra WHERE MONTH(fecha)=12 AND YEAR(fecha)='$año'"));

	$data = array(0 => round($enero['r'],1),
				  1 => round($febrero['r'],1),
				  2 => round($marzo['r'],1),
				  3 => round($abril['r'],1),
				  4 => round($mayo['r'],1),
				  5 => round($junio['r'],1),
				  6 => round($julio['r'],1),
				  7 => round($agosto['r'],1),
				  8 => round($septiembre['r'],1),
				  9 => round($octubre['r'],1),
				  10 => round($noviembre['r'],1),
				  11 => round($diciembre['r'],1)
				  );			 
	echo json_encode($data);
?>
