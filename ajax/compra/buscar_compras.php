<?php
include '../../config/conexion.php';

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';

if (isset($_GET['id'])) {
    $codigo_compra = $_GET['id'];
    $del1 = "update compra set estatus=0 where codigo='" . $codigo_compra . "'";
    $sql2 = $con->query("select *from detallecompra where cod_compra = '" . $codigo_compra . "' ");

    while ($row = $sql2->fetch_array()) {
        $cod = $row['cod_producto'];
        $cantidad = intval($row['cantidad']);
        $con->query("UPDATE producto set cantidad = cantidad - $cantidad WHERE codigo = '$cod' ");
    }

    if ($eliminar = $con->query($del1)) {
        ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>¡Aviso!</strong> Compra cancelada exitosamente.
        </div>
        <?php
    } else {
        ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>¡Error!</strong> No se puedo cancelar la compra.
        </div>
        <?php
        echo $del1;
    }
}

if ($action == 'ajax') {

    $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
    $sTable = "compra, proveedor";
    $sWhere = "";
    $sWhere .= " WHERE compra.cod_proveedor=proveedor.codigo";
    if ($_GET['q'] != "") {
        $sWhere .= " and  (proveedor.nombre like '%$q%' or compra.codigo like '%$q%')";
    }

    $sWhere .= " order by compra.codigo desc";
    include '../pagination.php'; //include pagination file
    //pagination variables
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 10; //how much records you want to show
    $adjacents = 4; //gap between pages after number of adjacents
    $offset = ($page - 1) * $per_page;
    //Count the total number of row in your table*/
    $count_query = $con->query("SELECT count(*) AS numrows FROM $sTable  $sWhere");
    $row = mysqli_fetch_array($count_query);
    $numrows = $row['numrows'];
    $total_pages = ceil($numrows / $per_page);
    $reload = './facturas.php';
    //main query to fetch the data
    $sql = "SELECT compra.codigo as codCompra, fecha, nombre,telefono,correo, compra.estatus as estatusCompra,total,contacto  FROM  $sTable $sWhere LIMIT $offset,$per_page";
    $query = $con->query($sql);
    //loop through fetched data
    if ($numrows > 0) {
        echo mysqli_error($con);
        ?>
        <div class="table-responsive">
            <table class="table">
                <tr  class="info">
                    <th>Nro.</th>
                    <th>Fecha</th>
                    <th>Proveedor</th>
                    <th>Estado</th>
                    <th class='text-right'>Total</th>
                    <th class='text-right'>Acciones</th>

                </tr>
        <?php
        while ($row = mysqli_fetch_array($query)) {
            $id_compra = $row['codCompra'];
            $fecha = date("d/m/Y", strtotime($row['fecha']));
            $nombre_proveedor = $row['nombre'];
            $telefono_proveedor = $row['telefono'];
            $contacto = $row['contacto'];
            $correo_proveedor = $row['correo'];
            $estado_compra = $row['estatusCompra'];
            if ($estado_compra == 2) {
                $text_estado = "Procesada";
                $label_class = 'label-success';
            } elseif ($estado_compra == 1) {
                $text_estado = "Pendiente";
                $label_class = 'label-warning';
            } else {
                $text_estado = "Cancelada";
                $label_class = 'label-danger';
            }
            $total_compra = $row['total'];
            ?>
                    <tr>
                        <td><a href="#" data-toggle="modal" data-target="#ver_detalleCompra" onclick="ver_detalle('<?php echo $id_compra; ?>');"><?php echo $id_compra; ?></a></td>
                        <td><?php echo $fecha; ?></td>
                        <td><a href="#" data-toggle="tooltip" data-placement="top" title="<i class='glyphicon glyphicon-phone'></i> <?php echo $telefono_proveedor; ?><br><i class='glyphicon glyphicon-user'></i>  <?php echo $contacto; ?><br><i class='glyphicon glyphicon-envelope'></i>  <?php echo $correo_proveedor; ?>" ><?php echo $nombre_proveedor; ?></a></td>
                        <td><span class="label <?php echo $label_class; ?>"><?php echo $text_estado; ?></span></td>
                        <td class='text-right'><?php echo number_format($total_compra, 2); ?></td>					
                        <td class="text-right">
                                <!--<a href="editar_factura.php?id_factura=<?php echo $id_factura; ?>" class='btn btn-default' title='Editar factura' ><i class="glyphicon glyphicon-edit"></i></a>--> 
                            <a href="#" class='btn btn-default' title='Descargar compra' onclick="imprimir_compra('<?php echo $id_compra; ?>');"><i class="glyphicon glyphicon-download"></i></a> 
                            <a href="#" class='btn btn-default' title='Cancelar compra' onclick="eliminar('<?php echo $id_compra; ?>')"><i class="glyphicon glyphicon-ban-circle"></i> </a>
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