<?php $subtotal = 0; ?>
<div class="col-10">
    <strong>NOMBRE Y RAZON SOCIAL:&nbsp; </strong> <?php echo $data['nombre'] ?>
</div>
<div class="col-2" style="text-align: right">
    <strong><?php echo $region['cod_fiscal'] ?>:&nbsp;</strong> <?php echo $data["cod_cliente"] ?>
</div><br/>
<div class="col-4">
    <strong>CONTACTO:&nbsp;</strong> <?php echo $data["contacto"] ?>
</div>
<div class="col-3" style="text-align: center">
    <strong>TELEFONO:&nbsp;</strong> <?php echo $data["telefono"] ?>
</div>
<div class="col-5" style="text-align: right">
    <strong>CORREO:&nbsp;</strong> <?php echo $data["correo"] ?>
</div><br/>
<div class="col-12">
    <strong>DIRECCION FISCAL:&nbsp;</strong> <?php echo $data["direccion"] ?>
</div>
<div class="col-4">
    <strong>CONDICION:&nbsp;</strong> <?php echo $data["condicion"]; ?>	
</div>
<div class="col-4" style="text-align: center">
    <strong >FECHA:&nbsp; </strong> <?php echo $fecha->format('d/m/Y'); ?>
</div>
<div class="col-4" style="text-align: right">
    <strong >FACTURA:&nbsp;</strong> <?php echo str_pad($data['codigo'], 6, "0", STR_PAD_LEFT) ?>
</div>
<br/>
<table cellspacing="0"> 
    <thead>
        <tr>
            <th class="col-1" style="text-align: center;">COD</th>
            <th class="col-5" style="text-align: center;">DESCRIPCION</th>
            <th class="col-1" style="text-align: center;">UND</th>
            <th class="col-1" style="text-align:center;" >CANT</th>
            <th class="col-2" style="text-align: center;">PRECIO</th>
            <th class="col-2" style="text-align: center;">TOTAL</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($data['detalles'] as $pro) {
            $subtotal += $pro['unidades'] * $pro['precio'];
            ?><tr>
                <td class="col-1" style=" text-align: center;height: 8px ;"><?php echo $pro['codigo']; ?></td>
                <td class="col-5" style=" width: 40%; max-width: 40%; overflow: hidden; text-align: left;height: 8px "><?php echo $pro['descripcion']; ?></td>
                <td class="col-1" style=" text-align: center;height: 8px ;"><?php echo $pro['medida']; ?></td>
                <td class="col-1" style=" text-align: center;height: 8px "><?php echo $pro['unidades']; ?></td>
                <td class="col-2" style=" text-align: right;height: 8px "><?php echo number_format($pro['precio'], 2, ',', '.'); ?></td>
                <td class="col-2" style=" text-align: right;height: 8px"><?php echo number_format($pro['unidades'] * $pro['precio'], 2, ',', '.'); ?></td>
            </tr><?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" rowspan="3" class="col-8 condiciones">
                <strong>OBSERVACION:</strong> <?php echo $data['nota']; ?>
            </td>            
            <td class="col-2" style="text-align: right; height: 8px"><strong> SUB TOTAL: </strong></td>
            <td class="col-2" style="text-align: right;height: 8px "> <?php echo number_format($subtotal, 2, ',', '.'); ?></td>
        </tr>
        <tr>
            <td class="col-2" style="text-align: right;height: 8px "><strong> IVA <?php echo $region['impuesto']; ?>%: </strong></td>
            <td class="col-2" style="text-align: right; height: 8px"> <?php echo number_format($subtotal * $region['impuesto'] / 100, 2, ',', '.'); ?></td>
        </tr><tr>
            <td class="col-2" style="text-align: right; height: 8px"><strong> TOTAL:</strong></td>
            <td class="col-2" style="text-align: right; height: 8px"> <?php echo number_format($subtotal * (1 + $region['impuesto'] / 100), 2, ',', '.'); ?></td>
        </tr>
    </tfoot>
</table>