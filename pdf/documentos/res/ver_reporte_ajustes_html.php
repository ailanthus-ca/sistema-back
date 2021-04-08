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
	<span style="color: #34495e;font-size:14px;font-weight:bold"><strong>REPORTE DE AJUSTES DE INVENTARIO</strong></span>
</div>
<br>
<br>
    <?php
    $nota='';
    $sql = $con->query("SELECT * 
                                FROM ajusteinv, usuario
                                WHERE usuario.codigo = ajusteinv.usuario
                                AND ajusteinv.codigo =  $id_ajuste ");
    while($row =  $sql->fetch_array())
    {
        $tipo=$row['tipo_ajuste'];
        $fecha=date_create($row['fecha']);
        $Fecha = date_format($fecha,'d/m/Y');
        $nombre = $row['nombre'];
        $nota = $row['nota'];
        ?>

        <div width="100" >codigo:    <?php echo $id_ajuste ?></div><br>
        <div width="200" >Fecha:     <?php echo $Fecha ?></div><br>
        <div width="100" >Tipo: <?php echo $tipo ?></div><br>
        <div width="400" >Ususario que realizo: <?php echo $nombre ?></div><br>
        <?php
    }
    ?>
<table  cellspacing="5" style="width: 300%; font-size: 10pt"; width="400">
	<tr>
		<th style="width: 9%;">Cod. Producto</th>
        <th style="width: 9%;">Nombre Producto</th>
		<th align="right" style="width: 5%;">Cantidad</th>
		<th style="width: 10%;">Descripción</th>
		
	</tr>	

<?php
	$sql = $con->query("SELECT detalleajusteinv.cod_producto, producto.descripcion AS p, detalleajusteinv.cantidad, detalleajusteinv.descripcion AS d
                                FROM producto, detalleajusteinv
                                WHERE producto.codigo = detalleajusteinv.cod_producto
                                AND detalleajusteinv.cod_ajuste =  $id_ajuste ");
	while($row =  $sql->fetch_array())
	{
		$cod=$row['cod_producto'];
	    $producto=$row['p'];
	    $cantidad = $row['cantidad'];
	    $descripcion = $row['d'];
?>
		
			<tr>
				<td><?php echo $cod ?></td>
				<td><?php echo $producto ?></td>
				<td align="right"><?php echo $cantidad ?></td>
				<td style=" width: 10%; max-width: 10%; overflow: hidden; text-align: left;"><?php echo $descripcion ?></td>
			</tr>

<?php
 	} 
 ?>

</table>  

<!--Pie de pagina del reporte-->
<page_footer backtop="20">
    <?php
    if($nota!=''){
        echo "Nota del Ajuste: ".$nota;
    }
    ?>
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