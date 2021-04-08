<?php

include '../../config/seccion.php';
if (empty($_SESSION['usuario'])) {
    header('Location: index.php');
}




/* Conectar a la base de datos */
include '../../config/conexion.php';

//parametros enviados por POST
//////////////////////////////
$cod_compra = mysqli_real_escape_string($con,(strip_tags($_POST["cod_compra"], ENT_QUOTES)));

//parametros enviados por AJAX
//////////////////////////////
$id_orden = (isset($_REQUEST['id_orden']) && $_REQUEST['id_orden'] != NULL) ? $_REQUEST['id_orden'] : '';

$cod_documento = (isset($_REQUEST['cod_doc']) && $_REQUEST['cod_doc'] != NULL) ? $_REQUEST['cod_doc'] : '';

$id_proveedor = (isset($_REQUEST['id_proveedor']) && $_REQUEST['id_proveedor'] != NULL) ? $_REQUEST['id_proveedor'] : '';

$fecha_doc = (isset($_REQUEST['fecha_doc']) && $_REQUEST['fecha_doc'] != NULL) ? $_REQUEST['fecha_doc'] : '';

$impuesto = (isset($_REQUEST['impuesto']) && $_REQUEST['impuesto'] != NULL) ? $_REQUEST['impuesto'] : '';
//Reemplazo las comas	
$impuesto_r = str_replace(",", "", $impuesto);

$subtotal = (isset($_REQUEST['subtotal']) && $_REQUEST['subtotal'] != NULL) ? $_REQUEST['subtotal'] : '';
//Reemplazo las comas
$subtotal_r = str_replace(",", "", $subtotal);

$total = (isset($_REQUEST['total']) && $_REQUEST['total'] != NULL) ? $_REQUEST['total'] : '';
//Reemplazo las comas
$total_r = str_replace(",", "", $total);


if ($cod_compra != "" && $id_proveedor != "" && $fecha_doc != "" && $cod_documento != "" && $impuesto != "" && $subtotal != "" && $total != "") {
    //crear nueva compra

    $fechaHoy = date("Y-m-d");
    $fecha_documento = date("Y-m-d", strtotime($fecha_doc));

    $sql = $con->query("INSERT INTO compra VALUES `(`codigo`, `cod_proveedor`, `cod_documento`, `fecha`, `fecha_documento`, `subtotal`, `impuesto`, `total`, `nota`, `usuario`, `estatus`)".
                                "('$cod_compra','$id_proveedor','$cod_documento','$fechaHoy','$fecha_documento',$subtotal_r, $impuesto_r,$total_r,2)")or die("tmp_fact_prod: " . $con->error);

    //si se cargo una orden de compra entonces actualiza el estatus de esa orden para que quede como procesada
    if (isset($id_orden)) {
        $sql = $con->query("UPDATE ordencompra SET estatus = 2 WHERE codigo = '$id_orden' ") or die("tmp_fact_prod: " . $con->error);;
    }

    $sql = $con->query("select * from tmp_comp_prod");
    while ($row = $sql->fetch_array()) {
        $con->query("INSERT INTO detallecompra VALUES ('$cod_compra','" . $row['id_producto'] . "','" . $row['cantidad_tmp'] . "','" . $row['precio_tmp'] . "','" . $row['precio_tmp'] * $row['cantidad_tmp'] . "') ") or die("tmp_fact_prod: " . $con->error);


        $con->query("UPDATE producto set cantidad = cantidad + ('" . $row['cantidad_tmp'] . "') WHERE codigo = '" . $row['id_producto'] . "' ") or die("tmp_fact_prod: " . $con->error);;

        $sql2 = $con->query("SELECT costo from producto where codigo = '" . $row['id_producto'] . "' ") or die("tmp_fact_prod: " . $con->error);;


        $row2 = $sql2->fetch_array();
        if ($row2['costo'] < $row['precio_tmp']) {
            $con->query("UPDATE producto set costo = '" . $row['precio_tmp'] . "' WHERE codigo = '" . $row['id_producto'] . "' ") or die("tmp_fact_prod: " . $con->error);;
        }
    }
    //reinicia la tabla temporal para la proxima factura
    //$con->query("truncate table tmp_comp_prod");

    mysqli_close($con);
}
?>