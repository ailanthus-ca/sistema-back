<?php  
/* Conectar a la base de datos*/
include '../../config/conexion.php';
session_start();

$level = $_SESSION['nivel'];

if($level == 0) {

    $sql_cot = $con->query("SELECT cotizacion.codigo AS codigo, cliente.nombre AS nom1, fecha, total ,usuario.nombre AS nom2
						FROM cotizacion, cliente, usuario
						WHERE cotizacion.cod_cliente = cliente.codigo
						AND cotizacion.usuario = usuario.codigo
						AND cotizacion.estatus = 1 
						ORDER BY cotizacion.fecha");

    $data = array();
    $i = 0;

    while ($row = mysqli_fetch_array($sql_cot)) {
        $codigo = $row['codigo'];
        $nombre = $row['nom1'];
        $fecha  = $row['fecha'];
        $fecha  = date("d-m-Y", strtotime($fecha));
        $total  = $row['total'];
        $user   = $row['nom2'];

        $data[$i] = array('codigo' => $codigo,
            'nombre'  => $nombre,
            'fecha'   => $fecha,
            'total'   => $total,
            'usuario' => $user);
        $i = $i + 1;

    }
}else{
    $usuario = $_SESSION['id_usuario'];
    $sql_cot = $con->query("SELECT cotizacion.codigo AS codigo, nombre, fecha, total 
						FROM cotizacion, cliente
						WHERE cotizacion.cod_cliente = cliente.codigo
						AND cotizacion.estatus = 1 AND usuario = $usuario
						ORDER BY cotizacion.fecha");

    $data = array();
    $i = 0;

    while ($row = mysqli_fetch_array($sql_cot)) {
        $codigo = $row['codigo'];
        $nombre = $row['nombre'];
        $fecha = $row['fecha'];
        $fecha = date("d-m-Y", strtotime($fecha));
        $total = $row['total'];

        $data[$i] = array('codigo' => $codigo,
            'nombre' => $nombre,
            'fecha' => $fecha,
            'total' => $total);
        $i = $i + 1;

    }
}

    echo json_encode($data);

?>