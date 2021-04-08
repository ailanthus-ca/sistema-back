<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of proveedor
 *
 * @author Ailanthus
 */
class proveedor  {
    //put your code here
    
    function __construct() {
    }
    
    function lista() {
        require "../config/conexion.php";
        $cl = array();
        $sql = $con->query('SELECT * FROM proveedor WHERE estatus = 1');
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
        $sql = $con->query("SELECT *from proveedor where codigo = '$id' ");
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
        echo json_encode((Object)$data);
    }
}
