<br><br>
<div class="style-none" style="text-align: left;">
    <span style="font-size:10px;font-weight:bold"><strong>DATOS DEL PROVEEDOR</strong></span>
</div>
<table class="style-none" cellspacing="3" style="width: 100%; font-size: 7pt;">
    <tr class="style-none">
        <td class="style-none"  style="width: 80%;"><strong style="font-size: 7pt;">NOMBRE Y <br> RAZON SOCIAL: &nbsp; </strong> <?php echo $data['nombre']; ?></td>        	
        <td class="style-none" style="width: 20%;"><strong style="font-size: 7pt;">FECHA: &nbsp; </strong> <?php echo $fecha->format('d/m/Y'); ?></td>			
    </tr>
</table>
<table class="style-none" cellspacing="3" style="width: 100%; text-align: left; font-size: 7pt;">
    <tr class="style-none">
        <td class="style-none" style="width: 80%;"> <strong style="font-size: 7pt;"><?php echo $region['cod_fiscal'] ?>:&nbsp;</strong> <?php echo $data["cod_proveedor"]; ?></td>
        <td class="style-none" style="width: 30%;"> <strong style="font-size: 7pt;">NUM. COMPRA:&nbsp;</strong><?php echo $data['codigo'] ?></td>
    </tr>
    <tr class="style-none">
        <td class="style-none" style="width: 30%;"> <strong style="font-size: 7pt;">TELEFONO:&nbsp;</strong><?php echo $data["telefono"]; ?></td>
    </tr>		
</table>

<table class="style-none" cellspacing="3" style="text-align: left; font-size: 7pt;">
    <tr class="style-none">
        <td class="style-none" style="width: 100%;"> <strong style="font-size: 7pt;">DIRECCION <br> FISCAL:&nbsp;</strong><?php echo $data['direccion']; ?> </td>
    </tr>
</table>
<br>
<div style="text-align: center;">
    <span style="color: #34495e;font-size:14px;font-weight:bold"><strong>C O M P R A</strong></span>
</div>
<hr>
<br>
<div style="text-align: left;">
    <span style="font-size:10px;font-weight:bold"><strong>DATOS DE LA COMPRA</strong></span>
</div>
<table class="style-none" cellspacing="3" style="width: 100%; text-align: left; font-size: 7pt;">
    <tr class="style-none">
        <td class="style-none" style="width: 30%;"><strong>NRO. DOCUMENTO:&nbsp;</strong><?php echo $data['cod_documento']; ?></td>
        <td class="style-none" style="width: 30%;"><strong>FECHA DOCUMENTO:&nbsp;</strong><?php echo $data['fecha_documento']; ?></td>
    </tr>
</table>
<table class="border-clasico" border="1" cellspacing="0" style="width: 100%; text-align: left; font-size: 7pt;">    
    <tr class="border-clasico">
        <th class="border-clasico" style="width: 10%;text-align:center;" >CANTIDAD</th>
        <th class="border-clasico" style="width: 50%;text-align: center;">DESCRIPCION</th>
        <th class="border-clasico" style="width: 10%;text-align: center;">UND</th>
        <th class="border-clasico" style="width: 15%;text-align: center;">PRECIO <?php echo $aux ?></th>
        <th class="border-clasico" style="width: 15%;text-align: center;">TOTAL<?php echo $aux ?></th>

    </tr>
    <?php
    $subtotal = 0;
    foreach ($data['detalles'] as $pro) {
        $subtotal += $pro['unidades'] * $pro['precio'];
        ?><tr class="border-clasico">
            <td class="border-clasico" style=" text-align: center; height: 15px; vertical-align: middle;"><?php echo $pro['unidades']; ?></td>
            <td class="border-clasico" style=" width: 40%; max-width: 40%; overflow: hidden; text-align: left; height: 15px; vertical-align: middle;"><?php echo $pro['descripcion']; ?></td>
            <td class="border-clasico" style=" text-align: center; height: 15px; vertical-align: middle;;"><?php echo $pro['medida']; ?></td>
            <td class="border-clasico" style=" text-align: right; height: 15px; vertical-align: middle;"><?php echo number_format($pro['precio'], 2, ',', '.'); ?></td>
            <td class="border-clasico" style=" text-align: right; height: 15px; vertical-align: middle;"><?php echo number_format($pro['unidades'] * $pro['precio'], 2, ',', '.'); ?></td>
        </tr><?php
    }
    ?>

</table>

<table class="style-none" cellspacing="3" style="width: 100%; font-size: 7pt;">
    <tr class="style-none">
        <th class="style-none" style="width: 10%;text-align:center;"></th>
        <th class="style-none" style="width: 50%; text-align: center;"></th>
        <th class="style-none" style="width: 10%;text-align: center;"></th>
        <th class="style-none" style="width: 15%;text-align: center;"></th>
        <th class="style-none" style="width: 15%;text-align: center;"></th>
    </tr>
    <tr class="style-none">
        <td class="style-none" colspan="4" style="widtd: 85%; text-align: right;"><strong> SUB TOTAL <?php echo $aux ?>: </strong></td>
        <td class="style-none" style="widtd: 15%; text-align: right;"> <?php echo number_format($subtotal, 2, ',', '.'); ?></td>
    </tr>
    <tr class="style-none">
        <td class="style-none" colspan="4" style="widtd: 85%; text-align: right;"><strong> IVA <?php echo $aux ?>: </strong></td>
        <td class="style-none" style="widtd: 15%; text-align: right;"> <?php echo number_format($data['impuesto'], 2, ',', '.'); ?></td>
    </tr>
    <tr class="style-none">
        <td class="style-none" colspan="4" style="widtd: 85%; text-align: right;"><strong> TOTAL COMPRA <?php echo $aux ?>:</strong></td>
        <td class="style-none" style="widtd: 15%; text-align: right;"> <?php echo number_format($subtotal + $data['impuesto'], 2, ',', '.'); ?></td>
    </tr>
</table>