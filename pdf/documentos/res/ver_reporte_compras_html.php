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
	<span style="color: #34495e;font-size:14px;font-weight:bold"><strong>REPORTE DE COMPRAS</strong></span>
    <span style="color: #34495e;font-size:14px;font-weight:bold"><strong><?php echo $titulo ?></strong></span>
</div>
<br>
<br>

<table  cellspacing="5" style="width: 300%; font-size: 10pt"; width="1000">
	<tr>
		<th width="80"   style="width: 7%;">Fecha Reg.</th>
		<th width="300"  style="width: 7%;">Proveedor</th>
		<th  width="100" style="width: 7%;">Numero Doc.</th>
		<th width="80"   style="width: 7%;">Fecha Doc.</th>
		<th width="100"  align="right" style="width: 7%; ">Total</th>
	</tr>	

<?php
$todo =0;
	$sql = $con->query($query);
	while($row_compra =  $sql->fetch_array())
	{
        $fecha=date_create($row_compra['fecha']);
        $fecha=date_format($fecha,'d-m-Y');
        $fecha=$row_compra['fecha'];
	    $nombre=$row_compra['nombre'];
	    $cod_documento=$row_compra['cod_documento'];
	    $fecha_compra=date_create($row_compra['fecha_documento']);
	    $fecha_compra=date_format($fecha_compra,'d-m-Y');
	    $fecha_documento=$row_compra['fecha_documento']; 
	    $total = $row_compra['total'];
	    $todo= $todo+$total;
	    $total = number_format($total,2,".",",");
        ?>
		
			<tr>
				<td width="80"><?php echo $fecha ?></td>
				<td width="300"><?php echo $nombre ?></td>
				<td width="100"><?php echo $cod_documento ?></td>
				<td width="80"><?php echo $fecha_compra ?></td>
				<td width="100" align="right"><?php echo $total ?></td>
			</tr>

<?php
 	}
$todo = number_format($todo,2,".",",");

 ?><tr>
        <td width="80"></td>
        <td width="300"></td>
        <td width="100"></td>
        <td width="80" style="width: 7%;" align="right"> Total:</td>
        <td width="100" align="right"><?php echo $todo ?></td>
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