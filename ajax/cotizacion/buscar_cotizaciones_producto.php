<?php
include '../../config/conexion.php';
// escaping, additionally removing everything that could be (html/javascript-) code
$q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
$sTable = "cotizacion, cliente, detallecotizacion";
$Producto = $_GET['Producto'];
$sWhere = "";
$sWhere .= " WHERE cotizacion.cod_cliente=cliente.codigo";
$sWhere .= " and detallecotizacion.codCotizacion=cotizacion.codigo";
$sWhere .= " and detallecotizacion.codProducto = '" . $Producto."'";
$sWhere .= " order by cotizacion.codigo desc";
include '../paginaciones/pagination_cot.php'; //include pagination file
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
$sql = "SELECT cotizacion.codigo as codFact, fecha, nombre,telefono,correo, cotizacion.estatus as estatusFact,total,contacto  FROM  $sTable $sWhere LIMIT $offset,$per_page";
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
                <th>Cliente</th>
                <th>Estado</th>
                <th class='text-right'>Total</th>
                <th class='text-right'>Acciones</th>

            </tr>
            <?php
            while ($row = mysqli_fetch_array($query)) {
                $numero_cotizacion = $row['codFact'];
                $fecha = date("d/m/Y", strtotime($row['fecha']));
                $nombre_cliente = $row['nombre'];
                $telefono_cliente = $row['telefono'];
                $email_cliente = $row['correo'];
                $contacto = $row['contacto'];
                $estado_factura = $row['estatusFact'];
                if ($estado_factura == 2) {
                    $text_estado = "Procesada";
                    $label_class = 'label-success';
                } elseif ($estado_factura == 1) {
                    $text_estado = "Pendiente";
                    $label_class = 'label-warning';
                } else {
                    $text_estado = "Cancelada";
                    $label_class = 'label-danger';
                }
                $total_venta = $row['total'];
                ?>
                <tr>
                    <td><a href="#" data-toggle="modal" data-target="#ver_detalleC" onclick="ver_detalle('<?php echo $numero_cotizacion; ?>');"><?php echo $numero_cotizacion; ?></a></td>
                    <td><?php echo $fecha; ?></td>
                    <td><a href="#" data-toggle="tooltip" data-placement="top" title="<i class='glyphicon glyphicon-phone'></i> <?php echo $telefono_cliente; ?><br><i class='glyphicon glyphicon-user'></i>  <?php echo $contacto; ?><br><i class='glyphicon glyphicon-envelope'></i>  <?php echo $email_cliente; ?>" ><?php echo $nombre_cliente; ?></a></td>
                    <td><span class="label <?php echo $label_class; ?>"><?php echo $text_estado; ?></span></td>
                    <td class='text-right'><?php echo number_format($total_venta, 2); ?></td>					
                    <td class="text-right">
                        <a href="#" class='btn btn-default' data-toggle="modal" data-target="#ver_seguimiento_cotizacion" title='Ver seguimiento' onclick="seguimiento_cotizacion('<?php echo $numero_cotizacion; ?>');"><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="#" class='btn btn-default' title='Descargar cotizacion' onclick="imprimir_cotizacion('<?php echo $numero_cotizacion; ?>');"><i class="glyphicon glyphicon-download"></i></a>
                        <a href="#" class='btn btn-default' title='Cancelar cotizacion' onclick="eliminar('<?php echo $numero_cotizacion; ?>')"><i class="glyphicon glyphicon-ban-circle"></i> </a>
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
mysqli_close($con);
?>