<?php


include '../../config/conexion.php';


$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q = strtoupper($_REQUEST['q']);
    $dp = mysqli_real_escape_string($con, (strip_tags($_REQUEST['dp'], ENT_QUOTES)));
    $aColumns = array('codigo', 'descripcion'); //Columnas de busqueda
    $sTable = "producto";
    $sWhere = "where estatus = 1";
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
    $adjacents = 4; //gap between pages after number of adjacents
    $offset = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $count_query = $con->query("SELECT count(*) AS numrows FROM $sTable  $sWhere");
    $row = mysqli_fetch_array($count_query);
    $numrows = $row['numrows'];
    $total_pages = ceil($numrows / $per_page);
    $reload = './index.php';
    //main query to fetch the data
    $sql = "SELECT * FROM  $sTable  $sWhere LIMIT $offset,$per_page";
    $query = $con->query($sql);
	//loop through fetched data

?>
		<div class="table-responsive">
			<table class="table">
				<tr class="warning">
					<th>Codigo</th>
					<th>Producto</th>
					<th>Stock</th>
					<th>Cantidad</th>
					<th>Descripcion</th>
					<th class='text-center' style="width: 36px;"></th>
				</tr>
				<?php
				while ($row = mysqli_fetch_array($query)) {
					$codigo_producto = $row['codigo'];
					$nombre_producto = $row['descripcion'];
					$stock = $row['cantidad'];

				?>
					<tr>
						<td class="col-md-1"><?php echo $codigo_producto; ?></td>
						<td class="col-md-5"><?php echo $nombre_producto; ?></td>

						<td class="col-md-2"><input type="text" class="form-control" value="<?php echo $stock ?>" name="stock" id="stock_<?php echo $codigo_producto ?>" readonly></td>

						<td class="col-md-2"><input type="text" class="form-control" name="cantidad" id="cantidad_<?php echo $codigo_producto ?>"></td>

						<td class="col-md-2"><textarea id="descripcion_<?php echo $codigo_producto ?>" class="form-control"></textarea></td>

						<td class='text-center'><a class='btn btn-info' onclick="agregar_producto('<?php echo $codigo_producto; ?>')">Agregar</a></td>

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
mysqli_close($con);
?>