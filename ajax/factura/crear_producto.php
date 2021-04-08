<?php

$departamento=mysqli_real_escape_string($con,(strip_tags($_POST["departamento"],ENT_QUOTES)));
$cantidad = 1;
$precio_venta=floatval($_POST['precio2']);
//$porc_impuesto = (isset($_GET['porc_impuesto'])&& $_GET['porc_impuesto'] !=NULL)?$_GET['porc_impuesto']:'';
$porc_impuesto=floatval($_GET['porc_impuesto']);
$parametro = (isset($_GET['parametro'])&& $_GET['parametro'] !=NULL)?$_GET['parametro']:'';

include '../../config/conexion.php';

//Buscar codigo del producto recien guardado para poder insertarlo en la tabla temporal

$query_id = $con->query("SELECT codigo 
                                from producto 
                                WHERE departamento = '$departamento'
                                ORDER BY codigo DESC limit 1");
	
if (!empty($id) and !empty($cantidad) and $precio_venta!="")
{

	$sql2=$con->query("select *from tmp_fact_prod where id_producto = '$id'");
	if ($row2=$sql2->fetch_array())
	{
		$con->query("update tmp_fact_prod set cantidad_tmp = '$cantidad', precio_tmp = $precio_venta WHERE id_producto = '$id'");
	}
	else
	{
		$insert_tmp=$con->query("INSERT into tmp_fact_prod (id_producto,cantidad_tmp,precio_tmp) VALUES ('$id','$cantidad','$precio_venta')");
	}

	$sql3=$con->query("select *from tmp_fact_prod");
	while ($row3 = mysqli_fetch_array($sql3)) 
	{
		//se busca el costo del producto seleccionado
		$cod = $row3['id_producto'];
		$precio_tmp = $row3['precio_tmp'];	
		$sql4 = $con->query("SELECT costo from producto WHERE codigo = '$cod' ");

		if ($row4 = mysqli_fetch_array($sql4)) 
		{
			//se compara el precio de cada producto, con su respectivo costo
			$costo = (float) $row4['costo'];
			$precio = (float) $precio_tmp;
			//si el costo es mayor que el precio del producto
			if ($precio<$costo) 
			{
				$productos[] = $cod;
			}
			else
			{
				$productos[] = '';
			}
		}		
	}


}

?>

<!--Se incluye script para calcular el impuesto y el total de la factura-->
<?php include 'calcular_factura.php' ?>