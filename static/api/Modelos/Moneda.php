<?php

namespace Modelos;

class Moneda extends \conexion {

    var $estado = 'Moneda';
    var $descripcion = '';
    var $estatus = '';

    public function lista() {
        $mo = array();
        $sql = $this->query('SELECT * FROM moneda');
        while ($row = $sql->fetch_array()) {
            $mo[] = array(
                'codigo' =>(int) $row['id'],
                'descripcion' => $row['descripcion'],
                'estatus' =>(int) $row['estatus'],
            );
        }
        return $this->getResponse($mo);
    }

    public function detalles($id) {
        $sql = $this->query("SELECT *from moneda where id = $id ");
        if ($row = $sql->fetch_array()) {
            $data = array(
                'codigo' => $row['id'],
                'descripcion' => $row['descripcion'],
                'status' => $row['estatus'],
            );
            return $this->getResponse($data);
        } else {
            $this->getNotFount();
            return $this->getResponse(array());
        }
    }

    public function nuevo() {    
        $this->query("INSERT INTO `moneda`(`id`, `descripcion`, `estatus`) VALUES (null,'$this->descripcion',1)");
        $id_moneda = $this->con->insert_id;
        $this->actualizarEstado();
        return $this->getResponse($this->detalles($id_moneda));
    }

    public function actualizar($id) {
        $this->query("UPDATE moneda SET " .
                "descripcion = UPPER('$this->descripcion') " .
                "WHERE id = '$id' ");
        $this->actualizarEstado();
        return $this->getResponse($this->detalles($id));
    }

    public function cancelar($id) {
        $sql = $this->query("SELECT * from moneda WHERE id = $id ");
        if ($row = $sql->fetch_array()) {
            if ($row['estatus'] === '1') {
                $this->query("UPDATE moneda SET "
                        . "estatus = 0 "
                        . "WHERE id = $id ");
            } else {
                $this->query("UPDATE moneda SET "
                        . "estatus = 1 "
                        . "WHERE id = $id ");
            }
            $this->actualizarEstado();
            return $this->getResponse(true);
        }
    }

}
