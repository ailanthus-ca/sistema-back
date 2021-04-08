<?php
include '../../config/conexion.php';
$codigo_nota = $_GET['id'];
$del1 = "update notasalida set estatus = 0 where codigo='$codigo_nota'";
if ($eliminar = $con->query($del1)) {
    $sql2 = $con->query("select * from detallesNotas where nota = '$codigo_nota' ");
    while ($row = $sql2->fetch_array()) {
        $cod = $row['producto'];
        $cantidad = intval($row['cantidad']);
        $con->query("UPDATE producto set cantidad = cantidad + $cantidad WHERE codigo = '$cod' ");
    }
    ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Aviso!</strong> nota de entrega cancelada exitosamente.
    </div>
    <?php
} else {
    ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Error!</strong> No se puedo cancelar la nota de entrega.
    </div>
    <?php
    echo $del1;
}
