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
class Proveedor extends \Prototipo\Entidades {

    var $estado = 'Proveedor';
    function lista() {
        $cl = array();
        $sql = $this->con->query('SELECT * FROM proveedor');
        while ($row = $sql->fetch_array()) {
            $cl[] = array(
                'codigo' => $row['codigo'],
                'nombre' => $row['nombre'],
                'telefono' => $row['telefono'],
                'correo' => $row['correo'],
                'contacto' => $row['contacto'],
                'direccion' => $row['direccion'],
                'estatus' => (int) $row['estatus']);
        }
        return $this->getResponse($cl);
    }

    function detalles($id) {
        $sql = $this->query("SELECT *from proveedor where codigo = '$id' ");
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
        return $this->getResponse($data);
    }

    function checkCodigo($cod) {
        $sql = $this->query('SELECT count(*) AS exist FROM proveedor WHERE codigo="' . $cod . '"');
        if ($row = $sql->fetch_array()) {
            return boolval($row['exist']);
        }
    }

    function nuevo() {
        $this->query("INSERT INTO proveedor (codigo,nombre,correo,direccion,contacto,telefono,estatus) VALUES ("
                . "UPPER('$this->codigo'),"
                . "UPPER('$this->nombre'),"
                . " UPPER('$this->email'),"
                . "UPPER('$this->direccion'),"
                . "UPPER('$this->contacto'),"
                . "'$this->telefono',"
                . "1)");
        $this->actualizarEstado();
        return $this->getResponse($this->detalles($this->codigo));
    }

    function actualizar($id) {
        $this->query("UPDATE proveedor SET " .
                "nombre = UPPER('$this->nombre')," .
                "correo = UPPER('$this->email')," .
                "direccion = UPPER('$this->direccion')," .
                "contacto = UPPER('$this->contacto')," .
                "telefono = '$this->telefono' " .
                "WHERE codigo = '$id'  ");
        $this->actualizarEstado();
        return $this->getResponse($this->detalles($id));
    }

    function cancelar($id) {
        $sql = $this->con->query("SELECT * from proveedor WHERE codigo = '$id' ");
        if ($row = $sql->fetch_array()) {
            if ($row['estatus'] === '1') {
                $this->query("UPDATE proveedor SET "
                        . "estatus = 0 "
                        . "WHERE codigo = '$id' ");
            } else {
                $this->query("UPDATE proveedor SET "
                        . "estatus = 1 "
                        . "WHERE codigo = '$id' ");
            }
            $this->actualizarEstado();
            return $this->getResponse(true);
        }
    }

    // ---------------------- GRAFICAS ---------------------

    public function totalProveedores()
    {
        $query = $this->query("SELECT COUNT(*) AS total FROM `proveedor`");
        $pen = 0;
        while ($row = $query->fetch_array()) {
            $pen = (int) $row['total'];
        }
        return $this->getResponse($pen);
    }

}
