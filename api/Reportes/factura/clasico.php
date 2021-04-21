<table  class="style-none" cellspacing="3" style="width: 100%; font-size: 8pt;">   
    <tr  class="style-none">
        <td  class="style-none"  style="width: 80%;"><strong >NOMBRE Y RAZON SOCIAL:&nbsp; </strong> <?php echo $data['nombre'] ?></td>      	
        <td  class="style-none" style="width: 20%;"><strong >FECHA:&nbsp; </strong> <?php echo $fecha->format('d/m/Y'); ?> </td>		
    </tr>
</table>

<table  class="style-none" cellspacing="3" style="width: 100%; text-align: left; font-size: 8pt;">
    <tr  class="style-none">
        <td  class="style-none" style="width: 50%;"> <strong ><?php echo $region['cod_fiscal'] ?>:&nbsp;</strong> <?php echo $data["cod_cliente"] ?></td>
        <td  class="style-none" style="width: 30%;"> <strong >TELEFONO:&nbsp;</strong><?php echo $data["telefono"] ?> </td>
        <td  class="style-none" style="width: 20%;"> <strong >NRO. FACT:&nbsp;</strong> <?php echo $data['codigo'] ?> </td>
    </tr>		
</table>

<table  class="style-none" cellspacing="3" style="text-align: left; font-size: 8pt;">
    <tr  class="style-none">
        <td  class="style-none" style="width: 100%;"> <strong > DIRECCION <br> FISCAL:&nbsp;</strong> <?php echo $data['direccion'] ?></td>
    </tr>
    <tr  class="style-none">
        <td  class="style-none"><strong>CONDICION:&nbsp;</strong>
            <?php
            echo $data["condicion"];
            ?>	
        </td>
    </tr>
</table>		

<br>

<table  class="style-none" cellspacing="0" style="width: 100%; text-align: left; font-size: 9pt;">
    <tr  class="style-none">
        <th  class="style-none" style="width: 10%;text-align: center;" >CANTIDAD</th>
        <th  class="style-none" style="width: 45%;text-align: center;">DESCRIPCION</th>
        <th  class="style-none" style="width: 10%;text-align: center;">UND</th>
        <th  class="style-none" style="width: 15%;text-align: center;">PRECIO</th>
        <th  class="style-none" style="width: 20%;text-align: center;">TOTAL</th>
    </tr>
</table>
<div style="width: 102%">
    <hr/>
</div>
<table  class="style-none" cellspacing="0" style="width: 100%; text-align: left; font-size: 9pt;">

    <?php
    $subtotal = 0;
    foreach ($data['detalles'] as $pro) {
        $subtotal += $pro['unidades'] * $pro['precio'];
        ?><tr  class="style-none">
            <td  class="style-none" style=" width: 10%;text-align: center; height: 15px; vertical-align: middle;"><?php echo $pro['unidades']; ?></td>
            <td  class="style-none" style=" width: 45%; max-width: 40%; overflow: hidden; text-align: left; height: 15px; vertical-align: middle;"><?php echo $pro['descripcion']; ?></td>
            <td  class="style-none" style=" width: 10%;text-align: center; height: 15px; vertical-align: middle;;"><?php echo $pro['medida']; ?></td>
            <td  class="style-none" style=" width: 15%;text-align: right; height: 15px; vertical-align: middle;"><?php echo number_format($pro['precio'], 2, ',', '.'); ?></td>
            <td  class="style-none" style=" width: 20%;text-align: right; height: 15px; vertical-align: middle;"><?php echo number_format($pro['unidades'] * $pro['precio'], 2, ',', '.'); ?></td>

        </tr><?php
    }
    ?>

</table>
<div style="width: 102%">
    <hr/>
</div>
<table  class="style-none" cellspacing="3" style="width: 100%; font-size: 7pt;">

    <tr  class="style-none">
        <th  class="style-none" style="width: 10%;text-align:center;"></th>
        <th  class="style-none" style="width: 50%; text-align: center;"></th>
        <th  class="style-none" style="width: 10%;text-align: center;"></th>
        <th  class="style-none" style="width: 15%;text-align: center;"></th>
        <th  class="style-none" style="width: 15%;text-align: center;"></th>

    </tr>

    <tr  class="style-none">
        <td  class="style-none" rowspan="5" colspan="3" style="width: 60%; text-align: left; font-size: 7pt;">
            <strong>OBSERVACION:</strong> <?php echo $data['nota']; ?>
        </td>
        <td  class="style-none" style="widtd: 85%; text-align: right;"><strong> SUB TOTAL: </strong></td>
        <td  class="style-none" style="widtd: 15%; text-align: right;"> <?php echo number_format($subtotal, 2, ',', '.'); ?></td>
    </tr>
    <tr  class="style-none">
        <td  class="style-none" style="widtd: 85%; text-align: right;"><strong> IVA: </strong></td>
        <td  class="style-none" style="widtd: 15%; text-align: right;"> <?php echo number_format($data['impuesto'], 2, ',', '.'); ?></td>
    </tr><tr  class="style-none">
        <td  class="style-none" style="widtd: 85%; text-align: right;"><strong> TOTAL COMPRA:</strong></td>
        <td  class="style-none" style="widtd: 15%; text-align: right;"> <?php echo number_format($subtotal + $data['impuesto'], 2, ',', '.'); ?></td>
    </tr>

</table>