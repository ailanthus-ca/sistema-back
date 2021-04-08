<?php
	
$porc_impuesto=$_POST['porc_impuesto'];	

include '../../config/conexion.php';
	

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
if (isset($_GET['id']))//codigo elimina un elemento del array
{
$id_tmp=intval($_GET['id']);	
$delete=$con->query("DELETE from tmp_comp_prod WHERE id_tmp='".$id_tmp."'");

}

?>

<?php include 'calcular_compra.php'; ?>