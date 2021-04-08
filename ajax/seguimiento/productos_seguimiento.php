<?php


	include '../../config/conexion.php';
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	
	if($action == 'ajax'){

         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		  $sTable = "producto";
		 $sWhere = "";
		 $sWhere.="";
		if ( $_GET['q'] != "" )
		{
		$sWhere.= "where (producto.descripcion like '%$q%' or producto.codigo like '%$q%')";
			
		}
		
		$sWhere.=" order by producto.descripcion desc";
		include '../pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = $con->query("SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './index.php';
		//sql principal para traer los datos
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = $con->query($sql);
		//loop through fetched data
		if ($numrows>0){
			echo mysqli_error($con);
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>Codigo</th>
					<th style="width: 35%;">Descripción</th>
					<th>Tipo</th>
					<th>Cantidad</th>
					<th>Operación</th>					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$codigo = $row['codigo'];
						$descripcion = $row['descripcion'];
						$tipo = $row['tipo'];
						$unidad = $row['unidad'];
						$cantidad = $row['cantidad'];
						$costo = $row['costo'];
						$precio1 = $row['precio1'];
						$precio2 = $row['precio2'];
						$precio3 = $row['precio3'];
						$estatus = $row['estatus'];
			
					?>
					<tr>
						<td><?php echo $codigo ?></td>
						<td><?php echo $descripcion; ?></td>
						<td><?php echo $tipo ?></td>
						<td><?php echo $cantidad ?></td>
					<td class="text-right">
						<a href="#" class='btn btn-default' data-toggle="modal" data-target="#seguimiento" title="Ver seguimiento" onclick="ver_seguimiento('<?php echo $codigo;?>');"><i class="glyphicon glyphicon-eye-open"></i></a> 
						<a href="#" class='btn btn-default' title="Imprimir reporte" onclick="imprimir_seguimiento('<?php echo $codigo; ?>');"><i class="glyphicon glyphicon-print"></i> </a>
					</td>
						
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=7><span class="pull-right"><?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>