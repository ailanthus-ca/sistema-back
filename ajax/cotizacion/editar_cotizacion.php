<?php

	include '../../config/conexion.php';

	session_start();
	$id_usuario = $_SESSION['id_usuario'];

	$id = $_GET['id'];

	$sql = $con->query("SELECT *from tmp_cot_prod where id_tmp = '$id' AND usuario_tmp = '$id_usuario' ");

	if ($row = $sql->fetch_array()) 
	{
		$codigo = $row['id_producto'];
		$cantidad = $row['cantidad_tmp'];
		$precio = $row['precio_tmp'];

	}

	$sql = $con->query("SELECT *from producto where codigo = '$codigo' ");
	if ($row = $sql->fetch_array()) 
	{
		$descripcion = $row['descripcion'];
		$costo = $row['costo'];
		$porcentaje1=$row["precio1"];
		$porcentaje2=$row["precio2"];
		$porcentaje3=$row["precio3"];
		$stock = $row['cantidad'];

		$precio1 = $costo+$porcentaje1*$costo/100;
		$precio2 = $costo+$porcentaje2*$costo/100;
		$precio3 = $costo+$porcentaje3*$costo/100;
	}

?>	
	<div class="table-responsive">
	  <table>
		<tr>
			<th>Código</th>
			<th>Producto</th>
			<th><span class="pull-center">Cant.</span></th>
			<th><span class="pull-center">Precio</span></th>
			<th class='text-center' style="width: 35px;"></th>
		</tr>
		<br><br>
		<tr>
			<td class='col-xs-1'>
				<div class="pull-left">
					<?php echo $codigo; ?>
				</div>	
			</td>	
			<td class='col-xs-1'>
				<div class="pull-left">
					<?php echo $descripcion; ?>
				</div>	
			</td>
			<td class='col-xs-1'>
				<div class="pull-center">
				<input type="number" min="0" class="form-control" style="text-align:right; width: 60%;" id="cantidad<?php echo $codigo; ?>"  value="<?php echo $cantidad; ?>" >
				</div>
			</td>
			<td class='col-xs-1'>
				<div class="pull-left">
				<input type="hidden" name="costo" id="costo" value="<?php echo $costo; ?>">
				<input type="text" class="form-control" value="<?php echo $precio ?>" id="precio_venta<?php echo $codigo; ?>" list="precio" onclick="borrar_data('<?php echo $codigo; ?>')">
				<datalist name="precio_venta" id="precio">
					<option value="<?php echo $precio1; ?>"><?php echo "Precio 1"?></option>
					<option value="<?php echo $precio2; ?>"><?php echo "Precio 2" ?></option>
					<option value="<?php echo $precio3; ?>"><?php echo "Precio 3" ?></option>
				</datalist>
				</div>
			</td>
			<td class="col-xs-1" class='text-center'>
				<a class='btn btn-info' onclick="editarProducto('<?php echo $codigo; ?>', '<?php echo $stock; ?>')">Aplicar</a>
			</td>
		</tr>
	  </table>
	</div>
<?php
	mysqli_close($con);
?>


<script>
	function borrar_data(codigo)
	{
		document.getElementById('precio_venta'+codigo).value = "";
	}
</script>