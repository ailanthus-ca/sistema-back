<br><br>
<div style="text-align: left;">
    <span style="font-size:10px;font-weight:bold"><strong>DATOS DEL CLIENTE</strong></span>
</div>
<table class="style-none" border="0" cellspacing="3" style="width: 100%; font-size: 7pt;">
    <tr  class="style-none">
        <td  class="style-none" style="width: 100%;">	
            <table cellspacing="3" style="width: 100%; font-size: 7pt;">   
                <tr  class="style-none">
                    <td  class="style-none"  style="width: 82%;"><strong style="font-size: 7pt;">NOMBRE:&nbsp; </strong> <?php echo $data['nombre'] ?></td>      	
                    <td  class="style-none" style="width: 20%;"><strong style="font-size: 7pt;">FECHA:&nbsp; </strong> <?php echo $fecha->format('d/m/Y'); ?> </td>		
                </tr>
            </table>

            <table cellspacing="3" style="width: 100%; text-align: left; font-size: 7pt;">
                <tr  class="style-none">
                    <td  class="style-none" style="width: 82%;"> <strong style="font-size: 7pt;"><?php echo $region['cod_fiscal'] ?>:&nbsp;</strong> <?php echo $data["cod_cliente"] ?></td>
                    <td  class="style-none" style="width: 20%;"> <strong style="font-size: 7pt;">NOTA DE ENTREGA N°:&nbsp;</strong> <?php echo $data['codigo'] ?> </td>
                </tr>
                <tr  class="style-none">
                    <td  class="style-none" style="width: 30%;"> <strong style="font-size: 7pt;">TELEFONO:&nbsp;</strong><?php echo $data["telefono"] ?> </td>
                </tr>		
            </table>

            <table cellspacing="3" style="text-align: left; font-size: 7pt;">
                <tr  class="style-none">
                    <td  class="style-none" style="width: 30%;"> <strong style="font-size: 7pt;">DIRECCIÓN:&nbsp;</strong><?php echo $data["direccion"] ?> </td>				
                </tr>
                <tr  class="style-none">
                    <td  class="style-none" style="width: 30%;"> <strong style="font-size: 7pt;">CONTACTO:&nbsp;</strong><?php echo $data["contacto"] ?> </td>
                </tr>
            </table>
        </td>	
    </tr>	
</table>
<hr><br><br>			
<div style="text-align: center;">
    <span style="color: #34495e;font-size:14px;font-weight:bold"><strong>NOTA DE ENTREGA</strong></span>
</div>
<br><br>
<table  class="border-clasico" border="1" cellspacing="0" style="width: 100%; text-align: left; font-size: 7pt;">    
    <tr  class="border-clasico">
        <th  class="border-clasico" style="width: 10%;text-align:center;" >CANTIDAD</th>
        <th  class="border-clasico" style="width: <?php echo ($precios) ? 51 : 70 ?>%;text-align: center;">DESCRIPCION</th>
        <th  class="border-clasico" style="width: 10%;text-align: center;">UND</th>
        <?php if ($precios) { ?>
            <th  class="border-clasico" style="width: 15%;text-align: center;">PRECIO</th>
            <th  class="border-clasico" style="width: 15%;text-align: center;">TOTAL</th>
        <?php } ?>
    </tr>
    <?php
    $subtotal = 0;
    foreach ($data['detalles'] as $pro) {
        $subtotal += $pro['unidades'] * $pro['precio'];
        ?><tr  class="border-clasico">
            <td  class="border-clasico" style=" text-align: center; height: 15px; vertical-align: middle;"><?php echo $pro['unidades']; ?></td>
            <td  class="border-clasico" style=" width: <?php echo ($precios) ? 51 : 80 ?>%; max-width: <?php echo ($precios) ? 51 : 70 ?>%; overflow: hidden; text-align: left; height: 15px; vertical-align: middle;"><?php echo $pro['descripcion']; ?></td>
            <td  class="border-clasico" style=" text-align: center; height: 15px; vertical-align: middle;;"><?php echo $pro['medida']; ?></td>
            <?php if ($precios) { ?>
                <td  class="border-clasico" style=" text-align: right; height: 15px; vertical-align: middle;"><?php echo number_format($pro['precio'], 2, ',', '.'); ?></td>
                <td  class="border-clasico" style=" text-align: right; height: 15px; vertical-align: middle;"><?php echo number_format($pro['unidades'] * $pro['precio'], 2, ',', '.'); ?></td>
            <?php } ?>
        </tr><?php } ?>
</table>           
<?php if ($precios) { ?>
    <table cellspacing="3" style="width: 100%; font-size: 7pt;">
        <tr  class="style-none">
            <th  class="style-none" style="width: 10%;text-align:center;"></th>
            <th  class="style-none" style="width: 50%; text-align: center;"></th>
            <th  class="style-none" style="width: 10%;text-align: center;"></th>
            <th  class="style-none" style="width: 15%;text-align: center;"></th>
            <th  class="style-none" style="width: 15%;text-align: center;"></th>
        </tr>
        <tr  class="style-none">
            <td  class="style-none" colspan="4" style=" text-align: right;"><strong> TOTAL: </strong></td>
            <td  class="style-none" style="widtd: 15%; text-align: right;"> <?php echo number_format($subtotal, 2, ',', '.'); ?></td>
        </tr>
    </table>
<?php } ?>
<br>
<div style="text-align: left;">
    <span style="font-size:10px;font-weight:bold"><strong>CONDICIONES</strong></span>
</div>	
<table border="1" cellspacing="0" style="width: 100%; font-size: 7pt;">
    <tr  class="style-none">
        <td  class="style-none" style="width: 100%;">	
            <table cellspacing="3" style="width: 100%; font-size: 7pt;"> 		 
                <tr  class="style-none">
                    <td  class="style-none"  style="width: 80%;"><strong style="font-size: 7pt;">NOTA:&nbsp; </strong><?php echo $data['nota']; ?></td> 
                </tr>      	
            </table>
        </td>
    </tr>	
</table>
<br>
<table cellspacing="3" style="width: 100%; font-size: 7pt;">		  
    <tr  class="style-none">
        <td  class="style-none" style="width: 80%">
            <strong>Atentamente: <?php echo $data['usuario'] ?></strong>
        </td>
    </tr>
</table>