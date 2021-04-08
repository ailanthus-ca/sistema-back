<?php
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}
$porc_impuesto = (isset($_POST['porc_impuesto']) && $_POST['porc_impuesto'] != NULL) ? $_POST['porc_impuesto'] : '';


include '../../config/conexion.php';
//borrar tabla temporal
$con->query("truncate table tmp");
$nota = '';
if (!empty($id)) {
    $productos = array();

    $sql = $con->query("select *from detallecotizacion where codCotizacion = '$id'");
    while ($row = $sql->fetch_array()) {
        $cod_producto = $row['codProducto'];
        $cantidad = $row['cantidad'];
        $monto = $row['monto'];
        $precio_venta_f = number_format(floatval($row['monto'] / $cantidad), 2);
        $precio_venta_r = str_replace(",", "", $precio_venta_f); //Reemplazo las comas		
        //se busca el costo de cada producto de la cotizacion	
        $sql2 = $con->query("SELECT costo from producto WHERE codigo = '$cod_producto'");
        if ($row2 = $sql2->fetch_array()) {
            //se compara el precio de cada producto en la cotizacion, con su respectivo costo
            $costo = (float) $row2['costo'];
            $precio = (float) $monto / $cantidad;
            //si el costo es mayor que el precio del producto
            if ($precio < $costo) {
                $productos[] = $cod_producto;
            } else {
                $productos[] = '';
            }
        }

        $sql3 = $con->query("select *from tmp_fact_prod where id_producto = '$cod_producto'");
        if ($row3 = mysqli_fetch_array($sql3)) {
            $con->query("update tmp_fact_prod set cantidad_tmp = '$cantidad' WHERE id_producto = '$cod_producto'");
        } else {
            $insert_tmp = $con->query("INSERT into tmp_fact_prod (id_producto,cantidad_tmp,precio_tmp) VALUES ('$cod_producto','$cantidad','$precio_venta_r')");
        }
    }
}
?>

<!--Se incluye script para calcular el impuesto y el total de la factura-->
<?php include 'calcular_factura.php' ?>