<?php


	$user = "desarrollador";
	$pass = "2amu3azap";
	$server = "192.168.1.7";
	$db = "j400311730_sistema";
	$con = mysqli_connect($server, $user, $pass) or die ("Error al conectar a la base de datos: ".mysqli_error());
	mysqli_select_db($db, $con);
	mysqli_set_charset('utf8');
	return $con;

	
?>