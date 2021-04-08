<?php

	include '../../config/conexion.php';

	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('codigo', 'descripcion');//Columnas de busqueda
		 $sTable = "producto";
		 $sWhere = "where estatus = 1 AND enser = 0";
		if ( $_GET['q'] != "" )
		{
			$sWhere = "where estatus = 1 AND enser = 0 AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		include '../pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 5; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = $con->query("SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './index.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = $con->query($sql);
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="warning">
					<th>Código</th>
					<th>Producto</th>
					<th>Precio 1 (%)</th>
					<th>Precio 2 (%)</th>
					<th>Precio 3 (%)</th>
					<th class='text-center' style="width: 36px;"></th>
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
					$codigo_producto=$row['codigo'];
					$nombre_producto=$row['descripcion'];
					$precio1 = $row['precio1'];
					$precio2 = $row['precio2'];
					$precio3 = $row['precio3'];

					?>
					<tr>
						<td class="col-md-1"><?php echo $codigo_producto; ?></td>
						<td class="col-md-5"><?php echo $nombre_producto; ?></td>
						
						<td class="col-md-2"><input type="number" class="form-control" value="<?php echo $precio1 ?>" name="precio1" id="precio1_<?php echo $codigo_producto ?>"></td>
						
						<td class="col-md-2"><input type="number" class="form-control" value="<?php echo $precio2 ?>" name="precio2" id="precio2_<?php echo $codigo_producto ?>"></td>
						
						<td class="col-md-2"><input type="number" class="form-control" value="<?php echo $precio3 ?>" name="precio3" id="precio3_<?php echo $codigo_producto ?>"></td>
						
						<td class='text-center'><a class='btn btn-info' onclick="ajuste_producto('<?php echo $codigo_producto;?>')">Aplicar</a></td>
					
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=5><span class="pull-right">
					<?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
	mysqli_close($con);
?>