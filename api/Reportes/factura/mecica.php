<table class="style-none" cellspacing="3" style="width: 100%; font-size: 8pt;">   
    <tr>
        <td class="style-none" style="width: 40%;"><strong >NOMBRE Y RAZON SOCIAL:&nbsp; </strong> <br> <?php echo $data['nombre'] ?></td>      	
        <td class="style-none" style="width: 40%;"><strong >LUGAR Y FECHA DE EMICION:&nbsp;<br> </strong> BARQUISIMETO, <?php echo $fecha->format('d/m/Y'); ?> </td>		
        <td class="style-none" style="width: 20%;"> <strong >FACTURA:&nbsp;</strong><br> <?php echo $data['codigo'] ?> </td>
    </tr>
</table>
<table class="style-none" cellspacing="3" style="text-align: left; font-size: 8pt;">
    <tr class="style-none">
        <td class="style-none" style="width: 100%;"> <strong > DIRECCION FISCAL:&nbsp;</strong><br>  <?php echo $data['direccion'] ?></td>
    </tr>
</table>	
<table class="style-none" cellspacing="3" style="width: 100%; text-align: left; font-size: 8pt;">
    <tr class="style-none">
        <td class="style-none" style="width: 40%;"> <strong ><?php echo $region['cod_fiscal'] ?>:&nbsp;</strong> <?php echo $data["cod_cliente"] ?></td>
        <td class="style-none" style="width: 40%;"> <strong >NIT:&nbsp;</strong> </td>
        <td class="style-none" style="width: 20%;"> <strong >TELEFONO:&nbsp;</strong><?php echo $data["telefono"] ?> </td>
    </tr>		
</table>
<table class="style-none" cellspacing="3" style="width: 100%;text-align: left; font-size: 8pt;">
    <tr class="style-none">
        <td class="style-none" style="width: 40%;">
            <strong>CONDICION:&nbsp;</strong><?php echo $data["condicion"]; ?>	
        </td>
        <td class="style-none" style="width: 40%;">
            <strong>VENDEDOR:&nbsp;</strong><?php echo $data["usuario"]; ?>	
        </td>
        <td class="style-none" style="width: 20%;">
            <strong>VECIMIENTO:&nbsp;</strong><?php echo $fecha->format('d/m/Y') ?>	
        </td>
    </tr>
</table>		
<br>
<table class="style-none"  cellspacing="0" style="width: 100%; text-align: left; font-size: 9pt;">
    <tr class="style-none" >
        <th class="style-none"  style="width: 10%;text-align:center;" >CANTIDAD</th>
        <th class="style-none"  style="width: 45%;text-align: center;">DESCRIPCION</th>
        <th class="style-none"  style="width: 10%;text-align: center;">UND</th>
        <th class="style-none"  style="width: 15%;text-align: right;">PRECIO</th>
        <th class="style-none"  style="width: 15%;text-align: right;">TOTAL</th>
    </tr>
</table>
<hr>
<table class="style-none"  cellspacing="0" style="width: 100%; text-align: left; font-size: 9pt;">    
    <tr class="style-none" >
        <th class="style-none"  style="width: 10%;text-align: center;" ></th>
        <th class="style-none"  style="width: 45%;text-align: center;" ></th>
        <th class="style-none"  style="width: 10%;text-align: center;" ></th>
        <th class="style-none"  style="width: 15%;text-align: right;" ></th>
        <th class="style-none"  style="width: 15%;text-align: right;" ></th>
    </tr>    
    <?php
    $subtotal = 0;
    foreach ($data['detalles'] as $pro) {
        $subtotal += $pro['unidades'] * $pro['precio'];
        ?><tr class="style-none">
            <td class="style-none" style=" width: 10%; text-align: center;"><?php echo $pro['unidades']; ?></td>
            <td class="style-none" style=" width: 45%; max-width: 45%; overflow: hidden; text-align: left;"><?php echo $pro['descripcion']; ?></td>
            <td class="style-none" style=" width: 10%; text-align: center;"><?php echo $pro['medida']; ?></td>
            <td class="style-none" style=" width: 15%; text-align: right;"><?php echo number_format($pro['precio'], 2, ',', '.'); ?></td>
            <td class="style-none" style=" width: 15%; text-align: right;"><?php echo number_format($pro['unidades'] * $pro['precio'], 2, ',', '.'); ?></td>
        </tr><?php    }
    ?>
</table>
<hr>
<table class="style-none" style="width: 100%; font-size: 9pt;">
    <tr class="style-none">
        <td class="style-none" rowspan="5" style="width: 60%; text-align: left; font-size: 7pt;"><strong>OBSERVACION: <?php echo $data['nota']; ?></strong></td>
        <td class="style-none" style="width: 20%;text-align: right;"><strong> SUBTOTAL <?php echo $region['moneda']; ?>: </strong></td>
        <td class="style-none" style="width: 15%;text-align: right;"> <?php echo number_format($subtotal, 2, ',', '.'); ?></td>
    </tr>
    <tr class="style-none">
        <td class="style-none" style="width: 20%;text-align: right;"><strong> BASE IMPONIBLE <?php echo $region['moneda']; ?>: </strong></td>
        <td class="style-none" style="width: 15%;text-align: right;"> <?php echo number_format($subtotal, 2, ',', '.'); ?></td>
    </tr>
    <tr class="style-none">
        <td class="style-none" style="width: 20%; text-align: right;"><strong> IVA <?php echo $region['impuesto'] . "% " . $region['moneda']; ?>:</strong></td>
        <td class="style-none" style="width: 15%; text-align: right;"> <?php echo number_format($subtotal * $region['impuesto'] / 100, 2, ',', '.'); ?></td>
    </tr>
    <tr class="style-none">
        <td class="style-none" style="width: 20%; text-align: right;"><strong> TOTAL <?php echo $region['moneda']; ?>:</strong></td>
        <td class="style-none" style="width: 15%; text-align: right;"> <?php echo number_format($subtotal * (1 + $region['impuesto'] / 100), 2, ',', '.'); ?></td>
    </tr>
</table>