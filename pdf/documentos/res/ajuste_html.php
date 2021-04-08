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
   
   <?php 
   		$sql = $con->query("SELECT *FROM conf_empresa");
   		$fila = $sql->fetch_array();

   		include 'encabezado.php';
    ?>

	<hr>
	<br>

	<!--Titulo del reporte-->
	<div style="text-align: center;">
		<span style="color: #34495e;font-size:14px;font-weight:bold"><strong>AJUSTE DE INVENTARIO</strong></span>
	</div>
	<br>
	<br>

	    
	    <span><small>Tipo de ajuste:&nbsp;<?php echo $tipo_ajuste ?></small></span>
	    <br>
	    <span><small>Fecha:&nbsp;<?php echo date("d-m-y") ?></small></span>
	    <br>
	    <br>
   		<hr>

     <table cellspacing="0" style="width: 100%; text-align: left; font-size: 7pt;">
        <tr>
            <th style="width: 10%;text-align:center;" >CODIGO</th>
            <th style="width: 40%;text-align: center;">NOMBRE DEL PRODUCTO</th>
            <th style="width: 10%;text-align: center;">CANTIDAD</th>
            <th style="width: 40%;text-align: center;">DESCRIPCIÓN</th>            
        </tr>
    </table>
    <hr>
        
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 7pt;">    
        <tr>
            <th style="width: 10%;text-align:center;" ></th>
            <th style="width: 40%;text-align: center;" ></th>
            <th style="width: 10%;text-align: center;" ></th>
            <th style="width: 40%;text-align: center;" ></th>
            
        </tr>    
		<?php
			$query = $con->query("SELECT codigo from ajusteinv order by codigo DESC LIMIT 1");
			$row = mysqli_fetch_array($query);
			$cod_ajuste = $row['codigo'];

			$sql=$con->query("SELECT producto.codigo as cod_producto, producto.descripcion as descripcion, detalleajusteinv.cantidad as cantidad, detalleajusteinv.descripcion as descripcion_aj from detalleajusteinv, producto where producto.codigo = detalleajusteinv.cod_producto AND detalleajusteinv.cod_ajuste = $cod_ajuste");
			while ($row=$sql->fetch_array())
				{
					$codigo_producto=$row['cod_producto'];
					$nombre_producto=$row['descripcion'];
					$cantidad=$row['cantidad'];
					$descripcion = $row['descripcion_aj'];
				
		?>

	        <tr>
	            <td style=" text-align: center;"><?php echo $codigo_producto; ?></td>
	            <td style=" width: 40%; max-width: 40%; overflow: hidden; text-align: center;"><?php echo $nombre_producto;?></td>
	            <td style=" text-align: center;"><?php echo $cantidad; ?></td>
	            <td style=" width: 40%; max-width: 40%; overflow: hidden; text-align: center;"><?php echo $descripcion; ?></td>	            
	            
	        </tr>
	
	  		<?php 
	  			}
	  		 ?>
	</table> 		 

</page>

<?php
/*
	$fechaHoy=date("Y-m-d");

	//crear nuevo ajuste
	
	$con->query("INSERT INTO ajusteinv VALUES ('','$tipo_ajuste','$fechaHoy') ");
	//devuelve el ultimo id insertado
	$cod = mysqli_insert_id();

	$sql=$con->query("select * from tmp");
			while ($row=$sql->fetch_array())
			 {
			 	$con->query("INSERT INTO detalleajusteinv VALUES ($cod,'".$row['id_producto']."','".$row['cantidad_tmp']."', '".$row['descripcion_tmp']."') ");


			 	if ($tipo_ajuste=="ENTRADA") 
			 	{
			 		$con->query("UPDATE producto set cantidad = cantidad + ('".$row['cantidad_tmp']."') WHERE codigo = '".$row['id_producto']."' ");
			 	}
			 	elseif($tipo_ajuste=="SALIDA")
			 	{
			 		$con->query("UPDATE producto set cantidad = cantidad - ('".$row['cantidad_tmp']."') WHERE codigo = '".$row['id_producto']."' ");
			 	}
			 	
			 }

	//reinicia la tabla temporal para el proximo ajuste
	$con->query("TRUNCATE TABLE tmp");
	mysqli_close($con);
*/	
?>