<?php

include '../../config/conexion.php';


$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
	// escaping, additionally removing everything that could be (html/javascript-) code
	$q = strtoupper($_REQUEST['q']);
	$dp = mysqli_real_escape_string($con, (strip_tags($_REQUEST['dp'], ENT_QUOTES)));
	$aColumns = array('codigo', 'descripcion'); //Columnas de busqueda
	$sTable = "producto";
	$sWhere = "where enser = 0 AND estatus = 1";
	if ($_GET['dp'] != "td") {
		$sWhere .= " AND departamento = '" . $dp . "'";
	}
	if ($_GET['q'] != "") {
		$sWhere .= " AND ( codigo LIKE '%" . $q . "%' OR (";
		$t = explode(" ", $q);
		
		for ($i = 0; $i < count($t); $i++) {
			if ($t[$i] != "") {
				$sWhere .= "descripcion  LIKE '%" . $t[$i] . "%' AND ";
			}
		}
		$sWhere = substr_replace($sWhere, "", -4);
		$sWhere .= '))';
	}
	include '../paginaciones/pagination_producto.php'; //include pagination file
	//pagination variables
	$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
	$per_page = 5; //how much records you want to show
	$adjacents  = 4; //gap between pages after number of adjacents
	$offset = ($page - 1) * $per_page;
	//Count the total number of row in your table*/
	$count_query   = $con->query("SELECT count(*) AS numrows FROM $sTable  $sWhere");
	$row = mysqli_fetch_array($count_query);
	$numrows = $row['numrows'];
	$total_pages = ceil($numrows / $per_page);
	$reload = './index.php';
	//main query to fetch the data
	$sql = "SELECT * FROM  $sTable  $sWhere LIMIT $offset,$per_page";
	$query = $con->query($sql);
	//loop through fetched data
	if ($numrows > 0) {

?>
		<div class="table-responsive">
			<table class="table">
				<tr class="warning">
					<th>Código</th>
					<th>Producto</th>
					<th><span class="pull-right">Cant.</span></th>
					<th><span class="pull-right">Precio</span></th>
					<th class='text-center' style="width: 36px;">Agregar</th>
				</tr>
				<?php
				while ($row = mysqli_fetch_array($query)) {
					$codigo_producto = $row['codigo'];
					$nombre_producto = $row['descripcion'];
					$stock = $row['cantidad'];
					$costo = $row['costo'];
					$porcentaje1 = $row["precio1"];
					$porcentaje2 = $row["precio2"];
					$porcentaje3 = $row["precio3"];
					$tipo = $row['tipo'];

					$precio1 = $costo + $porcentaje1 * $costo / 100;
					$precio2 = $costo + $porcentaje2 * $costo / 100;
					$precio3 = $costo + $porcentaje3 * $costo / 100;

					$precio1 = number_format($precio1, 2, '.', '');
					$precio2 = number_format($precio2, 2, '.', '');
					$precio3 = number_format($precio3, 2, '.', '');
				?>
					<tr>
						<td><?php echo $codigo_producto; ?></td>
						<td><?php echo $nombre_producto; ?></td>
						<td class='col-xs-1'>
							<div class="pull-right">
								<input type="text" class="form-control" style="text-align:right" id="cantidad_<?php echo $codigo_producto; ?>" value="1">
							</div>
						</td>
						<td class='col-xs-2'>
							<div class="pull-right">
								<input type="hidden" name="tipo" id="tipo_<?php echo $codigo_producto ?>" value="<?php echo $tipo; ?>">
								<input type="hidden" name="costo" id="costo_producto_<?php echo $codigo_producto ?>" value="<?php echo $costo; ?>">
								<input type="hidden" name="stock" id="stock_<?php echo $codigo_producto ?>" value="<?php echo $stock ?>">

								<input type="text" class="form-control" value="<?php echo $precio2 ?>" id="precio_venta_<?php echo $codigo_producto; ?>" list="precio_<?php echo $codigo_producto; ?>" onfocus="borrar_data('<?php echo $codigo_producto; ?>')">
								<datalist name="precio_venta" id="precio_<?php echo $codigo_producto; ?>">
									<option id="precio1_<?php echo $codigo_producto ?>" value="<?php echo $precio1; ?>"><?php echo "Precio 1" ?></option>
									<option value="<?php echo $precio2; ?>"><?php echo "Precio 2" ?></option>
									<option value="<?php echo $precio3; ?>"><?php echo "Precio 3" ?></option>
								</datalist>
							</div>
						</td>
						<td class='text-center'><a class='btn btn-info' onclick="agregarProducto('<?php echo $codigo_producto ?>')"><i class="glyphicon glyphicon-plus"></i></a></td>
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

<script>
	function borrar_data(codigo) {
		console.log(codigo);
		document.getElementById('precio_venta_' + codigo).value = "";
	}
</script>