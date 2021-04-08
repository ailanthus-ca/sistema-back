<?php

	include '../../config/conexion.php';

	$id = $_GET['id'];

	$sql = $con->query("SELECT *from tmp_ord_prod where id_tmp = $id");

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
	}

?>	
	<div class="table-responsive">
	  <table>
		<tr>
			<th>Código</th>
			<th>Producto</th>
			<th><span class="pull-center">Cant.</span></th>
			<th><span class="pull-center">Costo</span></th>
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
				<input type="text" class="form-control" style="text-align:right; width: 40%;" id="cantidad<?php echo $codigo; ?>"  value="<?php echo $cantidad; ?>" >
				</div>
			</td>
			<td class='col-xs-1'>
				<div class="pull-left">
				<input type="text" class="form-control" name="costo" id="costo_compra_<?php echo $codigo; ?>" value="<?php echo $precio; ?>">
				</div>
			</td>
			<td class="col-xs-1" class='text-center'>
				<a class='btn btn-info' onclick="editarProducto('<?php echo $codigo ?>')">Aplicar</a>
			</td>
		</tr>
	  </table>
	</div>
<?php
	mysqli_close($con);
?>