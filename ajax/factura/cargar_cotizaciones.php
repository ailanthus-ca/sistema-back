<?php

	include '../../config/conexion.php';

	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('codigo', 'cod_cliente');//Columnas de busqueda
		 $sTable = "cotizacion";
		 $sWhere = "where estatus = 1";
		if ( $_GET['q'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		include '../paginaciones/pagination_cot.php'; //include pagination file
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
		$sql="SELECT * FROM  $sTable $sWhere  ORDER BY codigo DESC LIMIT $offset,$per_page";
		$query = $con->query($sql);
		//loop through fetched data
		if ($numrows>0){				
			
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="warning">
					<th>Cod. Cotización</th>
					<th>Cliente</th>
					<th>Fecha</th>
					<th>Total</th>
					<th class='text-center' style="width: 36px;">Agregar</th>
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
					$cod_cotizacion=$row['codigo'];
					$codigo_cliente=$row['cod_cliente'];
					//datos del cliente
					$sql2 = $con->query("SELECT nombre,telefono,direccion FROM cliente WHERE codigo = '$codigo_cliente'");
					if ($row2 = $sql2->fetch_array())
					{
						$nom_cliente = $row2['nombre'];
						$tel_cliente = $row2['telefono'];
						$dir_cliente = $row2['direccion'];
					}

					$fecha=$row["fecha"];
					$total=$row["total"];

					?>
					<input type="hidden" name="nom_cliente" id="nom_cliente_<?php echo $cod_cotizacion ?>" value="<?php echo $nom_cliente ?>">
					<input type="hidden" name="tel_cliente" id="tel_cliente_<?php echo $cod_cotizacion ?>" value="<?php echo $tel_cliente ?>">
					<input type="hidden" name="dir_cliente" id="dir_cliente_<?php echo $cod_cotizacion ?>" value ="<?php echo $dir_cliente ?>">					
					<tr>
						<td><?php echo $cod_cotizacion; ?></td>
						<td><?php echo $nom_cliente; ?><input type="hidden" name="cod_cliente" id="cod_cliente_<?php echo $cod_cotizacion ?>" value="<?php echo $codigo_cliente ?>"></td>
						<td><?php echo $fecha; ?></td>
						<td><?php echo $total; ?></td>
						<td class='text-center'><a class='btn btn-info' onclick="agregarCotizacion('<?php echo $cod_cotizacion ?>')"><i class="glyphicon glyphicon-plus"></i></a></td>
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