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
	<span style="color: #34495e;font-size:14px;font-weight:bold"><strong>REPORTE DE VENTAS DE <?php echo $m." ".$ano ?></strong></span>
</div>
<br>

    <table border="0.5" cellspacing="-0.1" width="800">
	<tr>
		<th style="width: 9%; text-align: left;"">codigo</th>
		<th style="width: 9%;">Descripcion</th>
        <th style="width: 9%; text-align: right;"">Cantidad</th>
		<th style="width: 9%; text-align: right;"">Monto</th>
		
	</tr>	

<?php


	$sql = $con->query($query);
	while($row =  $sql->fetch_array())
	{
	    $cod  = $row['codigo'];
	    $desc =$row['descripcion'];
	    $cant = $row['cantidad'];
	    $monto=$row['monto'];

		$total = number_format($monto,2,",",".");
?>

			<tr>
				<td width="80"><?php echo $cod   ?></td>
				<td width="350"><?php echo $desc  ?></td>
                <td width="100" align="right"><?php echo $cant  ?></td>
                <td width="150" align="right"><?php echo $total ?></td>
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