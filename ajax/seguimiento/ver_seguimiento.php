<?php

	include '../../config/conexion.php';

	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	$id="";
	$id = (isset($_REQUEST['id'])&& $_REQUEST['id'] !=NULL)?$_REQUEST['id']:'';
	if($action == 'ajax'){

		include 'pagination_seguimiento.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 6; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query="SELECT count(*) AS numrows,  compra.fecha AS fecha_compra, proveedor.nombre AS proveedor, compra.total AS monto
		FROM compra, detallecompra, proveedor, producto
		WHERE producto.codigo = detallecompra.cod_producto AND compra.codigo = detallecompra.cod_compra AND proveedor.codigo = compra.cod_proveedor AND producto.codigo = '$id' ";

		$count_query = $con->query($count_query);

		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './index.php';
		//main query to fetch the data
		$sql= "SELECT compra.fecha AS  fecha_compra , proveedor.nombre AS  proveedor , compra.total AS  monto 
		FROM compra, detallecompra, proveedor, producto
		WHERE producto.codigo = detallecompra.cod_producto AND compra.codigo = detallecompra.cod_compra AND proveedor.codigo = compra.cod_proveedor AND producto.codigo =  '$id'  LIMIT $offset, $per_page ";

		//$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = $con->query($sql);
		//loop through fetched data

		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="warning">
					<th>Fecha de compra</th>
					<th>Proveedor</th>
					<th>Monto</th>
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
					$fecha_compra=$row['fecha_compra'];
					$proveedor=$row['proveedor'];
					$monto = $row['monto'];

					?>
					<tr>
						<td><?php echo $fecha_compra; ?></td>
						<td><?php echo $proveedor; ?></td>
						<td><?php echo $monto; ?></td>
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=5><span class="pull-right">
					<?php
					 echo paginate($reload, $page, $total_pages, $adjacents, $id);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
	mysqli_close($con);
?>