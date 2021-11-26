<?php $subtotal = 0; ?>
<div class="col-12">
    <span style="font-size:10px;font-weight:bold;color: #34495e;"><strong>DATOS DEL CLIENTE</strong></span>
</div><br/>
<div class="col-12 bordered">
    <div class="col-10">
        <strong>NOMBRE:&nbsp; </strong> <?php echo $data['nombre'] ?>
    </div>
    <div class="col-2" style="text-align: right">
        <strong><?php echo $region['cod_fiscal'] ?>:&nbsp;</strong> <?php echo $data["cod_cliente"] ?>
    </div><br/>
    <div class="col-4">
        <strong>CONTACTO:&nbsp;</strong><?php echo $data["contacto"] ?>
    </div>
    <div class="col-3" style="text-align: center">
        <strong>TELEFONO:&nbsp;</strong><?php echo $data["telefono"] ?>
    </div>
    <div class="col-5" style="text-align: right">
        <strong>CORREO:&nbsp;</strong><?php echo $data["correo"] ?>
    </div><br/>
    <div class="col-12">
        <strong>DIRECCIÓN:&nbsp;</strong><?php echo $data["direccion"] ?>
    </div>
</div><br/><br/>
<!--Titulo del reporte-->
<div class="col-12" style="text-align: center;">
    <span style="color: #34495e;font-size:14px;font-weight:bold"><strong>COTIZACION N.  <?php echo str_pad($data['codigo'], 6, "0", STR_PAD_LEFT) ?></strong></span>
</div><br>
<div class="col-12 bordered"  >
    <div class="col-10">
        <strong>ATENCION:&nbsp;</strong><?php echo $data["usuario"] ?>
    </div>
    <div class="col-2" style="text-align: right">
        <strong >FECHA:&nbsp; </strong> <?php echo $fecha->format('d/m/Y'); ?>
    </div>
</div><br/><br/>

<table cellspacing="0"> 
    <thead>
        <tr>
            <th class="col-1" style="text-align: center;">COD</th>
            <th class="col-5" style="text-align: center;">DESCRIPCION</th>
            <th class="col-1" style="text-align: center;">UND</th>
            <th class="col-1" style="text-align:center;" >CANT</th>
            <th class="col-2" style="text-align: center;">PRECIO <?php echo $aux ?></th>
            <th class="col-2" style="text-align: center;">TOTAL <?php echo $aux ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($data['detalles'] as $pro) {
            $subtotal += $pro['unidades'] * $pro['precio'];
            ?><tr>
                <td class="col-1" style=" text-align: center; ;"><?php echo $pro['codigo']; ?></td>
                <td class="col-5" style=" width: 40%; max-width: 40%; overflow: hidden; text-align: left; "><?php echo $pro['descripcion']; ?></td>
                <td class="col-1" style=" text-align: center; ;"><?php echo $pro['medida']; ?></td>
                <td class="col-1" style=" text-align: center; "><?php echo $pro['unidades']; ?></td>
                <td class="col-2" style=" text-align: right; "><?php echo number_format($pro['precio'], 2, ',', '.'); ?></td>
                <td class="col-2" style=" text-align: right;"><?php echo number_format($pro['unidades'] * $pro['precio'], 2, ',', '.'); ?></td>
            </tr><?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" rowspan="3" class="condiciones">
                <div class="col-8" style="padding-bottom: 2px;padding-top: 2px">
                    <strong>GARANTIA DE LOS PRODUCTOS:&nbsp; </strong>
                     <?php echo $ventas['garantia'] ?>    
                </div><br/><br/>
                <div class="col-8" style="padding-bottom: 2px;padding-top: 2px">
                    <strong>OBSERVACION GENERAL:&nbsp; </strong>
                     <?php echo $ventas['observacion'] ?>    
                </div><br/>
            </td>            
            <td style="text-align: right; "><strong> SUB TOTAL <?php echo $aux ?>: </strong></td>
            <td style="text-align: right; "> <?php echo number_format($subtotal, 2, ',', '.'); ?></td>
        </tr>
        <tr>
            <td style="text-align: right; "><strong> IVA <?php echo $region['impuesto']; ?>% <?php echo $aux ?>: </strong></td>
            <td style="text-align: right; "> <?php echo number_format($subtotal * $region['impuesto'] / 100, 2, ',', '.'); ?></td>
        </tr><tr>
            <td style="text-align: right; "><strong> TOTAL <?php echo $aux ?>:</strong></td>
            <td style="text-align: right; "> <?php echo number_format($subtotal * (1 + $region['impuesto'] / 100), 2, ',', '.'); ?></td>
        </tr>
    </tfoot>
</table>
<br/><br/>
<div class="col-12">
    <span style="font-size:10px;font-weight:bold;color: #34495e;"><strong>CONDICIONES</strong></span>
</div><br/>
<div class="col-12 bordered">
    <div class="col-12" style="padding-bottom: 2px;padding-top: 2px">
        <strong>FORMA DE PAGO:&nbsp; </strong> <?php echo $data['forma_pago'] ?>    
    </div><br/>
    <div class="col-12" style="padding-bottom: 2px;padding-top: 2px">
        <strong>VALIDEZ DE LA OFERTA:&nbsp; </strong> <?php echo $data['validez'] ?>    
    </div><br/>
    <div class="col-12" style="padding-bottom: 2px;padding-top: 2px">
        <strong>TIEMPO DE ENTREGA:&nbsp; </strong> <?php echo $data['tiempo_entrega'] ?>    
    </div><br/>
    <div class="col-12" style="padding-bottom: 2px;padding-top: 2px">
        <strong>DATOS DE PAGO:&nbsp; </strong> <?php echo $company['pago'] ?>    
    </div><br/>
    <div class="col-12" style="padding-bottom: 2px;padding-top: 2px">
        <strong>NOTA:&nbsp; </strong><?php echo $data['nota']; ?>
    </div>
</div>
