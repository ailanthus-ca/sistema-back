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
		$sql  = $con->query("SELECT *FROM conf_empresa");
		$fila = $sql->fetch_array();

		include 'encabezado.php';

?>

<hr>
<br>
<!--Titulo del reporte-->
<div style="text-align: center;">
    <span style="color: #34495e;font-size:14px;font-weight:bold"><strong>VENDEDOR: </strong></span>
    <span style="color: #34495e;font-size:14px;font-weight:bold"><strong><?php echo $vendedor ?></strong></span><br>
	<span style="color: #34495e;font-size:14px;font-weight:bold"><strong>REPORTE DE VENTAS</strong></span>
    <span style="color: #34495e;font-size:14px;font-weight:bold"><strong><?php echo $titulo ?></strong></span><br>
</div>
<br>
<br>

<table cellspacing="5" style="width: 300%; font-size: 10pt;" width="800">
	<tr>
		<th width="100" style="width: 9%; text-align: center;">Factura</th>
		<th width="300" style="width: 9%;">Cliente</th>
		<th width="100" style="width: 9%;">Fecha</th>
		<th width="100" style="width: 9%; text-align: right;">Total</th>
	</tr>	

<?php
$sql  = $con->query($query);
$todo = 0;
while($row =  $sql->fetch_array())
{
    $cod=$row['codigo'];
    $nombre = $row['nombre'];

    $fecha =date_create($row['fecha']);
    $fecha =date_format($fecha,'d-m-Y');

    $total = $row['total'];
    $todo = $todo + $total;
    $total = number_format($total,2,".",".");
?>
		
			<tr>
				<td width="100"><?php echo $cod    ?></td>
				<td width="300"><?php echo $nombre ?></td>
				<td width="100" ><?php echo $fecha  ?></td>
				<td width="150" style="text-align: right;"><?php echo $total  ?></td>
			</tr>

<?php
 	}
$todo = number_format($todo,2,".",".");
 ?>
    <tr>
        <th style="width: 9%;text-align: right;"></th>
        <th style="width: 9%;text-align: right;"></th>
        <th style="width: 9%;text-align: right;">Total Facturado</th>
        <td style="text-align: right;"><?php echo $todo  ?></td>
    </tr>

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