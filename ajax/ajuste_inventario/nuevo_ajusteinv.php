<?php
 include '../../config/seccion.php';
  if(empty($_SESSION['usuario']))
  {
    header('Location: index.php');
  }

$id_usuario = $_SESSION['id_usuario'];


/* Conectar a la base de datos*/
include '../../config/conexion.php';


$fechaHoy = date('Y-m-d');

$cod_usuario = $_SESSION['id_usuario'];

$tipo_ajuste = (isset($_REQUEST['tipo_ajuste'])&& $_REQUEST['tipo_ajuste'] !=NULL)?$_REQUEST['tipo_ajuste']:'';

$nota        = (isset($_REQUEST['nota'])&& $_REQUEST['nota'] !=NULL)?$_REQUEST['nota']:'';
if($tipo_ajuste!="")
{	
	//crear nuevo ajuste
    $max = $con->query("SELECT MAX( codigo ) AS m FROM ajusteinv");
    while($ret=mysqli_fetch_array($max)){
        $cod = $ret['m'];
    }
    $cod++;
	$con->query("INSERT INTO ajusteinv VALUES ($cod,'$tipo_ajuste','$fechaHoy','$nota',$cod_usuario) ");
	$sql=$con->query("select * from tmp_cot_prod WHERE usuario_tmp = '$id_usuario' ");
			while ($row=$sql->fetch_array())
			 {
			 	$con->query("INSERT INTO detalleajusteinv VALUES ($cod,'".$row['id_producto']."','".$row['cantidad_tmp']."', '".$row['descripcion_tmp']."') ");


			 	if ($tipo_ajuste=="ENTRADA") 
			 	{
			 		$con->query("UPDATE producto set cantidad = cantidad + ('".$row['cantidad_tmp']."') WHERE codigo = '".$row['id_producto']."' ");

                    //Se guarda el cambio en la tabla configuracion como historial
                    $con->query("INSERT into configuracion VALUES ('', $cod_usuario, 'ajuste de inventario, entrada', NOW())");

			 	}
			 	elseif($tipo_ajuste=="SALIDA")
			 	{
			 		$con->query("UPDATE producto set cantidad = cantidad - ('".$row['cantidad_tmp']."') WHERE codigo = '".$row['id_producto']."' ");

                    //Se guarda el cambio en la tabla configuracion como historial
                    $cod_usuario = $_SESSION['id_usuario'];
                    $con->query("INSERT into configuracion VALUES ('', $cod_usuario, 'ajuste de inventario, salida', NOW())");
			 	}
			 	
			 }
    $con->query("DELETE from tmp_cot_prod WHERE usuario_tmp = '$id_usuario'");
    echo json_encode($cod);
	mysqli_close($con);
}
	
?>