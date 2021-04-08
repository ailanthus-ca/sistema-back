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
   		$sql = $con->query("SELECT *FROM conf_empresa");
   		$fila = $sql->fetch_array();

   		include 'encabezado.php';
    ?>

	<?php  
		$sql = $con->query("SELECT *from conf_region");
		if ($row = $sql->fetch_array())
		{
			$cod_fiscal = $row['codigo_fiscal'];
			$moneda = $row['moneda'];
			$impuesto = $row['impuesto'];
		}
	?>       
   		<hr>			
    
	<?php 
		$sql_proveedor=$con->query("select * from proveedor where codigo='$id_proveedor'");
		$rw_proveedor=mysqli_fetch_array($sql_proveedor);


	?>	
		<h5>DATOS DEL PROVEEDOR</h5>
		
	    <table cellspacing="3" style="width: 100%; font-size: 7pt;">    
	        <tr>
	        	<td  style="width: 80%;"><strong style="font-size: 7pt;">NOMBRE Y <br> RAZON SOCIAL: &nbsp; </strong> <?php echo $rw_proveedor['nombre']; ?></td>        	
				<td style="width: 20%;"><strong style="font-size: 7pt;">FECHA: &nbsp; </strong> <?php echo date("d/m/Y"); ?></td>			
			</tr>
		</table>

		<table cellspacing="3" style="width: 100%; text-align: left; font-size: 7pt;">
			<tr>
				<td style="width: 80%;"> <strong style="font-size: 7pt;">R.I.F:&nbsp;</strong> <?php echo $rw_proveedor["codigo"]; ?></td>
				<td style="width: 30%;"> <strong style="font-size: 7pt;">TELEFONO:&nbsp;</strong><?php echo $rw_proveedor["telefono"]; ?></td>
			</tr>		
		</table>

		<table cellspacing="3" style="text-align: left; font-size: 7pt;">
			<tr>
				<td style="width: 100%;"> <strong style="font-size: 7pt;">DIRECCION <br> FISCAL:&nbsp;</strong><?php echo $rw_proveedor['direccion']; ?> </td>
			</tr>
		</table>

		<h5>DATOS DE LA ORDEN</h5>	

    
    <br>
     <table cellspacing="0" style="width: 100%; text-align: left; font-size: 7pt;">
        <tr>
            <th style="width: 10%;text-align:center;" >CANTIDAD</th>
            <th style="width: 40%;text-align: center;">DESCRIPCION</th>
            <th style="width: 10%;text-align: center;">UND</th>
            <th style="width: 15%;text-align: center;">PRECIO</th>
            <th style="width: 15%;text-align: center;">TOTAL</th>
            
        </tr>
    </table>
    <hr>
        
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 7pt;">    
        <tr>
            <th style="width: 10%;text-align: center;" ></th>
            <th style="width: 40%;text-align: center;" ></th>
            <th style="width: 10%;text-align: center;" ></th>
            <th style="width: 15%;text-align: center;" ></th>
            <th style="width: 15%;text-align: center;" ></th>
            
        </tr>    
		<?php
			$nums=1;
			$sumador_total=0;
			$sql=$con->query("SELECT precio_unit, detalleordencompra.cod_producto AS cod_producto, detalleordencompra.cantidad AS cantidad, 				descripcion, unidad, monto 
								FROM detalleordencompra, producto
								WHERE detalleordencompra.cod_producto = producto.codigo 
								AND cod_orden = $cod_orden");

			while ($row=$sql->fetch_array())
				{
					$id_producto=$row["cod_producto"];
					$cantidad=$row['cantidad'];
					$nombre_producto=$row['descripcion'];
					$unidad = $row['unidad'];
					
					$precio_venta=$row['precio_unit'];
					$precio_venta_f=number_format($precio_venta,2);//Formateo variables
					$precio_venta_r=str_replace(",","",$precio_venta_f);//Reemplazo las comas
					
					$precio_total=$row['monto'];
					$precio_total_f=number_format($precio_total,2);//Precio total formateado
					$precio_total_r=str_replace(",","",$precio_total_f);//Reemplazo las comas
					//$sumador_total+=$precio_total_r;//Sumador
				
		?>

	        <tr>
	            <td style=" text-align: center;"><?php echo $cantidad; ?></td>
	            <td style=" width: 40%; max-width: 40%; overflow: hidden; text-align: left;"><?php echo $nombre_producto;?></td>
	            <td style=" text-align: center;"><?php echo $unidad; ?></td>
	            <td style=" text-align: right;"><?php echo number_format($precio_venta_r,2,',','.');?></td>
	            <td style=" text-align: right;"><?php echo number_format($precio_total_r,2,',','.');?></td>
	            
	        </tr>

		<?php 

			
					$nums++;
				}

			$sqltotal = $con->query("SELECT *from ordencompra WHERE codigo = '$cod_orden'");
			if ($rowt = mysqli_fetch_array($sqltotal))
			{
				$subtotal = $rowt['subtotal'];	
				$subtotal=number_format($subtotal,2,'.','');

				$impuesto = $rowt['impuesto'];
				$total_iva=number_format($impuesto,2,'.','');

				$total = $rowt['total'];
				$total_compra=number_format($total,2,'.','');
			}		
		?>


	  </table>
	  <hr>

	  <table cellspacing="3" style="width: 100%; font-size: 7pt;">

	    <tr>
            <th style="width: 10%;text-align:center;"></th>
            <th style="width: 40%; text-align: center;"></th>
            <th style="width: 25%;text-align: center;"></th>
            <th style="width: 15%;text-align: center;"></th>
            <th style="width: 15%;text-align: center;"></th>
            
        </tr>

	        <tr>
	            <td colspan="3" style="widtd: 85%; text-align: right;"><strong> SUB TOTAL: </strong></td>
	            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($subtotal,2,',','.');?></td>
	        </tr>
			<tr>
	            <td colspan="3" style="widtd: 85%; text-align: right;"><strong> IVA <?php echo $impuesto; echo "% SOBRE "; echo number_format($subtotal,2,',','.'); ?>: </strong></td>
	            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($total_iva,2,',','.');?></td>
	        </tr><tr>
	            <td colspan="3" style="widtd: 85%; text-align: right;"><strong> TOTAL COMPRA:</strong></td>
	            <td style="widtd: 15%; text-align: right;"> <?php echo number_format($total_compra,2,',','.');?></td>
	        </tr>
    
       </table>


</page>

<?php
/*
	//crear nueva compra
	
	$fechaHoy=date("Y-m-d");
	$fecha_documento = date("Y-m-d", strtotime($fecha));


	$sql = $con->query("INSERT INTO ordencompra VALUES ('$cod_orden','$id_proveedor','$fechaHoy',$subtotal,$total_compra,1)");


	$sql=$con->query("select * from tmp");
			while ($row=$sql->fetch_array())
			 {
			 	$con->query("INSERT INTO detalleordencompra VALUES ('$cod_orden','".$row['id_producto']."','".$row['cantidad_tmp']."', '".$row['precio_tmp']."', '".$row['precio_tmp']*$row['cantidad_tmp']."') ");
			 } 
	//reinicia la tabla temporal
	$con->query("TRUNCATE TABLE tmp");

	mysqli_close($con);
*/	
?>