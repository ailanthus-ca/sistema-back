<?php
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}
if (isset($_POST['cantidad'])) {
    $cantidad = $_POST['cantidad'];
}
if (isset($_POST['precio_venta'])) {
    $precio_venta = $_POST['precio_venta'];
}
$porc_impuesto = (isset($_POST['porc_impuesto']) && $_POST['porc_impuesto'] != NULL) ? $_POST['porc_impuesto'] : '';
$action = (isset($_POST['action']) && $_POST['action'] != NULL) ? $_POST['action'] : 'null';


$nota = (isset($_POST['nota']) && $_POST['nota'] != NULL) ? $_POST['nota'] : '';
include '../../config/conexion.php';

if (!empty($id) and ! empty($cantidad) and ! empty($precio_venta) AND $action == "null") {
    $sql2 = $con->query("select *from tmp_fact_prod where id_producto = '$id'");
    if ($row2 = $sql2->fetch_array()) {
        $con->query("update tmp_fact_prod set cantidad_tmp = '$cantidad', precio_tmp = $precio_venta WHERE id_producto = '$id'");
    } else {
        $con->query("INSERT into tmp_fact_prod (id_producto,cantidad_tmp,precio_tmp) VALUES ('$id','$cantidad','$precio_venta')");
    }

    $sql3 = $con->query("select *from tmp_fact_prod");
    while ($row3 = mysqli_fetch_array($sql3)) {
        //se busca el costo del producto seleccionado
        $cod = $row3['id_producto'];
        $precio_tmp = $row3['precio_tmp'];

        $sql4 = $con->query("SELECT costo from producto WHERE codigo = '$cod' ");
        if ($row4 = mysqli_fetch_array($sql4)) {
            //se compara el precio de cada producto en la cotizacion, con su respectivo costo
            $costo = (float) $row4['costo'];
            $precio = (float) $precio_tmp;
            //si el costo es mayor que el precio del producto
            if ($precio < $costo) {
                $productos[] = $cod;
            } else {
                $productos[] = '';
            }
        }
    }
}

if (isset($_POST['id']) AND $action == "eliminar") {//codigo elimina un elemento del array
    $id_tmp = intval($_POST['id']);
    $delete = $con->query("DELETE from tmp_fact_prod WHERE id_tmp='" . $id_tmp . "'");

    $sql2 = $con->query("select *from tmp_fact_prod");
    while ($row2 = $sql2->fetch_array()) {
        //se busca el costo del producto seleccionado
        $cod = $row2['id_producto'];
        $precio_tmp = $row2['precio_tmp'];
        $sql3 = $con->query("SELECT costo from producto WHERE codigo = '$cod' ");

        if ($row3 = mysqli_fetch_array($sql3)) {
            //se compara el precio de cada producto en la cotizacion, con su respectivo costo
            $costo = (float) $row3['costo'];
            $precio = (float) $precio_tmp;
            //si el costo es mayor que el precio del producto
            if ($precio < $costo) {
                $productos[] = $cod;
            } else {
                $productos[] = '';
            }
        }
    }
}
?>

<!--Se incluye script para calcular el impuesto y el total de la factura-->
<?php include 'calcular_factura.php' ?>