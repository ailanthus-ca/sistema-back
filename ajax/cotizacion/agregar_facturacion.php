<?php
	
if (isset($_POST['id'])){$id=$_POST['id'];}
if (isset($_POST['cantidad'])){$cantidad=$_POST['cantidad'];}
if (isset($_POST['precio_venta'])){$precio_venta=$_POST['precio_venta'];}
$parametro = (isset($_POST['parametro'])&& $_POST['parametro'] !=NULL)?$_POST['parametro']:'null';

session_start();
$id_usuario = $_SESSION['id_usuario'];
	
include '../../config/conexion.php';



$sql = $con->query("SELECT *from conf_region");
if ($row = $sql->fetch_array())
{
	$moneda = $row['moneda'];
	$porc_impuesto = $row['impuesto'];
}

if (!empty($id) and !empty($cantidad) and !empty($precio_venta))
{



	$sql=$con->query("select *from tmp_cot_prod where id_producto = '$id' AND usuario_tmp = '$id_usuario'")or die($con->error);
	if ($row=$sql->fetch_array())
	{
		$con->query("update tmp_cot_prod set cantidad_tmp = '$cantidad', precio_tmp = $precio_venta 
                            WHERE id_producto = '$id' AND usuario_tmp = '$id_usuario'")or die($con->error);
	}
	else
	{
		$insert_tmp=$con->query("INSERT into tmp_cot_prod (id_producto,cantidad_tmp,precio_tmp, usuario_tmp) 
                                        VALUES ('$id','$cantidad','$precio_venta', '$id_usuario')")or die($con->error);
	}




	$sql2=$con->query("select *from tmp_cot_prod WHERE usuario_tmp = '$id_usuario'")or die($con->error);
	while ($row2 = $sql2->fetch_array()) 
	{
		//se busca el costo del producto seleccionado
		$cod = $row2['id_producto'];
		$precio_tmp = $row2['precio_tmp'];	
		$sql3 = $con->query("SELECT costo from producto WHERE codigo = '$cod' ")or die($con->error);

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
				$productos[] = '';
			}
		}		
	}


}
if (isset($_POST['id']))//codigo elimina un elemento del array
{
$id_tmp=intval($_POST['id']);	
$delete=$con->query("DELETE from tmp_cot_prod WHERE id_tmp='".$id_tmp."'")or die($con->error);

	$sql2=$con->query("select *from tmp_cot_prod WHERE usuario_tmp = '$id_usuario'")or die($con->error);
	while ($row2 = $sql2->fetch_array()) 
	{
		//se busca el costo del producto seleccionado
		$cod = $row2['id_producto'];
		$precio_tmp = $row2['precio_tmp'];	
		$sql3 = $con->query("SELECT costo from producto WHERE codigo = '$cod' ")or die($con->error);

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
				$productos[] = '';
			}
		}		
	}
}

?>
<!--Se incluye script para calcular el total de la cotizacion-->
<?php include "calcular_cotizacion.php" ?>