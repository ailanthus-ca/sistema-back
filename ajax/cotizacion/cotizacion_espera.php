<?php
session_start();
if(empty($_SESSION['usuario']))
{
    header('Location: index.php');
}

$id_usuario = $_SESSION['id_usuario'];


/* Conectar a la base de datos*/
include '../../config/conexion.php';

$cod_cotizacion =(isset($_REQUEST['cod_cotizacion'])&& $_REQUEST['cod_cotizacion'] !=NULL)?$_REQUEST['cod_cotizacion']:'';
$codigo_cliente =(isset($_REQUEST['codigo_cliente'])&& $_REQUEST['codigo_cliente'] !=NULL)?$_REQUEST['codigo_cliente']:'';
$fecha          = date('Y-m-d');

$impuesto       = (isset($_REQUEST['impuesto'])&& $_REQUEST['impuesto'] !=NULL)?$_REQUEST['impuesto']:'';
//Reemplazo las comas
$impuesto_r     =str_replace(",","",$impuesto);

$subtotal       = (isset($_REQUEST['subtotal'])&& $_REQUEST['subtotal'] !=NULL)?$_REQUEST['subtotal']:'';
//Reemplazo las comas
$subtotal_r     =str_replace(",","",$subtotal);

$total          = (isset($_REQUEST['total'])&& $_REQUEST['total'] !=NULL)?$_REQUEST['total']:'';
//Reemplazo las comas
$total_r        =str_replace(",","",$total);

$forma_pago     =(isset($_REQUEST['forma_pago'])&& $_REQUEST['forma_pago'] !=NULL)?$_REQUEST['forma_pago']:'';
$tiempo_entrega =(isset($_REQUEST['tiempo_entrega'])&& $_REQUEST['tiempo_entrega'] !=NULL)?$_REQUEST['tiempo_entrega']:'';
$validez        =(isset($_REQUEST['validez'])&& $_REQUEST['validez'] !=NULL)?$_REQUEST['validez']:'';
$otros          =(isset($_REQUEST['otros'])&& $_REQUEST['otros'] !=NULL)?$_REQUEST['otros']:'';


if($codigo_cliente!="" && $fecha!="" && $impuesto!="" && $subtotal!="" && $total!="")
{
    if($cod_cotizacion=="-1"){
    $sql   ="INSERT into tmp_cotizacion values('',UPPER('$codigo_cliente'), '$fecha', $impuesto_r, $subtotal_r, $total_r, UPPER('$forma_pago'), UPPER('$tiempo_entrega'), UPPER('$validez'), UPPER('$otros'), 1,$id_usuario)";
    $query = $con->query($sql);
        //Id de la ultima cotizacion registrada
        $rs = $con->query("SELECT @@identity AS id");
        if ($row = mysqli_fetch_row($rs))
        {
            $cod_cotizacion = trim($row[0]);
            echo json_encode($cod_cotizacion);
        }
}else{
    $sql   ="UPDATE tmp_cotizacion SET cod_cliente=UPPER('$codigo_cliente'),fecha= '$fecha',iva= $impuesto_r, subtotal=$subtotal_r, total=$total_r, forma_pago=UPPER('$forma_pago'),tiempo_entrega= UPPER('$tiempo_entrega'),validez=UPPER('$validez'), nota=UPPER('$otros'),estatus= 1 WHERE codigo=$cod_cotizacion";
    $query = $con->query($sql);
    $sql   ="DELETE FROM tmp_detalle_cotizacion WHERE codCotizacion = $cod_cotizacion";
    $query = $con->query($sql);
}
}
//Se buscan todos los productos de la tabla temporal, asociados al usuario logeado
$sql=$con->query("select * from tmp_cot_prod WHERE usuario_tmp = '$id_usuario'");
while ($row=$sql->fetch_array())
{
    $con->query("INSERT INTO tmp_detalle_cotizacion VALUES ('$cod_cotizacion','".$row['id_producto']."','".$row['cantidad_tmp']."', '".$row['precio_tmp']."', '".$row['precio_tmp']*$row['cantidad_tmp']."', '".$row['descripcion_tmp']."') ");


}

mysqli_close($con);




?>