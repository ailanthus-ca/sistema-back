<?php
	
if (isset($_POST['id'])){$id=$_POST['id'];}
if (isset($_POST['cantidad'])){$cantidad=$_POST['cantidad'];}
if (isset($_POST['costo_compra'])){$costo_compra=$_POST['costo_compra'];}
$porc_impuesto=$_POST['porc_impuesto'];	

include '../../config/conexion.php';
	

$sql = $con->query("SELECT *from conf_region");
if ($row = $sql->fetch_array())
{
	$moneda = $row['moneda'];
}


if (!empty($id) and !empty($cantidad) and !empty($costo_compra))
{



	$sql=$con->query("select *from tmp_comp_prod where id_producto = '$id'") or die($con->error);
	if ($row=$sql->fetch_array())
	{
		$con->query("update tmp_comp_prod set cantidad_tmp = '$cantidad', precio_tmp = $costo_compra WHERE id_producto = '$id'")or die($con->error);
	}
	else
	{
		$insert_tmp=$con->query("INSERT into tmp_comp_prod (id_producto,cantidad_tmp,precio_tmp) VALUES ('$id','$cantidad','$costo_compra')")or die($con->error);
	}


}
if (isset($_POST['id']))//codigo elimina un elemento del array
{
$id_tmp=intval($_POST['id']);	
$delete=$con->query("DELETE from tmp_comp_prod WHERE id_tmp='".$id_tmp."'");

}

?>

<?php include 'calcular_compra.php'; ?>