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
        if ($parametro == "null")
        {
            $sumador_total=0;
        }
        //$sumador_total=0;
        //booleano que se pone en true cuando existen productos con precios por debajo del costo
        $check = false;
        $sql=$con->query("select *from producto, tmp_cot_prod where producto.codigo=tmp_cot_prod.id_producto AND tmp_cot_prod.usuario_tmp = '$id_usuario'");
        while ($row=$sql->fetch_array())
        {
        $id_tmp=$row["id_tmp"];
        $codigo_producto=$row['codigo'];
        $precio_venta_r=$row['precio_tmp'];
        $cantidad=$row['cantidad_tmp'];
        $nombre_producto=$row['descripcion'];

        $precio_venta=$row['precio_tmp'];
        $precio_venta_f=number_format($precio_venta,2);
        $precio_venta_r=str_replace(",","",$precio_venta_f);



        //$precio_venta=$row['precio_tmp'];
        //$precio_venta_f=number_format($precio_venta,2);//Formateo variables
        //$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
        $precio_total=$precio_venta_r*$cantidad;
        $precio_total_f=number_format($precio_total,2);//Precio total formateado
        $precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
        $sumador_total+=$precio_total_r;//Sumador
?>
	<?php
		if ($productos[intval($cont)] == $codigo_producto) 
		{
			$check = true;
	?>	
			<tr bgcolor="#FE2E2E">
				<td class='text-center'><?php echo $codigo_producto; ?></td>
				<td class='text-center'><?php echo $cantidad;?></td>
				<td><?php echo $nombre_producto; ?></td>
				<td class='text-right'><?php echo $precio_venta_f;?></td>
				<td class='text-right'><?php echo $precio_total_f;?></td>
				<td class='text-center'><a href="#" data-toggle="modal" data-target="#editar" onclick="editarFactura('<?php echo $id_tmp ?>')" ><i class="glyphicon glyphicon-edit"></i></a></td>
				<td class='text-center'><a href="#" onclick="eliminar('<?php echo $id_tmp ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
                <td class='text-center'><a href="#" data-toggle="modal" data-target="#comentario" onclick="comentario('<?php echo $id_tmp ?>')"><i class="glyphicon glyphicon-comment"></i>
            </tr>
	<?php			
		}
		else
		{
	?>
			<tr>
				<td class='text-center'><?php echo $codigo_producto; ?></td>
				<td class='text-center'><?php echo $cantidad;?></td>
				<td><?php echo $nombre_producto; ?></td>
				<td class='text-right'><?php echo $precio_venta_f;?></td>
				<td class='text-right'><?php echo $precio_total_f;?></td>
				<td class='text-center'><a href="#" data-toggle="modal" data-target="#editar" onclick="editarFactura('<?php echo $id_tmp ?>')" ><i class="glyphicon glyphicon-edit"></i></a></td>
				<td class='text-center'><a href="#" onclick="eliminar('<?php echo $id_tmp ?>')"><i class="glyphicon glyphicon-trash"></i></a></td>
				<td class='text-center'><a href="#" data-toggle="modal" data-target="#comentario" onclick="comentario('<?php echo $id_tmp ?>')"><i class="glyphicon glyphicon-comment"></i>	
				</a></td>				
			</tr>
	<?php
		}
		$cont=intval($cont)+1;	
		
	}

	if ($parametro=="null")
	{
		$subtotal=number_format($sumador_total,2,'.','');
		$total_iva=($subtotal * $porc_impuesto )/100;
		$total_factura=$subtotal+$total_iva;
		$total_iva=number_format($total_iva,2,'.','');		
	}
	else
	{
		$subtotal=number_format($subtotal,2,'.','');
		$total_iva=$iva;
		$total_factura=$total;
		$total_iva=number_format($total_iva,2,'.','');
	}

	?>
<tr></tr>
<tr>
	<td class='text-right' colspan=4><strong>SUBTOTAL <?php echo $moneda ?>.</strong></td>
	<td class='text-right' ><?php echo number_format($subtotal,2);?></td>
	<!--input hidden para guardar el subtotal-->
	<input type="hidden" name="subtotal" id="subtotal" value="<?php echo number_format($subtotal,2);?>">
	<td></td>
</tr>
<tr>
	<td class='text-right' colspan=4><strong> IVA (<?php echo $porc_impuesto;?>)% <?php echo $moneda ?>.</strong></td>
	<td class='text-right'><?php echo number_format($total_iva,2);?></td>
	<!--input hidden para guardar el impuesto-->
	<input type="hidden" name="impuesto" id="impuesto" value="<?php echo number_format($total_iva,2);?>">
	<td></td>
</tr>
<tr>
	<td class='text-right' colspan=4><strong>TOTAL <?php echo $moneda ?>.</strong> </td>
	<td class='text-right'><?php echo number_format($total_factura,2);?></td>
	<!--input hidden para guardar el total-->
	<input type="hidden" name="total" id="total" value="<?php echo number_format($total_factura,2);?>">
	<td></td>
</tr>
</tbody>
</table>
</div>


<?php
	if ($check==true) 
	{
		echo '<div style="width: 100%;" class="alert alert-danger">	
		<strong>¡El precio no puede ser menor al costo!</strong> Por favor modifique el precio de los productos marcados.
		</div>		
		<input type="hidden" id="check" value="true"></input>';
	}
	else
		echo '<input type="hidden" id="check" value="false"></input>';

	mysqli_close($con); 
?>