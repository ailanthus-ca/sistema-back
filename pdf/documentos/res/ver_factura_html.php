<style type="text/css">
    <!--
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

    -->
</style>

<page>

    <?php
    $sql = $con->query("SELECT *from conf_region");
    if ($row = $sql->fetch_array()) {
        $cod_fiscal = $row['codigo_fiscal'];
        $moneda = $row['moneda'];
        $impuesto = $row['impuesto'];
    }
    ?>


    <?php
    $sql_factura = $con->query("SELECT *from factura where codigo = $numero_factura");
    $rw_factura = $sql_factura->fetch_array();
    $fecha = date_create($rw_factura['fecha']);
    $observacion = $rw_factura['observacion'];
    $sql_cliente = $con->query("select * from cliente where codigo='$id_cliente'");
    $rw_cliente = $sql_cliente->fetch_array();
    ?>		

    <table cellspacing="3" style="width: 100%; font-size: 8pt;">   
        <tr>
            <td  style="width: 40%;"><strong >NOMBRE Y RAZON SOCIAL:&nbsp; </strong> <br> <?php echo $rw_cliente['nombre'] ?></td>      	
            <td style="width: 40%;"><strong >LUGAR Y FECHA DE EMICION:&nbsp;<br> </strong> BARQUISIMETO, <?php echo date_format($fecha, 'd/m/Y') ?> </td>		
            <td style="width: 20%;"> <strong >FACTURA:&nbsp;</strong><br> <?php echo $numero_factura ?> </td>
        </tr>
    </table>

    <table cellspacing="3" style="text-align: left; font-size: 8pt;">
        <tr>
            <td style="width: 100%;"> <strong > DIRECCION FISCAL:&nbsp;</strong><br>  <?php echo $rw_cliente['direccion'] ?></td>
        </tr>
    </table>	
    <table cellspacing="3" style="width: 100%; text-align: left; font-size: 8pt;">
        <tr>
            <td style="width: 40%;"> <strong ><?php echo $cod_fiscal ?>:&nbsp;</strong> <?php echo $rw_cliente["codigo"] ?></td>
            <td style="width: 40%;"> <strong >NIT:&nbsp;</strong> </td>
            <td style="width: 20%;"> <strong >TELEFONO:&nbsp;</strong><?php echo $rw_cliente["telefono"] ?> </td>
        </tr>		
    </table>

    <table cellspacing="3" style="width: 100%;text-align: left; font-size: 8pt;">
        <tr>
            <td style="width: 40%;">
                <strong>CONDICION:&nbsp;</strong><?php echo $condiciones;?>	
            </td>
            <td style="width: 40%;">
                <strong>VENDEDOR:&nbsp;</strong><?php echo $rw_user["nombre"];?>	
            </td>
            <td style="width: 20%;">
                <strong>VECIMIENTO:&nbsp;</strong><?php echo date_format($fecha, 'd/m/Y')?>	
            </td>
        </tr>
    </table>		

    <br>

    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 9pt;">
        <tr>
            <th style="width: 10%;text-align:center;" >CANTIDAD</th>
            <th style="width: 45%;text-align: center;">DESCRIPCION</th>
            <th style="width: 10%;text-align: center;">UND</th>
            <th style="width: 15%;text-align: center;">PRECIO</th>
            <th style="width: 20%;text-align: center;">TOTAL</th>

        </tr>
    </table>
    <hr>
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 9pt;">    
        <tr>
            <th style="width: 10%;text-align: center;" ></th>
            <th style="width: 45%;text-align: center;" ></th>
            <th style="width: 10%;text-align: center;" ></th>
            <th style="width: 15%;text-align: center;" ></th>
            <th style="width: 20%;text-align: center;" ></th>
        </tr>    
        <?php
        $nums = 1;
        $sumador_total = 0;
        $sql = $con->query("SELECT producto.codigo AS codProducto, producto.descripcion AS descripcion, 
								unidad.descripcion AS unidad, detallefactura.cantidad AS cantidad,  
								detallefactura.monto AS monto
								FROM producto, detallefactura, unidad
								WHERE producto.codigo = detallefactura.codProducto 
								AND detallefactura.codFactura = $id_factura 
								AND unidad.codigo = producto.unidad");
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
            $sumador_total += $precio_total_r; //Sumador
            ?>
            <tr>
                <td style=" width: 10%; text-align: center;"><?php echo $cantidad; ?></td>
                <td style=" width: 45%; max-width: 45%; overflow: hidden; text-align: left;"><?php echo $nombre_producto; ?></td>
                <td style=" width: 10%; text-align: center;"><?php echo $unidad; ?></td>
                <td style=" width: 15%; text-align: right;"><?php echo number_format($precio_venta_r, 2, ',', '.'); ?></td>
                <td style=" width: 20%; text-align: right;"><?php echo number_format($precio_total_r, 2, ',', '.'); ?></td>
            </tr>
            <?php
            $nums++;
        }
        $subtotal = number_format($sumador_total, 2, '.', '');
        $total_iva = ($subtotal * $porc_impuesto ) / 100;
        $total_iva = number_format($total_iva, 2, '.', '');
        $total_factura = $subtotal + $total_iva;
        ?>
    </table>
<page_footer backtop="20">
    <hr>
    <table style="width: 100%; font-size: 9pt;">
        <tr>
            <td rowspan="5" style="width: 60%; text-align: left; font-size: 7pt;"><strong>OBSERVACION: <?php echo $observacion; ?></strong></td>
            <td style="width: 20%;text-align: right;"><strong> SUBTOTAL <?php echo $moneda; ?>: </strong></td>
            <td style="width: 20%;text-align: right;"> <?php echo number_format($subtotal, 2, ',', '.'); ?></td>
        </tr>
        <tr>
            <td style="width: 20%;text-align: right;"><strong> BASE IMPONIBLE <?php echo $moneda; ?>: </strong></td>
            <td style="width: 20%;text-align: right;"> <?php echo number_format($subtotal, 2, ',', '.'); ?></td>
        </tr>
        <tr>
            <td style="width: 20%;text-align: right;"><strong> DESCUENTO <?php echo $moneda; ?>: </strong></td>
            <td style="width: 20%;text-align: right;"> <?php echo number_format(0, 2, ',', '.'); ?></td>
        </tr>
        <tr>
            <td style="width: 20%; text-align: right;"><strong> IVA <?php echo $porc_impuesto . "% " . $moneda; ?>:</strong></td>
            <td style="width: 20%; text-align: right;"> <?php echo number_format($total_iva, 2, ',', '.'); ?></td>
        </tr>
        <tr>
            <td style="width: 20%; text-align: right;"><strong> TOTAL <?php echo $moneda; ?>:</strong></td>
            <td style="width: 20%; text-align: right;"> <?php echo number_format($total_factura, 2, ',', '.'); ?></td>
        </tr>
    </table>
    </page_footer>
</page>