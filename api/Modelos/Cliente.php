<?php

namespace Modelos;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cliente
 *
 * @author Ailanthus
 */
class Cliente extends \Prototipo\Entidades {

    var $estado = 'Cliente';
    var $tipo_contribuyente = 'ORDINARIO';
    var $retencion = 0;

    public function lista() {
        $cl = array();
        $sql = $this->query('SELECT * FROM cliente');
        while ($row = $sql->fetch_array()) {
            $cl[] = array(
                $row['codigo'],
                $row['nombre'],
                $row['telefono'],
                $row['correo'],
                $row['contacto'],
                $row['direccion'],
                $row['tipo_contribuyente'],
                (float) $row['retencion'],
                (int) $row['estatus']);
        }
        return $this->getResponse($cl);
    }

    public function detalles($id) {
        $sql = $this->query("SELECT *from cliente where codigo = '$id' ");
        if ($row = $sql->fetch_array()) {
            $data = array(
                'codigo' => $row['codigo'],
                'nombre' => $row['nombre'],
                'telefono' => $row['telefono'],
                'correo' => $row['correo'],
                'contacto' => $row['contacto'],
                'direccion' => $row['direccion'],
                'tipo_contribuyente' => $row['tipo_contribuyente'],
                'retencion' => (float) $row['retencion'],
                'estatus' => (int) $row['estatus'],
            );
            return $this->getResponse($data);
        } else {
            $this->getNotFount();
            return $this->getResponse(array());
        }
    }

    function checkCodigo($cod) {
        $sql = $this->query('SELECT count(*) AS exist FROM cliente WHERE codigo="' . $cod . '"');
        if ($row = $sql->fetch_array()) {
            return boolval($row['exist']);
        }
    }

    public function nuevo() {
        $this->query("INSERT INTO cliente (codigo,nombre,correo,direccion,contacto,telefono,tipo_contribuyente, retencion, estatus) VALUES ("
                . "UPPER('$this->codigo'),"
                . "UPPER('$this->nombre'),"
                . " UPPER('$this->email'),"
                . "UPPER('$this->direccion'),"
                . "UPPER('$this->contacto'),"
                . "'$this->telefono',"
                . "UPPER('$this->tipo_contribuyente'),"
                . "$this->retencion,"
                . "1)");
        $this->actualizarEstado();
        return $this->getResponse($this->detalles($this->codigo));
    }

    public function actualizar($id) {
        $this->query("UPDATE cliente SET " .
                "nombre = UPPER('$this->nombre'), " .
                "correo = UPPER('$this->email')," .
                "direccion = UPPER('$this->direccion')," .
                "contacto = UPPER('$this->contacto')," .
                "telefono = '$this->telefono'," .
                "tipo_contribuyente = UPPER('$this->tipo_contribuyente')," .
                "retencion = $this->retencion " .
                "WHERE codigo = '$id'");
        $this->actualizarEstado();
        return $this->getResponse($this->detalles($id));
    }

    public function cancelar($id) {
        $sql = $this->query("SELECT * from cliente WHERE codigo = '$id' ");
        if ($row = $sql->fetch_array()) {
            if ($row['estatus'] === '1') {
                $this->query("UPDATE cliente SET "
                        . "estatus = 0 "
                        . "WHERE codigo = '$id' ");
            } else {
                $this->query("UPDATE cliente SET "
                        . "estatus = 1 "
                        . "WHERE codigo = '$id' ");
            }
            $this->actualizarEstado();
            return $this->getResponse(true);
        }
    }

    // ---------------------- GRAFICAS ---------------------

    public function totalClientes() {
        $query = $this->query("SELECT COUNT(*) AS total FROM `cliente`");
        $pen = 0;
        while ($row = $query->fetch_array()) {
            $pen = (int) $row['total'];
        }
        return $this->getResponse($pen);
    }

}
