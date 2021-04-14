<?php

namespace Modelos;

class Departamento extends \conexion {

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
            return getResponse(array());
        }
    }

    function checkCodigo($cod) {
        $sql = $this->query('SELECT count(*) AS exist FROM departamento WHERE codigo="' . $cod . '"');
        if ($row = $sql->fetch_array()) {
            return boolval($row['exist']);
        }
    }

    function count($id) {
        $sql = $this->con->query("SELECT count(*) AS num FROM producto WHERE departamento = '$departamento'");
        if ($row = $sql->fetch_array()) {
            return (int) $row['num'];
        } else {
            $this->getNotFount();
            return getResponse(array());
        }
    }

    function nuevo($id) {

    }

}
