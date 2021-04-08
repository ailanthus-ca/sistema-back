<?php


	include '../../config/conexion.php';
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	
	if($action == 'ajax') {

        $tipo = mysqli_real_escape_string($con,(strip_tags($_REQUEST['tipo'], ENT_QUOTES)));
        $mes = mysqli_real_escape_string($con,(strip_tags($_REQUEST['mes'], ENT_QUOTES)));
        $fecha1 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['fecha1'], ENT_QUOTES)));
        $fecha2 = mysqli_real_escape_string($con,(strip_tags($_REQUEST['fecha2'], ENT_QUOTES)));

        $sTable = "ajusteinv,usuario";
        $datos = "ajusteinv.codigo,fecha,nombre";
        $sWhere = "WHERE ajusteinv.usuario=usuario.codigo and tipo_ajuste = '$tipo'";
        //$sWhere.="";
        if ($_GET['mes'] != 0) {
            $sWhere .= " AND month(fecha) = $mes";
        }

        if ($_GET['fecha1'] != "" || $_GET['fecha2'] != "") {
            $sWhere .= " AND fecha between '$fecha1' AND '$fecha2' ";
        }

        $sWhere .= " order by ajusteinv.codigo desc";
        include '../pagination.php'; //include pagination file
        //pagination variables
        $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
        $per_page = 10; //how much records you want to show
        $adjacents = 4; //gap between pages after number of adjacents
        //Count the total number of row in your table*/
        $count_query = $con->query("SELECT count(*) AS numrows FROM $sTable  $sWhere");
        $row = mysqli_fetch_array($count_query);
        $numrows = $row['numrows'];
        $reload = './reporte_ajustes.php';
        //main query to fetch the data
        $sql = "SELECT $datos FROM  $sTable $sWhere";
        $query = $con->query($sql);
        //loop through fetched data
        if ($numrows > 0) {
            echo mysqli_error($con);
            $i = 0;
            ?>
            </table>
            </div>
            <table class="table-responsive col-md-12" border="1">
                <tr class="info">
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    </th>
                </tr></table>
            <?php
            while ($row = mysqli_fetch_array($query)) {
                $id_ajuste = $row['codigo'];
                $fecha = date("d/m/Y", strtotime($row['fecha']));
                $nombre = $row['nombre'];
                ?>
                <div>
                <div class="col-md-2">Codigo: <a href="#" data-toggle="modal" data-target="#ver_detalleAjuste"
                                         onclick="ver_detalle('<?php echo $id_ajuste; ?>');"><?php echo $id_ajuste; ?></a>
                </div>
                <div class="col-md-2">Fecha:<?php echo $fecha; ?></div>
                <div class="col-md-7"> Usuario:<?php echo json_encode($nombre); ?></div>
                <div class="text-right col-md-1">
                    <a href="#" class='btn btn-default' title='Descargar'
                       onclick="imprimir_ajuste('<?php echo $id_ajuste; ?>');"><i
                                class="glyphicon glyphicon-download"></i></a>
                </div>
                </div>
                <div class="table-responsive col-md-12">
                    <table class="table">
                        <tr class="info">
                            <th>codigo</th>
                            <th>Producto</th>
                            <th align="right">cantidad</th>
                            <th>descripccion</th>
                            </th>
                        </tr>
                        <?php
                        $sql2 = "select cod_producto,detalleajusteinv.cantidad,detalleajusteinv.descripcion as d,producto.descripcion as p from detalleajusteinv,producto WHERE producto.codigo=detalleajusteinv.cod_producto and detalleajusteinv.cod_ajuste=$id_ajuste";
                        $query2 = $con->query($sql2);
                        while ($row2 = mysqli_fetch_array($query2)) {
                            $cod = $row2['cod_producto'];
                            $nomb = $row2['p'];
                            $can = $row2['cantidad'];
                            $des = $row2['d'];
                            ?>
                            <tr>
                                <td><?php echo $cod; ?></td>
                                <td><?php echo $nomb; ?></td>
                                <td align="right"><?php echo $can; ?></td>
                                <td><?php echo $des; ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
                <table class="table-responsive col-md-12" border="1">
                    <tr class="info">
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        </th>
                    </tr></table>
                <?php
            }
            ?>
            <?php
        }
    }