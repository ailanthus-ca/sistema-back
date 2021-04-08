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
        $porc_impuesto = $row['impuesto'];
    }

    $sql = $con->query("SELECT *from conf_venta");
    if ($row = $sql->fetch_array()) {
        $garantia = $row['garantia'];
        $observacion = $row['observacion'];
        $envio = '$row[]';
    }
    ?>        

    <?php
    $sql = $con->query("SELECT *FROM conf_empresa");
    $fila = $sql->fetch_array();
    $pago = $fila['pago'];

    include 'encabezado_cotizacion.php';
    ?>


    <?php
    $sql_factura = $con->query("SELECT *from cotizacion where codigo = $num_cotizacion");
    $row = mysqli_fetch_array($sql_factura);

    $subtotal = $row['subtotal'];
    $impuesto = $row['iva'];
    $total = $row['total'];
    $fecha = date_create($row['fecha']);
    $forma_pago = $row['forma_pago'];
    $validez = $row['validez'];
    $nota = $row['nota'];

    $sql_cliente = $con->query("select * from cliente where codigo='$id_cliente'");
    $rw_cliente = mysqli_fetch_array($sql_cliente);
    ?>		

    <br><br>
    <div style="text-align: left;">
        <span style="font-size:10px;font-weight:bold"><strong>DATOS DEL CLIENTE</strong></span>
    </div>

    <table border="0" cellspacing="3" style="width: 100%; font-size: 7pt;">
        <tr>
            <td style="width: 100%;">	
                <table cellspacing="3" style="width: 100%; font-size: 7pt;">   
                    <tr>
                        <td  style="width: 82%;"><strong style="font-size: 7pt;">NOMBRE:&nbsp; </strong> <?php echo $rw_cliente['nombre'] ?></td>      	
                        <td style="width: 20%;"><strong style="font-size: 7pt;">FECHA:&nbsp; </strong> <?php echo date_format($fecha, 'd-m-Y') ?> </td>		
                    </tr>
                </table>

                <table cellspacing="3" style="width: 100%; text-align: left; font-size: 7pt;">
                    <tr>
                        <td style="width: 82%;"> <strong style="font-size: 7pt;"><?php echo $cod_fiscal ?>:&nbsp;</strong> <?php echo $rw_cliente["codigo"] ?></td>
                        <td style="width: 20%;"> <strong style="font-size: 7pt;">NRO. COT:&nbsp;</strong> <?php echo $num_cotizacion ?> </td>
                    </tr>
                    <tr>
                        <td style="width: 30%;"> <strong style="font-size: 7pt;">TELEFONO:&nbsp;</strong><?php echo $rw_cliente["telefono"] ?> </td>
                    </tr>		
                </table>

                <table cellspacing="3" style="text-align: left; font-size: 7pt;">
                    <tr>
                        <td style="width: 30%;"> <strong style="font-size: 7pt;">DIRECCIÓN:&nbsp;</strong><?php echo $rw_cliente["direccion"] ?> </td>				
                    </tr>
                    <tr>
                        <td style="width: 30%;"> <strong style="font-size: 7pt;">ATENCIÓN:&nbsp;</strong><?php echo $rw_cliente["contacto"] ?> </td>
                    </tr>
                </table>
            </td>	
        </tr>	
    </table>
    <br>
    <!--Titulo del reporte-->
    <div style="text-align: center;">
        <span style="color: #34495e;font-size:14px;font-weight:bold"><strong>C O T I Z A C I Ó N</strong></span>
    </div>
    <hr>
    <br>
    <br>				

    <div style="text-align: left;">
        <span style="font-size:10px;font-weight:bold"><strong>DESCRIPCION DE LA COTIZACION</strong></span>
    </div>
    <!--<hr>-->

    <table border="1" cellspacing="0" style="width: 100%; text-align: left; font-size: 7pt;">    
        <tr>
            <th style="width: 10%;text-align:center;" >CODIGO</th>
            <th style="width: 40%;text-align: center;">DESCRIPCION</th>
            <th style="width: 10%;text-align: center;">UND</th>
            <th style="width: 10%;text-align:center;" >CANT</th>
            <th style="width: 15%;text-align: center;">PRECIO</th>
            <th style="width: 15%;text-align: center;">TOTAL</th>

        </tr>
        <?php
        $nums = 1;
        $sumador_total = 0;

        $sql = $con->query("SELECT producto.codigo AS codProducto, producto.descripcion AS descripcion, 							unidad.descripcion AS unidad, 																		detallecotizacion.cantidad AS cantidad,  															detallecotizacion.monto AS monto
								FROM producto, detallecotizacion, unidad
								WHERE producto.codigo = detallecotizacion.codProducto 
								AND detallecotizacion.codCotizacion = $num_cotizacion 
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
            ?>

            <tr>
                <td style=" width: 10%; text-align: center; height: 15px; vertical-align: middle;"><?php echo $codigo_producto; ?></td>
                <td style=" width: 40%; max-width: 40%; overflow: hidden; text-align: left; height: 15px; vertical-align: middle;"><?php echo $nombre_producto; ?></td>
                <td style=" width: 10%; text-align: center; height: 15px; vertical-align: middle;"><?php echo $unidad; ?></td>
                <td style=" width: 10%; text-align: center; height: 15px; vertical-align: middle;"><?php echo $cantidad; ?></td>
                <td style=" width: 15%; text-align: right; height: 15px; vertical-align: middle;"><?php echo number_format($precio_venta_r, 2, ',', '.'); ?></td>
                <td style=" width: 15%; text-align: right; height: 15px; vertical-align: middle;"><?php echo number_format($precio_total_r, 2, ',', '.'); ?></td>

            </tr>

            <?php
            $nums++;
        }
        $subtotal = number_format($subtotal, 2, '.', '');
        $total_iva = number_format($impuesto, 2, '.', '');
        $total_factura = number_format($total, 2, '.', '');
        ?>


    </table>
    <!--<hr>-->
    <table cellspacing="3" style="width: 100%; font-size: 7pt;">
        <tr>
            <td style="height: 10px; width: 60%;text-align: center;"></td>
            <td style="height: 10px; width: 25%;text-align: right;"><strong> SUB TOTAL <?php echo $moneda; ?>: </strong></td>
            <td style="height: 10px; width: 15%;text-align: right;"><?php echo number_format($subtotal, 2, ',', '.'); ?></td>
        </tr>
        <tr>
            <td style="height: 10px; width: 60%;text-align: left; font-size: 5pt; padding-left: 80px;"><?php echo $observacion; ?></td>
            <td style="height: 10px; width: 25%;text-align: right;"><strong> IMPUESTO <?php echo $porc_impuesto . "% " . $moneda; ?>: </strong></td>
            <td style="height: 10px; width: 15%;text-align: right;"><?php echo number_format($total_iva, 2, ',', '.'); ?></td>
        </tr>
        <tr>
            <td style="height: 10px; width: 60%;text-align: center;"></td>
            <td style="height: 10px; width: 25%;text-align: right;"><strong> TOTAL <?php echo $moneda; ?>:</strong></td>
            <td style="height: 10px; width: 15%;text-align: right;"><?php echo number_format($total_factura, 2, ',', '.'); ?></td>
        </tr>
    </table>



    <!--Condiciones-->
    <br>
    <div style="text-align: left;">
        <span style="font-size:10px;font-weight:bold"><strong>CONDICIONES</strong></span>
    </div>	
    <table border="1" cellspacing="0" style="width: 100%; font-size: 7pt;">
        <tr>
            <td style="width: 100%;">	
                <table cellspacing="3" style="width: 100%; font-size: 7pt;">   
                    <tr>
                        <td  style="width: 80%;"><strong style="font-size: 7pt;">FORMA DE PAGO:&nbsp; </strong> <?php echo $forma_pago ?></td>      	
                    </tr>
                    <tr>
                        <td  style="width: 80%;"><strong style="font-size: 7pt;">VALIDEZ DE LA OFERTA:&nbsp; </strong> <?php echo $validez ?></td>      	
                    </tr>
                    <tr>
                        <td  style="width: 80%;"><strong style="font-size: 7pt;">TIEMPO DE ENTREGA:&nbsp; </strong> <?php echo $tiempo_entrega ?></td>      	
                    </tr>		    
                    <tr>
                        <td  style="width: 100%;"><strong style="font-size: 7pt;">DATOS DEL PAGO:&nbsp; </strong> <?php echo $pago ?></td>      	
                    </tr>
                    <tr>
                        <td  style="width: 80%;"><strong style="font-size: 7pt;">GARANTIA DEL EQUIPO:&nbsp; </strong><?php echo $garantia; ?></td> 
                    </tr>
                    <tr>
                        <td  style="width: 80%;"><strong style="font-size: 7pt;">NOTA:&nbsp; </strong><?php echo $nota; ?></td> 
                    </tr>      	

                </table>
            </td>
        </tr>	
    </table>
    <br>

    <table cellspacing="3" style="width: 100%; font-size: 7pt;">		  
        <tr>
            <td style="width: 80%">
                <strong>Atentamente: <?php printf($_SESSION['usuario']) ?></strong>
            </td>
            <td style="width: 50%">
                <?php
                if ($envio == 1)
                    echo '<img src="../../public/imagenes/truck.png"> <strong> ENVIOS AL INTERIOR </strong>';
                else
                    echo '';
                ?>
            </td>
        </tr>
    </table>
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

</page>