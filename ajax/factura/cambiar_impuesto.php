<?php
	
$porc_impuesto=floatval($_POST['porc_impuesto']);

include '../../config/conexion.php';
	
//comprobar si el precio de cada producto es menor a su costo
$sql2=$con->query("select *from tmp_fact_prod");
while ($row2 = $sql2->fetch_array()) 
{
	//se busca el costo del producto seleccionado
	$cod = $row2['id_producto'];
	$precio_tmp = $row2['precio_tmp'];	
	$sql3 = $con->query("SELECT costo from producto WHERE codigo = '$cod' ");

	if ($row3 = mysqli_fetch_array($sql3)) 
	{
		//se compara el precio de cada producto en la cotizacion, con su respectivo costo
		$costo = (float) $row3['costo'];
		$precio = (float) $precio_tmp;
		//si el costo es mayor que el precio del producto
		if ($precio<$costo) 
		{
			$productos[] = $cod;
		}
		else
		{
			$productos[] = 'none';
		}
	}		
}


?>

<!--Se incluye script para calcular el impuesto y el total de la factura-->
<?php include 'calcular_factura.php' ?>