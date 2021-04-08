<?php
session_start();
$id_usuario = $_SESSION['id_usuario'];

include '../../config/conexion.php';

$departamento = mysqli_real_escape_string($con, (strip_tags($_POST["departamento"], ENT_QUOTES)));
$cantidad = 1;
$precio_venta = floatval($_POST['precio2']);
$porc_impuesto = (isset($_GET['porc_impuesto']) && $_GET['porc_impuesto'] != NULL) ? $_GET['porc_impuesto'] : '';
$parametro = (isset($_POST['parametro']) && $_POST['parametro'] != NULL) ? $_POST['parametro'] : 'null';



//Buscar codigo del producto recien guardado para poder insertarlo en la tabla temporal

$query_id = $con->query("SELECT codigo 
                                from producto 
                                WHERE departamento = '$departamento'
                                ORDER BY fecha_creacion DESC limit 1");

if ($row_cod = mysqli_fetch_array($query_id)) {
    $id = $row_cod['codigo'];
}


$sql = $con->query("SELECT *from conf_region");
if ($row = $sql->fetch_array()) {
    $moneda = $row['moneda'];
    if ($porc_impuesto == '') {
        $porc_impuesto = $row['impuesto'];
    }
}

if (!empty($id) and ! empty($cantidad) and ! empty($precio_venta)) {



    $sql = $con->query("select *from tmp_cot_prod where id_producto = '$id' AND usuario_tmp = '$id_usuario'");
    if ($row = $sql->fetch_array()) {
        $con->query("update tmp_cot_prod set cantidad_tmp = '$cantidad', precio_tmp = $precio_venta 
                            WHERE id_producto = '$id' AND usuario_tmp = '$id_usuario'");
    } else {
        $insert_tmp = $con->query("INSERT into tmp_cot_prod (id_producto,cantidad_tmp,precio_tmp, usuario_tmp) 
                                        VALUES ('$id','$cantidad','$precio_venta', '$id_usuario')");
    }

    $sql2 = $con->query("select *from tmp_cot_prod WHERE usuario_tmp = '$id_usuario'");
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
<!--Se incluye script para calcular el total de la cotizacion-->
<?php include "calcular_cotizacion.php" ?>