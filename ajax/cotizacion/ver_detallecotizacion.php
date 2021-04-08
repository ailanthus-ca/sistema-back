<?php

	include '../../config/conexion.php';

	$id = $_GET['id'];

	$sql = $con->query("SELECT *from detallecotizacion where codCotizacion = $id");
?>	
	<div class="table-responsive">
	  <table border="1">
		<tr>
			<th>Código</th>
			<th>Producto</th>
			<th><span class="pull-center">Cant.</span></th>
			<th><span class="pull-center">Monto</span></th>
			<th><span class="pull-center">Comentario</span></th>
		</tr>	  
<?php	  
	while ($row = $sql->fetch_array()) 
	{
		$codigo = $row['codProducto'];
		$cantidad = $row['cantidad'];
		$monto = floatval($row['monto']);
		$comentario = $row['comentario'];

		$sql2 = $con->query("SELECT *from producto where codigo = '$codigo' ");
		if ($row2 = $sql2->fetch_array()) 
		{
			$descripcion = $row2['descripcion'];
		}
?>			
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
					<?php echo $cantidad; ?>
				</div>
			</td>
			<td class='col-xs-1'>
				<?php echo $monto; ?>
			</td>
			<td class='col-xs-1'>
				<?php echo $comentario; ?>
			</td>			
		</tr>

<?php
	}
?>	
	  </table>
	</div>
<?php
	mysqli_close($con);
?>