<?php

namespace Modelos;

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
class Proveedor extends \conexion {

    function lista() {
        $cl = array();
        $sql = $this->con->query('SELECT * FROM proveedor WHERE estatus = 1');
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
        return $cl;
    }

    function detalles($id) {
        $sql = $this->con->query("SELECT *from proveedor where codigo = '$id' ");
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
        return $data;
    }

    function nuevo() {
        $codigo = mysqli_real_escape_string($this->con, (strip_tags($_POST["codigo"], ENT_QUOTES)));
        $nombre = mysqli_real_escape_string($this->con, (strip_tags($_POST["nombre"], ENT_QUOTES)));
        $telefono = mysqli_real_escape_string($this->con, (strip_tags($_POST["telefono"], ENT_QUOTES)));
        $email = mysqli_real_escape_string($this->con, (strip_tags($_POST["correo"], ENT_QUOTES)));
        $this->contacto = mysqli_real_escape_string($this->con, (strip_tags($_POST["contacto"], ENT_QUOTES)));
        $direccion = mysqli_real_escape_string($this->con, (strip_tags($_POST["direccion"], ENT_QUOTES)));
        $estado = intval($_POST['estatus']);

        $sql = $this->con->query("SELECT *from proveedor WHERE codigo = '$codigo'") or die(json_encode(array('error' => 1, 'msn' => $this->con->error)));
        if ($row = $sql->fetch_array()) {
            return array('error' => 1, 'msn' => "Ya existe un proveedor con el mismo RIF/CI.");
        } else {
            $sql = "INSERT INTO proveedor (codigo,nombre,correo,direccion,contacto,telefono,estatus) VALUES (UPPER('$codigo'),UPPER('$nombre'), UPPER('$email'),UPPER('$direccion'),UPPER('$this->contacto'),'$telefono',$estado)";
            $query = $this->con->query($sql) or die(json_encode(array('error' => 1, 'msn' => $this->con->error)));

            if ($query) {
                return $this->detalles($codigo);
            }
        }
    }

}
