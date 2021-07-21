<br/><br/>
<div style="text-align: left;">
    <span style="font-size:10px;font-weight:bold"><strong>DATOS DEL CLIENTE</strong></span>
</div>
<table class="style-none" border="0" cellspacing="3" style="width: 100%; font-size: 7pt;">
    <tr  class="style-none">
        <td class="style-none" style="width: 100%;">
            <table class="style-none" cellspacing="3" style="width: 100%; font-size: 7pt;">
                <tr class="style-none">
                    <td class="style-none"  style="width: 82%;"><strong style="font-size: 7pt;">NOMBRE:&nbsp; </strong> <?php echo $data['nombre'] ?></td>  	
                    <td class="style-none" style="width: 20%;"><strong style="font-size: 7pt;">FECHA:&nbsp; </strong> <?php echo $fecha->format('d/m/Y'); ?> </td>	
                </tr>
            </table>
            <table class="style-none" cellspacing="3" style="width: 100%; text-align: left; font-size: 7pt;">
                <tr class="style-none">
                    <td class="style-none" style="width: 82%;"> <strong style="font-size: 7pt;"><?php echo $region['cod_fiscal'] ?>:&nbsp;</strong> <?php echo $data["cod_cliente"] ?></td>
                    <td class="style-none" style="width: 20%;"> <strong style="font-size: 7pt;">NRO. COT:&nbsp;</strong> <?php echo $data['codigo'] ?> </td>
                </tr>
                <tr class="style-none">
                    <td class="style-none" style="width: 30%;"> <strong style="font-size: 7pt;">TELEFONO:&nbsp;</strong><?php echo $data["telefono"] ?> </td>
                </tr>		
            </table>
            <table class="style-none" cellspacing="3" style="text-align: left; font-size: 7pt;">
                <tr class="style-none">
                    <td class="style-none" style="width: 30%;"> <strong style="font-size: 7pt;">DIRECCIÓN:&nbsp;</strong><?php echo $data["direccion"] ?> </td>				
                </tr>
                <tr class="style-none">
                    <td class="style-none" style="width: 30%;"> <strong style="font-size: 7pt;">CONTACTO:&nbsp;</strong><?php echo $data["contacto"] ?> </td>
                </tr>
            </table>
        </td>	
    </tr>	
</table>
<br/>
<div style="text-align: center;">
    <span style="color: #34495e;font-size:14px;font-weight:bold"><strong>C O T I Z A C I O N</strong></span>
</div>
<hr>
<br/>
<br/>				
<div style="text-align: left;">
    <span style="font-size:10px;font-weight:bold"><strong>DESCRIPCION DE LA COTIZACION</strong></span>
</div>
<table border="1" cellspacing="0" class="border-clasico" style="width: 100%; text-align: left; font-size: 7pt;">    
    <tr class="border-clasico" >
        <th class="border-clasico" style="width: 10%;text-align:center;" >CANTIDAD</th>
        <th class="border-clasico" style="width: 50%;text-align: center;">DESCRIPCION</th>
        <th class="border-clasico" style="width: 10%;text-align: center;">UND</th>
        <th class="border-clasico" style="width: 15%;text-align: center;">PRECIO</th>
        <th class="border-clasico" style="width: 15%;text-align: center;">TOTAL</th>
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
<table class="style-none"  cellspacing="3" style="width: 100%; font-size: 7pt;">
    <tr class="style-none">
        <th class="style-none" style="width: 10%;text-align:center;"></th>
        <th class="style-none" style="width: 50%; text-align: center;"></th>
        <th class="style-none" style="width: 10%;text-align: center;"></th>
        <th class="style-none" style="width: 15%;text-align: center;"></th>
        <th class="style-none" style="width: 15%;text-align: center;"></th>
    </tr>
    <tr class="style-none">
        <td class="style-none" colspan="4" style="widtd: 85%; text-align: right;"><strong> SUB TOTAL: </strong></td>
        <td class="style-none" style="widtd: 15%; text-align: right;"> <?php echo number_format($subtotal, 2, ',', '.'); ?></td>
    </tr>
    <tr class="style-none">
        <td class="style-none" colspan="4" style="widtd: 85%; text-align: right;"><strong> IVA: </strong></td>
        <td class="style-none" style="widtd: 15%; text-align: right;"> <?php echo number_format($subtotal * $region['impuesto'] / 100, 2, ',', '.'); ?></td>
    </tr>
    <tr class="style-none">
        <td class="style-none" colspan="4" style="widtd: 85%; text-align: right;"><strong> TOTAL:</strong></td>
        <td class="style-none" style="widtd: 15%; text-align: right;"> <?php echo number_format($subtotal * (1 + $region['impuesto'] / 100), 2, ',', '.'); ?></td>
    </tr>
</table>
<br/>
<div style="text-align: left;">
    <span style="font-size:10px;font-weight:bold"><strong>CONDICIONES</strong></span>
</div>
<table class="style-none" border="1" cellspacing="0" style="width: 100%; font-size: 7pt;">
    <tr class="style-none">
        <td class="style-none" style="width: 100%;">	
            <table class="style-none" cellspacing="3" style="width: 100%; font-size: 7pt;">   
                <tr class="style-none">
                    <td class="style-none"  style="width: 80%;"><strong style="font-size: 7pt;">FORMA DE PAGO:&nbsp; </strong> <?php echo $data['forma_pago'] ?></td>      	
                </tr>
                <tr class="style-none">
                    <td class="style-none"  style="width: 80%;"><strong style="font-size: 7pt;">VALIDEZ DE LA OFERTA:&nbsp; </strong> <?php echo $data['validez'] ?></td>      	
                </tr>
                <tr class="style-none">
                    <td class="style-none"  style="width: 80%;"><strong style="font-size: 7pt;">TIEMPO DE ENTREGA:&nbsp; </strong> <?php echo $data['tiempo_entrega'] ?></td>      	
                </tr>	
                <tr class="style-none">
                    <td class="style-none"  style="width: 80%;"><strong style="font-size: 7pt;">DATOS DE PAGO:&nbsp; </strong> <?php echo $company['pago']  ?></td>       
                </tr>   	    
                <tr class="style-none">
                    <td class="style-none"  style="width: 80%;"><strong style="font-size: 7pt;">NOTA:&nbsp; </strong><?php echo $data['nota']; ?></td> 
                </tr>      	
            </table>
        </td>
    </tr>	
</table>
<br/>
<table class="style-none" cellspacing="3" style="width: 100%; font-size: 7pt;">		  
    <tr class="style-none">
        <td class="style-none" style="width: 80%">
            <strong>Atentamente: <?php printf($_SESSION['usuario']) ?></strong>
        </td>
    </tr>
</table>