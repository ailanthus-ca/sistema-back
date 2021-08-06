<div style="text-align: left;">
    <span style="font-size:10px;font-weight:bold"><strong>DATOS DEL CLIENTE</strong></span>
</div>
<table class="style-none" border="0" cellspacing="3" style="width: 100%; font-size: 7pt;">
    <tr class="style-none">
        <td  class="style-none"style="width: 100%;">	
            <table class="style-none" cellspacing="3" style="width: 100%; font-size: 7pt;">   
                <tr class="style-none">
                    <td class="style-none" style="width: 82%;"><strong style="font-size: 7pt;">NOMBRE:&nbsp; </strong> <?php echo $data['nombre'] ?></td>      	
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
                    <td class="style-none" style="width: 30%;"> <strong style="font-size: 7pt;">ATENCIÓN:&nbsp;</strong><?php echo $data["contacto"] ?> </td>
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
<table class="border-clasico" border="1" cellspacing="0" style="width: 100%; text-align: left; font-size: 7pt;">    
    <tr>
        <th class="border-clasico" style="width: 10%;text-align:center;" >CODIGO</th>
        <th class="border-clasico" style="width: 40%;text-align: center;">DESCRIPCION</th>
        <th class="border-clasico" style="width: 10%;text-align: center;">UND</th>
        <th class="border-clasico" style="width: 10%;text-align:center;" >CANT</th>
        <th class="border-clasico" style="width: 15%;text-align: center;">PRECIO</th>
        <th class="border-clasico" style="width: 15%;text-align: center;">TOTAL</th>
    </tr>
    <?php
    $subtotal = 0;
    foreach ($data['detalles'] as $pro) {
        $subtotal += $pro['unidades'] * $pro['precio']; //Reemplazo las comas
        ?>
        <tr class="border-clasico">
            <td class="border-clasico" style=" width: 10%; text-align: center; height: 15px; vertical-align: middle;"><?php echo $pro['codigo']; ?></td>
            <td class="border-clasico" style=" width: 40%; max-width: 40%; overflow: hidden; text-align: left; height: 15px; vertical-align: middle;"><?php echo $pro['descripcion']; ?></td>
            <td class="border-clasico" style=" width: 10%; text-align: center; height: 15px; vertical-align: middle;"><?php echo $pro['medida']; ?></td>
            <td class="border-clasico" style=" width: 10%; text-align: center; height: 15px; vertical-align: middle;"><?php echo $pro['unidades']; ?></td>
            <td class="border-clasico" style=" width: 15%; text-align: right; height: 15px; vertical-align: middle;"><?php echo number_format($pro['precio'], 2, ',', '.'); ?></td>
            <td class="border-clasico" style=" width: 15%; text-align: right; height: 15px; vertical-align: middle;"><?php echo number_format($pro['unidades'] * $pro['precio'], 2, ',', '.'); ?></td>
        </tr>
        <?php
    }
    ?>
</table>
<!--<hr>-->
<table class="style-none" cellspacing="3" style="width: 100%; font-size: 7pt;">
    <tr class="style-none">
        <td class="style-none" style="height: 10px; width: 60%;text-align: center;"></td>
        <td class="style-none" style="height: 10px; width: 25%;text-align: right;"><strong> SUB TOTAL <?php echo $region['moneda']; ?>: </strong></td>
        <td class="style-none" style="height: 10px; width: 15%;text-align: right;"><?php echo number_format($subtotal, 2, ',', '.'); ?></td>
    </tr>
    <tr class="style-none">
        <td class="style-none" style="height: 10px; width: 60%;text-align: left; font-size: 5pt; padding-left: 80px;"><?php echo $ventas['observacion']; ?></td>
        <td class="style-none" style="height: 10px; width: 25%;text-align: right;"><strong> IMPUESTO <?php echo $region['impuesto'] . "% " . $region['moneda']; ?>: </strong></td>
        <td class="style-none" style="height: 10px; width: 15%;text-align: right;"><?php echo number_format($subtotal * $region['impuesto'] / 100, 2, ',', '.'); ?></td>
    </tr>
    <tr class="style-none">
        <td class="style-none" style="height: 10px; width: 60%;text-align: center;"></td>
        <td class="style-none" style="height: 10px; width: 25%;text-align: right;"><strong> TOTAL <?php echo $region['moneda']; ?>:</strong></td>
        <td class="style-none" style="height: 10px; width: 15%;text-align: right;"><?php echo number_format($subtotal * (1 + $region['impuesto'] / 100), 2, ',', '.'); ?></td>
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
                    <td class="style-none" style="width: 80%;"><strong style="font-size: 7pt;">FORMA DE PAGO:&nbsp; </strong> <?php echo $data['forma_pago'] ?></td>      	
                </tr>
                <tr>
                    <td class="style-none" style="width: 80%;"><strong style="font-size: 7pt;">VALIDEZ DE LA OFERTA:&nbsp; </strong> <?php echo $data['validez'] ?></td>      	
                </tr>
                <tr>
                    <td class="style-none" style="width: 80%;"><strong style="font-size: 7pt;">TIEMPO DE ENTREGA:&nbsp; </strong> <?php echo $data['tiempo_entrega'] ?></td>      	
                </tr>		    
                <tr>
                    <td class="style-none" style="width: 100%;"><strong style="font-size: 7pt;">DATOS DEL PAGO:&nbsp; </strong> <?php echo $company['pago'] ?></td>      	
                </tr>
                <tr>
                    <td class="style-none" style="width: 80%;"><strong style="font-size: 7pt;">GARANTIA DEL EQUIPO:&nbsp; </strong><?php echo $ventas['garantia']; ?></td> 
                </tr>
                <tr>
                    <td class="style-none" style="width: 80%;"><strong style="font-size: 7pt;">NOTA:&nbsp; </strong><?php echo $data['nota']; ?></td> 
                </tr>      	
            </table>
        </td>
    </tr>	
</table>
<br>
<table class="style-none" cellspacing="3" style="width: 100%; font-size: 7pt;">		  
    <tr class="style-none">
        <td class="style-none" style="width: 80%">
            <strong>Atentamente: <?php printf($_SESSION['usuario']) ?></strong>
        </td>
    </tr>
</table>