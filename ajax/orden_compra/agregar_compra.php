<?php
	
if (isset($_POST['id'])){$id=$_POST['id'];}
if (isset($_POST['cantidad'])){$cantidad=$_POST['cantidad'];}
if (isset($_POST['costo_compra'])){$costo_compra=$_POST['costo_compra'];}
	

	include '../../config/conexion.php';
   include '../../config/seccion.php';
    $id_usuario = $_SESSION['id_usuario'];

	$sql = $con->query("SELECT *from conf_region");
	if ($row = $sql->fetch_array())
	{
		$moneda = $row['moneda'];
		$impuesto = $row['impuesto'];
	}


if (!empty($id) and !empty($cantidad) and !empty($costo_compra))
{


	$sql=$con->query("select *from tmp_ord_prod where id_producto = '$id' AND usuario_tmp = '$id_usuario'");
	if ($row=$sql->fetch_array())
	{
		$con->query("update tmp_ord_prod set cantidad_tmp = '$cantidad', precio_tmp = $costo_compra 
                            WHERE id_producto = '$id' AND usuario_tmp = '$id_usuario'")  or die("UPDATE" . $row['id_producto'] . ": " . $con->error);
	}
	else
	{
		$insert_tmp=$con->query("INSERT into tmp_ord_prod (id_producto,cantidad_tmp,precio_tmp,usuario_tmp) VALUES ('$id','$cantidad','$costo_compra','$id_usuario')") or die("INSERT" . $row['id_producto'] . ": " . $con->error);
	}


}
if (isset($_GET['id']))//codigo elimina un elemento del array
{
$id_tmp=intval($_GET['id']);	
$delete=$con->query("DELETE from tmp_ord_prod WHERE id_tmp='".$id_tmp."'");

}

?>
<div class="table-responsive">
<table class="table">
<thead>
<tr>
	<th class='text-center'>CODIGO</th>
	<th class='text-center'>CANT.</th>
	<th>DESCRIPCION</th>
	<th class='text-right'>PRECIO UNIT.</th>
	<th class='text-right'>PRECIO TOTAL</th>
	<th></th>
</tr>
</thead>
<tbody>
<?php
	$cont=0;
	$sumador_total=0;
	//booleano que se pone en true cuando existen productos con precios por debajo del costo
	$sql=$con->query("select *from producto, tmp_ord_prod where producto.codigo=tmp_ord_prod.id_producto  AND usuario_tmp = '$id_usuario'");
	while ($row=$sql->fetch_array())
	{
	$id_tmp=$row["id_tmp"];
	$codigo_producto=$row['codigo'];
	$cantidad=$row['cantidad_tmp'];
	$nombre_producto=$row['descripcion'];
	
	
	$precio_venta=$row['precio_tmp'];
	$precio_venta_f=number_format($precio_venta,2);//Formateo variables
	$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
	$precio_total=$precio_venta_r*$cantidad;
	$precio_total_f=number_format($precio_total,2);//Precio total formateado
	$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
	$sumador_total+=$precio_total_r;//Sumador
	
?>

			<tr>
				<td class='text-center'><?php echo $codigo_producto; ?></td>
				<td class='text-center'><?php echo $cantidad;?></td>
				<td><?php echo $nombre_producto; ?></td>
				<td class='text-right'><?php echo $precio_venta_f;?></td>
				<td class='text-right'><?php echo $precio_total_f;?></td>
				<td class='text-center'><a href="#" data-toggle="modal" data-target="#editar" onclick="editarCompra('<?php echo $id_tmp ?>')" ><i class="glyphicon glyphicon-edit"></i></a></td>
				<td class='text-center'><a href="#" onclick="eliminar('<?php echo $id_tmp ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
			</tr>
<?php
	}
	$subtotal=number_format($sumador_total,2,'.','');
	$total_iva=($subtotal * $impuesto )/100;
	$total_iva=number_format($total_iva,2,'.','');
	$total_factura=$subtotal+$total_iva;

?>
<tr></tr>
<tr>
	<td class='text-right' colspan=4><strong>SUBTOTAL <?php echo $moneda ?>.</strong></td>
	<td class='text-right'><?php echo number_format($subtotal,2);?></td>
	<input type="hidden" name="subtotal" id="subtotal" value="<?php echo number_format($subtotal,2);?>">
	<td></td>
</tr>
<tr>
	<td class='text-right' colspan=4><strong> IVA (<?php echo $impuesto;?>)% <?php echo $moneda ?>.</strong></td>
	<td class='text-right'><?php echo number_format($total_iva,2);?></td>
	<input type="hidden" name="impuesto" id="impuesto" value="<?php echo number_format($total_iva,2);?>">
	<td></td>
</tr>
<tr>
	<td class='text-right' colspan=4><strong>TOTAL <?php echo $moneda ?>.</strong> </td>
	<td class='text-right'><?php echo number_format($total_factura,2);?></td>
	<input type="hidden" name="total" id="total" value="<?php echo number_format($total_factura,2);?>">
	<td></td>
</tr>
</tbody>
</table>
</div>

<?php
	mysqli_close($con); 
?>