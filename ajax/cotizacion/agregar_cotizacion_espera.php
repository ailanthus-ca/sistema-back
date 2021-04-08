<?php
session_start();
$id_usuario = $_SESSION['id_usuario'];


if (isset($_POST['id'])) {
    $id = $_POST['id'];
}
$parametro = (isset($_POST['parametro']) && $_POST['parametro'] != NULL) ? $_POST['parametro'] : 'null';

include '../../config/conexion.php';

$sql = $con->query("SELECT *from conf_region");
if ($row = $sql->fetch_array()) {
    $moneda = $row['moneda'];
    $porc_impuesto = $row['impuesto'];
}

if (!empty($id)) {
    $con->query("DELETE from tmp_cot_prod WHERE usuario_tmp = '$id_usuario' ");

    $productos = array();

    $sql = $con->query("select *from tmp_cotizacion, tmp_detalle_cotizacion where codigo = '$id' AND codCotizacion = '$id'");
    $iva = 0;
    $subtotal = 0;
    $total = 0;
    while ($row = $sql->fetch_array()) {
        $iva = $row['iva'];
        $subtotal = $row['subtotal'];
        $total = $row['total'];
        $cod_producto = $row['codProducto'];
        $cantidad = $row['cantidad'];
        $monto = $row['monto'];
        $comentario = $row['comentario'];
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
        $sql3 = $con->query("select *from tmp_cot_prod where id_producto = '$cod_producto' AND usuario_tmp = '$id_usuario'");
        if ($row3 = mysqli_fetch_array($sql3)) {
            $con->query("update tmp_cot_prod set cantidad_tmp = '$cantidad' , descripcion_tmp = '$comentario'
                            WHERE id_producto = '$cod_producto' AND usuario_tmp = '$id_usuario'");
        } else {
            $insert_tmp = $con->query("INSERT into tmp_cot_prod ( id_producto,cantidad_tmp,precio_tmp,descripcion_tmp, usuario_tmp) 
                                                              VALUES ('$cod_producto','$cantidad','$precio_venta_r','$comentario', '$id_usuario')");
        }
    }
}
if (isset($_GET['id'])) {//codigo elimina un elemento del array
    $id_tmp = intval($_GET['id']);
    $delete = $con->query("DELETE from tmp_cot_prod WHERE id_tmp='" . $id_tmp . "' AND usuario_tmp = '$id_usuario'");
}
?>

<!--Se incluye script para calcular el total de la cotizacion-->
<?php
include "calcular_cotizacion.php";
?>
