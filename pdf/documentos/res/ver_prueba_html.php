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
	if ($row = $sql->fetch_array())
	{
		$cod_fiscal = $row['codigo_fiscal'];
		$moneda = $row['moneda'];
		$impuesto = $row['impuesto'];

	}
	$sql2 = $con->query("SELECT *from conf_factura");
	if ($row2 = $sql2->fetch_array())
	{
		$observacion = $row2['observacion'];

	}

?>
	
	    <table cellspacing="3" style="width: 100%; font-size: 8pt;">   
	        <tr>
	        	<td  style="width: 80%;"><strong >NOMBRE Y <br> RAZON SOCIAL:&nbsp; </strong>Nombre del cliente</td>      	
				<td style="width: 20%;"><strong >FECHA:&nbsp; </strong> 12/12/12 </td>		
		    </tr>
		</table>

		<table cellspacing="3" style="width: 100%; text-align: left; font-size: 8pt;">
			<tr>
				<td style="width: 50%;"> <strong ><?php echo $cod_fiscal ?>:&nbsp;</strong>J-123456789-0</td>
				<td style="width: 30%;"> <strong >TELEFONO:&nbsp;</strong>555-55555</td>
				<td style="width: 20%;"> <strong >NRO. FACT:&nbsp;</strong>000000</td>
			</tr>		
		</table>

		<table cellspacing="3" style="text-align: left; font-size: 8pt;">
			<tr>
				<td style="width: 100%;"> <strong > DIRECCION <br> FISCAL:&nbsp;</strong>Calle Santa Isabel con Av. Florencio</td>
			</tr>
			<tr>
				<td><strong>CONDICION:&nbsp;</strong>
				Condición
				</td>
			</tr>
		</table>		
    
    <br>

     <table cellspacing="0" style="width: 100%; text-align: left; font-size: 9pt;">
        <tr>
            <th style="width: 10%;text-align:center;" >CANTIDAD</th>
            <th style="width: 40%;text-align: center;">DESCRIPCION</th>
            <th style="width: 10%;text-align: center;">UND</th>
            <th style="width: 15%;text-align: right;">PRECIO</th>
            <th style="width: 15%;text-align: right;">TOTAL</th>
            
        </tr>
    </table>
    <hr>
        
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 9pt;">    
        <tr>
            <th style="width: 10%;text-align:center;" ></th>
            <th style="width: 40%;text-align: center;" ></th>
            <th style="width: 10%;text-align: center;" ></th>
            <th style="width: 15%;text-align: center;" ></th>
            <th style="width: 15%;text-align: center;" ></th>
            
        </tr>
        <?php for ($i=1; $i<11; $i++) {?>   
	        <tr>
	            <td style=" text-align: center;">1</td>
	            <td style=" width: 40%; max-width: 40%; overflow: hidden; text-align: left;">Un producto</td>
	            <td style=" text-align: center;">Unid.</td>
	            <td style=" text-align: right;">1000.00</td>
	            <td style=" text-align: right;">1000.00</td>
	            
	        </tr>
	  <?php } ?>      
	  </table>
	  <hr>

	  <table cellspacing="3" style="width: 100%; font-size: 9pt;">

	        <tr>
	        	<td style="width: 80%; text-align: left; font-size: 7pt; max-width: 80%; overflow: hidden;"><strong>OBSERVACION: <?php echo $observacion; ?></strong></td>
	            <td colspan="3" style="text-align: right;"><strong> SUBTOTAL: </strong></td>
	            <td style="text-align: right;">10,000.00</td>
	        </tr>
			<tr>
				<td style="width: 80%;"></td>
	            <td colspan="3" style=" text-align: right;"><strong> IVA 12%</strong></td>
	            <td style=" text-align: right;">1200.00</td>
	        </tr>


	        <tr>
	        	<td style="width: 80%;"></td>
	            <td colspan="3" style=" text-align: right;"><strong> TOTAL:</strong></td>
	            <td style=" text-align: right;">11,200.00</td>
	        </tr>
	  </table>
	
	  

</page>