<?php
	$sql = $con->query("SELECT *from conf_region");
	if ($row = $sql->fetch_array())
	{
		$moneda = $row['moneda'];
		$imp_esp = $row['imp_esp'];
		$impuesto = $row['impuesto'];
		$impuesto1 = $row['impuesto1'];
		$monto1 = $row['monto1'];
		$impuesto2 = $row['impuesto2'];

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
	$sql=$con->query("select *from producto, tmp_comp_prod where producto.codigo=tmp_comp_prod.id_producto");
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

	//si el impuesto especial esta seleccionado, hacer calculo de impuesto especial
	if ($porc_impuesto=="imp_esp")
	{
		$esp=true;
		if ($subtotal<$monto1)
		{
			$porc_impuesto = $impuesto1;
		}
		else
		{
			$porc_impuesto = $impuesto2;
		}
	}
	//sino, se usa el porcentaje de impuesto general
	else
	{
		$esp=false;
		$porc_impuesto = $impuesto;
	}

	//iva general
	$iva_general=($subtotal * $impuesto )/100;
	$iva_general=number_format($iva_general,2,'.','');
	//rebaja
	$iv = floatval(($impuesto - $porc_impuesto));
	$rebaja=($subtotal * $iv)/100;
	$rebaja=number_format($rebaja,2,'.','');
	//iva total
	$total_iva=($subtotal * $porc_impuesto )/100;
	$total_iva=number_format($total_iva,2,'.','');
	//total factura
	$total_factura=$subtotal+$total_iva;


	/*$total_iva=($subtotal * $porc_impuesto )/100;
	$total_iva=number_format($total_iva,2,'.','');
	$total_factura=$subtotal+$total_iva;
	*/

?>


<tr></tr>
<tr>
    <td class='text-right' colspan=4><strong>SUBTOTAL <?php echo $moneda ?>.</strong></td>
    <td class='text-right' ><?php echo number_format($subtotal,2);?></td>
    <!--input hidden para guardar el subtotal-->
    <input type="hidden" name="subtotal" id="subtotal" value="<?php echo number_format($subtotal,2);?>">

    <!--input hidden para guardar el impuesto-->
    <input type="hidden" name="impuesto" id="impuesto" value="<?php echo number_format($total_iva,2);?>">
    <input type="hidden" name="porc_impuesto" id="porc_impuesto" value="<?php echo $porc_impuesto ?>">

    <td></td>
</tr>

<tr>
    <td class="text-right" colspan=4><strong> IVA <?php echo $porc_impuesto; ?>%</strong></td>
    <td class="text-right"><?php echo number_format($total_iva,2);?></td>
</tr>

<tr>
    <td class="text-right" colspan=4><strong>TOTAL <?php echo $moneda ?>.</strong> </td>
    <td class="text-right"><?php echo number_format($total_factura,2);?></td>
    <!--input hidden para guardar el total-->
    <input type="hidden" name="total" id="total" value="<?php echo number_format($total_factura,2);?>">
    <td></td>
</tr>
</tbody>
</table>
</div>

<?php
	mysqli_close($con);
?>