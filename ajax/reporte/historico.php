<?php

include '../../config/conexion.php';
session_start();

$cod = $_POST['codigo'];

$his=array();
$sql = $con->query("select fecha,compra.codigo as codigo,proveedor.nombre as nombre,cantidad from compra,detallecompra,proveedor WHERE proveedor.codigo=cod_proveedor and compra.codigo=cod_compra and compra.estatus = 2 and cod_producto = '$cod' ");
while ($row=$sql->fetch_array()){
    $his[]=array(
        'fecha'    => $row['fecha'],
        'tipo'     => 'Compra',
        'codigo'   => $row['codigo'],
        'nombre'   => $row['nombre'],
        'cantidad' => $row['cantidad']
    );
}
$sql = $con->query("select fecha,factura.codigo as codigo,cliente.nombre as nombre,cantidad from factura,detallefactura,cliente WHERE cliente.codigo=cod_cliente and factura.codigo=codFactura and factura.estatus = 2 and codProducto = '$cod' ");
while ($row=$sql->fetch_array()){
    $his[]=array(
        'fecha'    => $row['fecha'],
        'tipo'     => 'Venta',
        'codigo'   => $row['codigo'],
        'nombre'   => $row['nombre'],
        'cantidad' => $row['cantidad']
    );
}
$sql = $con->query("select fecha,ajusteinv.codigo as codigo,tipo_ajuste,usuario.nombre as nombre,cantidad from ajusteinv,detalleajusteinv,usuario WHERE usuario.codigo=usuario and ajusteinv.codigo=cod_ajuste and factura.estatus = 2 and cod_producto = '$cod' ");
while ($row=$sql->fetch_array()){
    $his[]=array(
        'fecha'    => $row['fecha'],
        'tipo'     => $row['tipo_ajuste'],
        'codigo'   => $row['codigo'],
        'nombre'   => $row['nombre'],
        'cantidad' => $row['cantidad']
    );
}


function ordenar( $a, $b ) {
    return strtotime($a['fecha']) - strtotime($b['fecha']);
}
usort($his, 'ordenar');


?>
<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th class='text-center'>Fecha</th>
            <th>Codigo</th>
            <th class='text-center'>tipo</th>
            <th class="text-center">nombre</th>
            <th class="text-center">cantidad</th>
            <th class="text-center">total</th>
        </tr>
        </thead>
        <?php
        $total =0;
        foreach ($his as $row){

            if($row['tipo']=='Compra'){
                $total += $row['cantidad'];
            }elseif ($row['tipo']=='Venta'){
                $total -= $row['cantidad'];
            }elseif ($row['tipo']=='ENTRADA'){
                $total += $row['cantidad'];
            }elseif($row['tipo']=='SALIDA'){
                $total -= $row['cantidad'];
            }
        ?>
        <tbody>
            <tr>
                <td class='text-center'><?php echo $row['fecha']; ?></td>
                <td class='text-center'><?php echo $row['tipo']; ?></td>
                <td class='text-center'><?php echo $row['codigo'];?></td>
                <td class='text-center'><?php echo $row['nombre'];?></td>
                <td class='text-center'><?php echo $row['cantidad'];?></td>
                <td class='text-center'><?php echo $total?></td>
            </tr>
            <?php
        }
        ?>

        </tbody>
    </table>
</div>
