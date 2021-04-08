<?php
session_start();
 include '../../config/seccion.php';
  if(empty($_SESSION['usuario']))
  {
    header('Location: index.php');
  }  




		/* Conectar a la base de datos*/
		include '../../../config/conexion.php';

		$codigo =mysqli_real_escape_string($con,(strip_tags($_POST["codigo"],ENT_QUOTES)));
		$descripcion =mysqli_real_escape_string($con,(strip_tags($_POST["edit_descripcion"],ENT_QUOTES)));

		$sql = $con->query("SELECT *from moneda WHERE id = '$codigo'");

		if ($row=$sql->fetch_array()) 
		{

			$sql = "UPDATE moneda SET descripcion = UPPER('$descripcion') WHERE id = '$codigo' ";
			$query = $con->query($sql);
				if ($query)
				{
					$messages[] = "Modificado satisfactoriamente.";
				}			
		}

?>