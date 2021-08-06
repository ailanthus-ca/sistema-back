<div class="style-none" style="text-align: center;">
    <span style="color: #34495e;font-size:14px;font-weight:bold"><strong>NOTA DE ENTREGA</strong></span>
</div>
<div class="style-none" style="text-align: left;">
    <span style="font-size:10px;font-weight:bold"><strong>DATOS DEL CLIENTE</strong></span>
</div>
<table class="style-none" border="0" cellspacing="3" style="width: 100%; font-size: 7pt;">
    <tr class="style-none">
        <td class="style-none" style="width: 100%;">	
            <table class="style-none" cellspacing="3" style="width: 100%; font-size: 7pt;">   
                <tr class="style-none">
                    <td class="style-none" style="width: 82%;"><strong style="font-size: 7pt;">NOMBRE:&nbsp; </strong> <?php echo $data['nombre'] ?></td>      	
                    <td class="style-none" style="width: 20%;"><strong style="font-size: 7pt;">FECHA:&nbsp; </strong> <?php echo $fecha->format('d/m/Y'); ?> </td>		
                </tr>
            </table>
            <table class="style-none" cellspacing="3" style="width: 100%; text-align: left; font-size: 7pt;">
                <tr class="style-none">
                    <td class="style-none" style="width: 82%;"> <strong style="font-size: 7pt;"><?php echo $region['cod_fiscal'] ?>:&nbsp;</strong> <?php echo $data["cod_cliente"] ?></td>
                    <td class="style-none" style="width: 20%;"> <strong style="font-size: 7pt;">NOTA DE ENTREGA N°:&nbsp;</strong> <?php echo $data['codigo'] ?> </td>
                </tr>		
            </table>
            <table class="style-none" cellspacing="3" style="width: 100%; text-align: left; font-size: 7pt;">
                <tr>
                    <td class="style-none" style="width: 30%;"> <strong style="font-size: 7pt;">TELEFONO:&nbsp;</strong><?php echo $data["telefono"] ?> </td>
                    <td class="style-none" style="width: 30%;"> <strong style="font-size: 7pt;">EMAIL:&nbsp;</strong><?php echo $data["correo"] ?> </td>
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
<div class="style-none" style="text-align: left;">
    <span style="font-size:10px;font-weight:bold"><strong>DESCRIPCION</strong></span>
</div>
<table class="border-clasico" border="1" cellspacing="0" style="width: 100%; text-align: left; font-size: 7pt;">    
    <tr class="border-clasico" >
        <th class="border-clasico" style="width: 15%;text-align:center;" >CODIGO</th>
        <th class="border-clasico" style="width: 60%;text-align: center;">DESCRIPCION</th>
        <th class="border-clasico" style="width: 10%;text-align: center;">UND</th>
        <th class="border-clasico" style="width: 15%;text-align: center;">CANTIDAD</th>
    </tr>
    <?php foreach ($data['detalles'] as $pro) { ?><tr class="border-clasico" >
            <td class="border-clasico" style=" text-align: center;width: 15%; height: 15px; vertical-align: middle;"><?php echo $pro['codigo']; ?></td>
            <td class="border-clasico" style=" width: 40%; max-width: 60%; overflow: hidden; text-align: left; height: 15px; vertical-align: middle;"><?php echo $pro['descripcion']; ?></td>
            <td class="border-clasico" style=" text-align: center;width: 15%; height: 15px; vertical-align: middle;"><?php echo $pro['medida']; ?></td>
            <td class="border-clasico" style=" text-align: center;width: 15%; height: 15px; vertical-align: middle;"><?php echo $pro['unidades']; ?></td>
        </tr>
    <?php } ?>
</table>
<br>
<!--Condiciones-->
<div class="style-none" style="text-align: left;">
    <span style="font-size:10px;font-weight:bold"><strong>CONDICIONES</strong></span>
</div>	
<table class="style-none" border="1" cellspacing="0" style="width: 100%; font-size: 7pt;">
    <tr class="style-none">
        <td class="style-none" style="width: 100%;">	
            <table class="style-none" cellspacing="3" style="width: 100%; font-size: 7pt;"> 		    
                <tr class="style-none">
                    <td class="style-none" style="width: 100%;"><strong style="font-size: 7pt;">FORMA DE PAGO:&nbsp; </strong> DE CONTADO</td>      	
                </tr>		    		    
                <tr>
                    <td class="style-none" style="width: 100%;"><strong style="font-size: 7pt;">TIEMPO DE ENTREGA:&nbsp; </strong>INMEDIATA</td>      	
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
            <strong>Atentamente: <?php printf($data['usuario']) ?></strong>
        </td>
    </tr>
</table>