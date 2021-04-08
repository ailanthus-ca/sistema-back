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

<page >

<!--Encabezado de la empresa-->
<!--traer informacion de la empresa desde la base de datos--> 
<?php 
		$sql = $con->query("SELECT *FROM conf_empresa");
		$fila = $sql->fetch_array();

		include 'encabezado.php';

?>

<hr>
<br>

<!--Titulo del reporte-->
<div style="text-align: center;">
	<span style="color: #34495e;font-size:14px;font-weight:bold"><strong>REPORTE DE SEGUIMIENTO DE COMPRAS</strong></span>
</div>
<br>
<br>
<?php  
	$query = $con->query($query_prod);
	if ($row = mysqli_fetch_array($query))
		{
			$nombre = $row['descripcion'];
			$cod = $row['codigo'];
		}
?>

<span><strong>Producto:</strong> &nbsp; <?php echo $nombre ?> </span> <br>
<span><strong>Codigo:</strong> &nbsp; &nbsp; &nbsp; <?php echo $cod ?> </span> <br>
<br>
<br>
<br>

<table  cellspacing="5" style="width: 100%; font-size: 10pt";>
	<tr>
		<th style="width: 5%;">Fecha</th>
		<th style="width: 5%;">Proveedor</th>
		<th style="width: 9%;">Monto</th>
		
	</tr>	

<?php
	$query = $con->query($query_seg);
	while($row =  mysqli_fetch_array($query))
	{
		$fecha=date_create($row['fecha_compra']);
		$fecha = date_format($fecha, 'd-m-Y');
	    $proveedor=$row['proveedor'];
	    $monto=$row['monto'];

		$motno_f=number_format($monto,2);//Formateo variables
		$monto_r=str_replace(",","",$motno_f);//Reemplazo las comas	
?>
		
			<tr>
				<td style="width: 20%"><?php echo $fecha ?></td>
				<td style="width: 60%"><?php echo $proveedor ?></td>
				<td style="width: 20%"><?php echo number_format($monto_r,2,',','.')  ?></td>
			</tr>

<?php
 	} 
 ?>

</table>  

<!--Pie de pagina del reporte-->
<page_footer backtop="20">
<hr>
	<div class="row" style="text-align: center; font-size: 10px;">
		<span> <?php echo $fila['direccion']; ?> </span>
	</div>
	<div class="row" style="text-align: center; font-size: 10px;">
		<span><?php echo $fila['telefono']; ?></span>	
	</div>
	<div class="row" style="text-align: center;font-weight:bold; font-size: 10px;">
		<span><?php echo $fila['web']; ?></span>	
	</div>	
</page_footer>		  

</page>

<?php

	mysqli_close($con);
?>