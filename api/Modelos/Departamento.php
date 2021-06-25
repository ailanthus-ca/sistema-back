<?php

namespace Modelos;

class Departamento extends \conexion {

    var $estado = 'Departamento';
    var $codigo = '';
    var $descripcion = '';
    var $estatus = 0;

    public function lista() {
        $departamentos = array();
        $sql = $this->con->query('SELECT * FROM departamento');
        while ($row = $sql->fetch_array()) {
            $departamentos[] = array(
                'codigo' => $row['codigo'],
                'descripcion' => $row['descripcion'],
                'estatus' => (int) $row['estatus']
            );
        }
        return $this->getResponse($departamentos);
    }

    public function detalles($id) {
        $sql = $this->con->query("SELECT * FROM departamento WHERE codigo = '$id' ");
        if ($row = $sql->fetch_array()) {
            $data = array(
                'codigo' => $row['codigo'],
                'descripcion' => $row['descripcion'],
                'estatus' => $row['estatus'],
            );

            return $this->getResponse($data);

        } else {
            $this->getNotFount();
            return $this->getResponse(array());
        }
    }

    function checkCodigo($cod) {
        $sql = $this->query('SELECT count(*) AS exist FROM departamento WHERE codigo="' . $cod . '"');
        if ($row = $sql->fetch_array()) {
            return boolval($row['exist']);
        }
    }

    function count($id) {
        $sql = $this->con->query("SELECT count(*) AS num FROM producto WHERE departamento = '$id'");
        if ($row = $sql->fetch_array()) {
            return (int) $row['num'];
        } else {
            $this->getNotFount();
            return getResponse(array());
        }
    }

    function nuevo() {
        $this->query("INSERT INTO departamento (codigo, descripcion, estatus) VALUES("
            ."UPPER('$this->codigo'), "
            ."UPPER('$this->descripcion'), "
            . "1)");
        $this->actualizarEstado();
        return $this->getResponse($this->detalles($this->codigo));
    }

    function actualizar($id) {
        $this->query("UPDATE departamento SET "
            ."descripcion = UPPER('$this->descripcion') "
            ."WHERE codigo = '$id' ");
        $this->actualizarEstado();
        return $this->getResponse($this->detalles($id));
    }

    public function cancelar($id) {
        $sql = $this->query("SELECT * FROM departamento WHERE codigo= '$id' ");
        if ($row = $sql->fetch_array()) {
            if ($row['estatus'] === '1') {
                $this->query("UPDATE departamento SET "
                        . "estatus = 0 "
                        . "WHERE codigo = '$id' ");
            } else {
                $this->query("UPDATE departamento SET "
                        . "estatus = 1 "
                        . "WHERE codigo = '$id' ");
            }
            $this->actualizarEstado();
            return $this->getResponse(true);
        }
    }

}
