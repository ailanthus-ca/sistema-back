<?php

/* Conectar a la base de datos */
include '../../config/conexion.php';

$mes_actual = date("n");
$ano_actual = date("Y");
$pto = (isset($_POST['pto']) && $_POST['pto'] != NULL) ? $_POST['pto'] : 'null';

if ($pto != "" AND $pto != NULL AND $pto != "null") {
    $query = $con->query("SELECT MAX(codigo) as codigo from equilibrio") or die('Error SQL  Mensaje:' . $con->error);
    if ($row = $query->fetch_array()) {
        $codigo = $row['codigo']+1;
        $con->query("INSERT into equilibrio values($codigo,$ano_actual, $mes_actual, $pto)") or die('Error SQL  Mensaje:' . $con->error);
    } else {
        $con->query("INSERT into equilibrio values(1,$ano_actual, $mes_actual, $pto)") or die('Error SQL  Mensaje:' . $con->error);
    }
    $mes_anterior = $mes_actual - 1;
    if ($mes_anterior != 0) {
        echo 'sql';
        $sql = "SELECT * FROM mejor_mes WHERE mes=$mes_anterior AND año=$ano_actual";
    } else {
        echo 'sql';
        $año_anterior = $ano_actual - 1;
        $mes_anterior = 12;
        $sql = "SELECT * FROM mejor_mes WHERE mes=12 AND año=$año_anterior";
    }
    $query = $con->query($sql) or die('Error SQL ' . $sql . ' Mensaje:' . $con->error);
    if ($row = $query->fetch_array()) {
        echo 'existe';
    } else {
        echo 'crealo';
        $sql = "SELECT SUM(subtotal) AS ventas FROM factura WHERE estatus = 2 AND MONTH(fecha)=$mes_anterior AND YEAR(fecha)='$año_anterior'";
        $query = $con->query($sql) or die('Error SQL ' . $sql . ' Mensaje:' . $con->error);
        if ($row = $query->fetch_array()) {
            $con->query("INSERT INTO `mejor_mes`(`id`, `ventas`, `mes`, `año`) VALUES (null," . $row['ventas'] . ",$mes_anterior,$año_anterior)");
        }
    }
}
$sql_equi = $con->query("SELECT * from equilibrio WHERE ano = $ano_actual AND mes = $mes_actual") or die('Error SQL Mensaje:' . $con->error);
if ($row = $sql_equi->fetch_array()) {
    $equi = $row['monto'];
} else
    $equi = 0;
$sql_ventas = $con->query("SELECT SUM(subtotal) AS ventas FROM factura WHERE estatus = 2 AND MONTH(fecha)=$mes_actual AND YEAR(fecha)='$ano_actual'") or die('Error SQL Mensaje:' . $con->error);
if ($row2 = $sql_ventas->fetch_array()) {
    $ventas = $row2['ventas'];
}

$data = array(0 => $equi, 1 => $ventas);

echo json_encode($data);
?>
