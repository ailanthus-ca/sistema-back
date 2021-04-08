<?php

	include '../../config/conexion.php';

	$id = $_GET['id'];

	$sql = $con->query("SELECT *from tmp_cot_prod where id_tmp = $id");

	if ($row = $sql->fetch_array()) 
	{
		$codigo_producto = $row['id_producto'];
		$cantidad        = $row['cantidad_tmp'];
		$descripcion     = $row['descripcion_tmp'];

	}

	$sql = $con->query("SELECT *from producto where codigo = '$codigo_producto' ");
	if ($row = $sql->fetch_array()) 
	{
		$nombre_producto = $row['descripcion'];
	}

?>	
	<div class="table-responsive">
	  <table>
		<tr>
			<th>Código</th>
			<th>Producto</th>
			<th><span class="pull-center">Cant.</span></th>
			<th><span class="pull-center">Descripción del ajuste</span></th>
			<th class='text-center' style="width: 35px;"></th>
		</tr>
		<br><br>
		<tr>
			<td class='col-xs-1'>
				<div class="pull-left">
					<?php echo $codigo_producto; ?>
				</div>	
			</td>	
			<td class='col-xs-1'>
				<div class="pull-left">
					<?php echo $nombre_producto; ?>
				</div>	
			</td>
			<td class='col-xs-2'>
				<div class="pull-center">
				<input type="text" class="form-control" style="text-align:right; width: 40%;" id="cantidad<?php echo $codigo_producto; ?>"  value="<?php echo $cantidad; ?>" >
				</div>
			</td>
			<td class='col-md-3'>
				<div class="pull-center">
					<textarea class="form-control col-md-3" placeholder="Descripción del ajuste" id="descripcion<?php echo $codigo_producto; ?>"><?php echo $descripcion; ?></textarea>	
				</div>
			</td>
			<td class="col-xs-1" class='text-center'>
				<a class='btn btn-info'  onclick="editarProducto('<?php echo $codigo_producto ?>')">Aplicar</a>
			</td>
		</tr>
	  </table>
	</div>
<?php
	mysqli_close($con);
?>