<?php

class cliente {

    function listar() {
        require "../config/conexion.php";
        $cl = array();
        $sql = $con->query('SELECT * FROM cliente WHERE estatus = 1');
        while ($row = $sql->fetch_array()) {
            $cl[] = array(
                'codigo' => $row['codigo'],
                'nombre' => $row['nombre'],
                'telefono' => $row['telefono'],
                'correo' => $row['correo'],
                'contacto' => $row['contacto'],
                'direccion' => $row['direccion'],
                'estatus' => $row['estatus']);
        }
        echo json_encode($cl);
    }

    function detalles() {
        require "../config/conexion.php";
        $id = $_REQUEST['id'];
        $sql = $con->query("SELECT *from cliente where codigo = '$id' ORDER BY nombre");
        if ($row = $sql->fetch_array()) {
            $data = array(
                'codigo' => $row['codigo'],
                'nombre' => $row['nombre'],
                'telefono' => $row['telefono'],
                'correo' => $row['correo'],
                'contacto' => $row['contacto'],
                'direccion' => $row['direccion'],
                'estatus' => $row['estatus']);
        }
        echo json_encode((Object) $data);
    }

}
