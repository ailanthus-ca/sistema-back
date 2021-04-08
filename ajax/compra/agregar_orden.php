<?php
	
if (isset($_POST['id'])){$id=$_POST['id'];}
$porc_impuesto=$_POST['porc_impuesto'];	
	

	include '../../config/conexion.php';

	//reinicia la tabla temporal
	$con->query("truncate table tmp_comp_prod");
	

	$sql = $con->query("SELECT *from conf_region");
	if ($row = $sql->fetch_array())
	{
		$moneda = $row['moneda'];
		$impuesto = $row['impuesto'];
	}

if (!empty($id))
{

	$sql = $con->query("select *from detalleordencompra where cod_orden = '$id'");
	while ($row=$sql->fetch_array()) 
	{
		$cod_producto = $row['cod_producto'];
		$cantidad = $row['cantidad'];
		$monto = $row['monto'];
		$precio_venta_f=number_format(floatval($row['monto']/$cantidad),2);
		$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas

	$sql3=$con->query("select *from tmp_comp_prod where id_producto = '$cod_producto'");
	if ($row3=mysqli_fetch_array($sql3))
	{
		$con->query("update tmp_comp_prod set cantidad_tmp = '$cantidad' WHERE id_producto = '$cod_producto'");
	}
	else
	{

		$insert_tmp=$con->query("INSERT into tmp_comp_prod (id_producto,cantidad_tmp,precio_tmp) VALUES ('$cod_producto','$cantidad','$precio_venta_r')");

	}		

	}



}
if (isset($_GET['id']))//codigo elimina un elemento del array
{
	$id_tmp=intval($_GET['id']);	
	$delete=$con->query("DELETE from tmp_comp_prod WHERE id_tmp='".$id_tmp."'");
}

?>

<?php include 'calcular_compra.php'; ?>