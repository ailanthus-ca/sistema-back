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

    ?>


    <?php
    $sql_cliente = $con->query("select * from cliente where codigo='$id_cliente'");
    $rw_cliente = mysqli_fetch_array($sql_cliente);
            $fecha = new \DateTime($fecha_cotizacion);
    ?>		

    <!--Titulo del reporte-->
    <div style="text-align: center;">
        <span style="color: #34495e;font-size:14px;font-weight:bold"><strong>NOTA DE ENTREGA</strong></span>
    </div>
    <div style="text-align: left;">
        <span style="font-size:10px;font-weight:bold"><strong>DATOS DEL CLIENTE</strong></span>
    </div>

    <table border="0" cellspacing="3" style="width: 100%; font-size: 7pt;">
        <tr>
            <td style="width: 100%;">	
                <table cellspacing="3" style="width: 100%; font-size: 7pt;">   
                    <tr>
                        <td  style="width: 82%;"><strong style="font-size: 7pt;">NOMBRE:&nbsp; </strong> <?php echo $rw_cliente['nombre'] ?></td>      	
                        <td style="width: 20%;"><strong style="font-size: 7pt;">FECHA:&nbsp; </strong> <?php echo $fecha->format('d/m/Y');  ?> </td>		
                    </tr>
                </table>

                <table cellspacing="3" style="width: 100%; text-align: left; font-size: 7pt;">
                    <tr>
                        <td style="width: 82%;"> <strong style="font-size: 7pt;"><?php echo $cod_fiscal ?>:&nbsp;</strong> <?php echo $rw_cliente["codigo"] ?></td>
                        <td style="width: 20%;"> <strong style="font-size: 7pt;">NOTA DE ENTREGA N°:&nbsp;</strong> <?php echo $num_cotizacion ?> </td>
                    </tr>		
                </table>

                <table cellspacing="3" style="width: 100%; text-align: left; font-size: 7pt;">
                    <tr>
                        <td style="width: 30%;"> <strong style="font-size: 7pt;">TELEFONO:&nbsp;</strong><?php echo $rw_cliente["telefono"] ?> </td>
                        <td style="width: 30%;"> <strong style="font-size: 7pt;">EMAIL:&nbsp;</strong><?php echo $rw_cliente["correo"] ?> </td>
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
    <div style="text-align: left;">
        <span style="font-size:10px;font-weight:bold"><strong>DESCRIPCION</strong></span>
    </div>
    <!--<hr>-->

    <table border="1" cellspacing="0" style="width: 100%; text-align: left; font-size: 7pt;">    
        <tr>
            <th style="width: 15%;text-align:center;" >CODIGO</th>
            <th style="width: 60%;text-align: center;">DESCRIPCION</th>
            <th style="width: 10%;text-align: center;">UND</th>
            <th style="width: 15%;text-align: center;">CANTIDAD</th>

        </tr>
        <?php
        $nums = 1;
        $sumador_total = 0;
        $query = "SELECT " .
                "producto.codigo AS codProducto, " .
                "producto.descripcion AS descripcion, " .
                "unidad.descripcion AS unidad, " .
                "detallesNotas.cantidad AS cantidad, " .
                "detallesNotas.precio AS precio " .
                "FROM producto, detallesNotas, unidad " .
                "WHERE producto.codigo = detallesNotas.producto " .
                "AND detallesNotas.nota = $id_nota " .
                "AND unidad.codigo = producto.unidad";
        $sql = $con->query($query);
        while ($row = $sql->fetch_array()) {
            $codigo_producto = $row['codProducto'];
            $cantidad = $row['cantidad'];
            $nombre_producto = $row['descripcion'];
            $unidad = $row['unidad'];
            $precio = $row['precio'];
            $sumador_total += $row['precio']*$cantidad;
            ?>

            <tr>
                <td style=" text-align: center;width: 15%; height: 15px; vertical-align: middle;"><?php echo $codigo_producto; ?></td>
                <td style=" width: 40%; max-width: 60%; overflow: hidden; text-align: left; height: 15px; vertical-align: middle;"><?php echo $nombre_producto; ?></td>
                <td style=" text-align: center;width: 15%; height: 15px; vertical-align: middle;"><?php echo $unidad; ?></td>
                <td style=" text-align: center;width: 15%; height: 15px; vertical-align: middle;"><?php echo $cantidad; ?></td>

            </tr>

            <?php
            $nums++;
        }
        ?>


    </table>
    <br>


    <!--Condiciones-->
    <div style="text-align: left;">
        <span style="font-size:10px;font-weight:bold"><strong>CONDICIONES</strong></span>
    </div>	
    <table border="1" cellspacing="0" style="width: 100%; font-size: 7pt;">
        <tr>
            <td style="width: 100%;">	
                <table cellspacing="3" style="width: 100%; font-size: 7pt;"> 		    
                    <tr>
                        <td  style="width: 100%;"><strong style="font-size: 7pt;">FORMA DE PAGO:&nbsp; </strong> DE CONTADO</td>      	
                    </tr>		    		    
                    <tr>
                        <td  style="width: 100%;"><strong style="font-size: 7pt;">TIEMPO DE ENTREGA:&nbsp; </strong>INMEDIATA</td>      	
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
                <strong>Atentamente: <?php printf($username) ?></strong>
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

    <!--Pie de pagina del reporte-->
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