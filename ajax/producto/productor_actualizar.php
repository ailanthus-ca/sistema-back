<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include '../../config/conexion.php';


$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if ($action == 'ajax') {
    // escaping, additionally removing everything that could be (html/javascript-) code
    $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $dp = mysqli_real_escape_string($con,(strip_tags($_REQUEST['dp'], ENT_QUOTES)));
    $aColumns = array('codigo', 'descripcion'); //Columnas de busqueda
    $sTable = "producto";
    $sWhere = "where estatus = 1 AND tipo = '1' ";
    if ($_GET['dp'] != "td") {
        $sWhere .= " AND departamento = '" . $dp . "'";
    }
    if ($_GET['q'] != "") {
        $sWhere .= " AND (";
        for ($i = 0; $i < count($aColumns); $i++) {
            $sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ')';
    }
    include '../pagination.php'; //include pagination file
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
    $sql = "SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
    $query = $con->query($sql);
    //loop through fetched data
    if ($numrows > 0) {
        ?>
        <div class="table-responsive">
            <table class="table">
                <tr  class="warning">
                    <th>C??digo</th>
                    <th>Producto</th>
                    <th class='text-center' style="width: 36px;"></th>
                </tr>
        <?php
        while ($row = mysqli_fetch_array($query)) {
            $codigo_producto = $row['codigo'];
            $nombre_producto = $row['descripcion'];
            ?>
                    <tr>
                        <td class="col-md-1"><?php echo $codigo_producto; ?></td>
                        <td class="col-md-10"><?php echo $nombre_producto; ?></td>
                        <td class='text-center col-md-1'><a class='btn btn-info' onclick="agregar('<?php echo $codigo_producto; ?>', '<?php echo $nombre_producto; ?>')">agreagar</a></td>

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
                    