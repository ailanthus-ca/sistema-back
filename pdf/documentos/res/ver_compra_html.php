<style type="text/css">
    table { vertical-align: top; }
    tr    { vertical-align: top; }
    td    { vertical-align: top; }
    .midnight-blue{
        background:#2c3e50;
        padding: 4px 4px 4px;
        color:white;
        font-weight:bold;
        font-size:12px;
    }
    .silver{
        background:white;
        padding: 3px 4px 3px;
    }
    .clouds{
        background:#ecf0f1;
        padding: 3px 4px 3px;
    }
    .border-top{
        border-top: solid 1px #bdc3c7;

    }
    .border-left{
        border-left: solid 1px #bdc3c7;
    }
    .border-right{
        border-right: solid 1px #bdc3c7;
    }
    .border-bottom{
        border-bottom: solid 1px #bdc3c7;
    }
    table.page_footer {width: 100%; border: none; background-color: white; padding: 2mm;border-collapse:collapse; border: none;}
</style>

<page >

    <?php
    $sql = $con->query("SELECT *from conf_region") or die(mysqli_error());
    if ($row = $sql->fetch_array()) {
        $cod_fiscal = $row['codigo_fiscal'];
        $impuesto = $row['impuesto'];
        $moneda = $row['moneda'];
    }
    ?>   

    <?php
    $sql = $con->query("SELECT *FROM conf_empresa") or die(mysqli_error());
    $fila = $sql->fetch_array();

    include 'encabezado.php';
    ?>


    <?php
    $sql = $con->query("SELECT *from compra where codigo = $id_compra") or die(mysqli_error());
    if ($row = $sql->fetch_array()) {
        $subtotal = $row['subtotal'];
        $total = $row['total'];
    }
    ?>  

    <?php
    $sql_proveedor = $con->query("select * from proveedor where codigo='$id_proveedor'") or die(mysqli_error());
    $rw_proveedor = mysqli_fetch_array($sql_proveedor);


    $fecha_compra = date("d/m/Y", strtotime($fecha2));
    $fecha_doc = date("d/m/Y", strtotime($fecha_documento));
    ?>	

    <br><br>
    <div style="text-align: left;">
        <span style="font-size:10px;font-weight:bold"><strong>DATOS DEL PROVEEDOR</strong></span>
    </div>

    <table cellspacing="3" style="width: 100%; font-size: 7pt;">
        <tr>
            <td  style="width: 80%;"><strong style="font-size: 7pt;">NOMBRE Y <br> RAZON SOCIAL: &nbsp; </strong> <?php echo $rw_proveedor['nombre']; ?></td>        	
            <td style="width: 20%;"><strong style="font-size: 7pt;">FECHA: &nbsp; </strong> <?php echo $fecha_compra; ?></td>			
        </tr>
    </table>

    <table cellspacing="3" style="width: 100%; text-align: left; font-size: 7pt;">
        <tr>
            <td style="width: 80%;"> <strong style="font-size: 7pt;"><?php echo $cod_fiscal ?>:&nbsp;</strong> <?php echo $rw_proveedor["codigo"]; ?></td>
            <td style="width: 30%;"> <strong style="font-size: 7pt;">NUM. COMPRA:&nbsp;</strong><?php echo $id_compra ?></td>
        </tr>
        <tr>
            <td style="width: 30%;"> <strong style="font-size: 7pt;">TELEFONO:&nbsp;</strong><?php echo $rw_proveedor["telefono"]; ?></td>
        </tr>		
    </table>

    <table cellspacing="3" style="text-align: left; font-size: 7pt;">
        <tr>
            <td style="width: 100%;"> <strong style="font-size: 7pt;">DIRECCION <br> FISCAL:&nbsp;</strong><?php echo $rw_proveedor['direccion']; ?> </td>
        </tr>
    </table>

    <br>
    <!--Titulo del reporte-->
    <div style="text-align: center;">
        <span style="color: #34495e;font-size:14px;font-weight:bold"><strong>C O M P R A</strong></span>
    </div>
    <hr>
    <br>
    <div style="text-align: left;">
        <span style="font-size:10px;font-weight:bold"><strong>DATOS DE LA COMPRA</strong></span>
    </div>

    <table cellspacing="3" style="width: 100%; text-align: left; font-size: 7pt;">
        <tr>
            <td style="width: 30%;"><strong>NRO. DOCUMENTO:&nbsp;</strong><?php echo $cod_documento; ?></td>
            <td style="width: 30%;"><strong>FECHA DOCUMENTO:&nbsp;</strong><?php echo $fecha_doc; ?></td>
        </tr>
    </table>


    <br>


    <table border="1" cellspacing="0" style="width: 100%; text-align: left; font-size: 7pt;">    
        <tr>
            <th style="width: 10%;text-align:center;" >CANTIDAD</th>
            <th style="width: 40%;text-align: center;">DESCRIPCION</th>
            <th style="width: 10%;text-align: center;">UND</th>
            <th style="width: 15%;text-align: center;">PRECIO</th>
            <th style="width: 15%;text-align: center;">TOTAL</th>

        </tr>
