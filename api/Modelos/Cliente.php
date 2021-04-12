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
class Cliente extends \conexion {

    var $tipo_contribuyente = 'ORDINARIO';
    var $retencion = 0;

    public function lista() {
        $cl = array();
        $sql = $this->query('SELECT * FROM cliente WHERE estatus = 1');
        while ($row = $sql->fetch_array()) {
            $cl[] = array(
                'codigo' => $row['codigo'],
                'nombre' => $row['nombre'],
                'telefono' => $row['telefono'],
                'correo' => $row['correo'],
                'contacto' => $row['contacto'],
                'direccion' => $row['direccion'],
                'tipo_contribuyente' => $row['tipo_contribuyente'],
                'retencion' => (float) $row['retencion'],
                'estatus' =>(int) $row['estatus']);
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
                'retencion' => $row['retencion'],
                'estatus' => $row['estatus'],
            );
            return $this->getResponse($data);
        } else {
            $this->getNotFount();
            return $this->getResponse(array());
        }
    }

    public function nuevo() {
        $sql = $this->con->query("SELECT * from cliente WHERE codigo = '$this->codigo'");
        if ($row = $sql->fetch_array()) {
            return $this->getResponse($this->detalles($this->codigo));
        } else {
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
            return $this->getResponse($this->detalles($this->codigo));
        }
    }

    public function actualizar($id) {
        $sql = $this->con->query("SELECT * from cliente WHERE codigo = '$id' ");
        if ($row = $sql->fetch_array()) {
            $this->query("UPDATE cliente SET ".
                "nombre = UPPER('$this->nombre'), ".
                "correo = UPPER('$this->email'),".
                "direccion = UPPER('$this->direccion'),".
                "contacto = UPPER('$this->contacto'),".
                "telefono = '$this->telefono',".
                "tipo_contribuyente = UPPER('$this->tipo_contribuyente'),".
                "retencion = $this->retencion ".
            "WHERE codigo = '$id'  ");

            return $this->getResponse($this->detalles($id));
        }
        $this->getNotFount();
        return $this->getResponse();
    }

}
