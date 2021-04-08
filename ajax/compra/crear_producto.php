<?php
	
$id=mysqli_real_escape_string($con,(strip_tags($_POST["codigo_producto"],ENT_QUOTES)));
$cantidad = 1;
$porc_impuesto = (isset($_GET['porc_impuesto'])&& $_GET['porc_impuesto'] !=NULL)?$_GET['porc_impuesto']:'';
if (isset($_POST['costo_producto'])){$costo_compra=$_POST['costo_producto'];}

include '../../config/conexion.php';


$sql = $con->query("SELECT *from conf_region");
if ($row = $sql->fetch_array())
{
	$moneda = $row['moneda'];
	if ($porc_impuesto == '')
		{
			$porc_impuesto = $row['impuesto'];	
		}
}


if (!empty($id) and !empty($cantidad) and !empty($costo_compra))
{



	$sql=$con->query("select *from tmp_comp_prod where id_producto = '$id'");
	if ($row=$sql->fetch_array())
	{
		$con->query("update tmp_comp_prod set cantidad_tmp = '$cantidad', precio_tmp = $costo_compra WHERE id_producto = '$id'");
	}
	else
	{
		$insert_tmp=$con->query("INSERT into tmp_comp_prod (id_producto,cantidad_tmp,precio_tmp) VALUES ('$id','$cantidad','$costo_compra')");
	}


}

?>

<?php include 'calcular_compra.php'; ?>