<?php
$nums = 1;
$sumador_total = 0;
$sql = $con->query("SELECT producto.codigo AS codProducto, producto.descripcion AS descripcion,
 								 unidad.descripcion AS unidad, detallecompra.cantidad AS cantidad,  									 detallecompra.monto AS monto, compra.subtotal as subtotal, 									 	 compra.total AS total
								FROM producto, detallecompra,compra, unidad
								WHERE producto.codigo = detallecompra.cod_producto 
								AND producto.unidad = unidad.codigo
								AND detallecompra.cod_compra = compra.codigo 
								AND compra.codigo = $id_compra") or die(mysqli_error());
while ($row = $sql->fetch_array()) {
    $codigo_producto = $row['codProducto'];
    $cantidad = $row['cantidad'];
    $nombre_producto = $row['descripcion'];
    $unidad = $row['unidad'];

    $monto = $row['monto'];
    $precio_venta = floatval($row['monto']) / intval($cantidad);
    $precio_venta_f = number_format($precio_venta, 2); //Formateo variables
    $precio_venta_r = str_replace(",", "", $precio_venta_f); //Reemplazo las comas
    $precio_total = $precio_venta_r * $cantidad;
    $precio_total_f = number_format($precio_total, 2); //Precio total formateado
    $precio_total_r = str_replace(",", "", $precio_total_f); //Reemplazo las comas
    ?>

            <tr>
                <td style=" text-align: center; height: 15px; vertical-align: middle;"><?php echo $cantidad; ?></td>
                <td style=" width: 40%; max-width: 40%; overflow: hidden; text-align: left; height: 15px; vertical-align: middle;"><?php echo $nombre_producto; ?></td>
                <td style=" text-align: center; height: 15px; vertical-align: middle;;"><?php echo $unidad; ?></td>
                <td style=" text-align: right; height: 15px; vertical-align: middle;"><?php echo number_format($precio_venta_r, 2, ',', '.'); ?></td>
                <td style=" text-align: right; height: 15px; vertical-align: middle;"><?php echo number_format($precio_total_r, 2, ',', '.'); ?></td>

            </tr>

    <?php
    $nums++;
}

$subtotal = number_format($subtotal, 2, '.', '');
$total_compra = number_format($total, 2, '.', '');
$total_iva = $total_compra - $subtotal;
$total_iva = number_format($total_iva, 2, '.', '');
?>


    </table>

    <table cellspacing="3" style="width: 100%; font-size: 7pt;">

        <tr>
            <th style="width: 10%;text-align:center;"></th>
            <th style="width: 40%; text-align: center;"></th>
            <th style="width: 25%;text-align: center;"></th>
            <th style="width: 15%;text-align: center;"></th>
            <th style="width: 15%;text-align: center;"></th>

        </tr>

        <tr>
            <td colspan="3" style="widtd: 85%; text-align: right;"><strong> SUB TOTAL: </strong></td>
            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($subtotal, 2, ',', '.'); ?></td>
        </tr>
        <tr>
            <td colspan="3" style="widtd: 85%; text-align: right;"><strong> IVA <?php echo $impuesto;
        echo "% SOBRE ";
        echo number_format($subtotal, 2, ',', '.'); ?>: </strong></td>
            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($total_iva, 2, ',', '.'); ?></td>
        </tr><tr>
            <td colspan="3" style="widtd: 85%; text-align: right;"><strong> TOTAL COMPRA:</strong></td>
            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($total_compra, 2, ',', '.'); ?></td>
        </tr>

    </table>

    <!--Pie de pagina del reporte-->
    <page_footer backtop="20">
        <hr>
        <div class="row" style="text-align: center; font-size: 10px;">
            <span> <?php echo $fila['direccion']; ?> </span>
        </div>
        <div class="row" style="text-align: center; font-size: 10px;">
            <span><?php echo $fila['telefono']; ?></span>	
        </div>
        <div class="row" style="text-align: center;font-weight:bold; font-size: 10px;">
            <span><?php echo $fila['web']; ?></span>	
        </div>	
    </page_footer>		


</page>

<?php
mysqli_close($con);
?>