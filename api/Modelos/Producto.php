<?php

namespace Modelos;

class Producto extends \conexion {

    var $codigo = '';
    var $departamento = '';
    var $descripcion = '';
    var $costo = 0;
    var $precio1 = 0;
    var $precio2 = 0;
    var $precio3 = 0;
    var $tipo = 0;
    var $unidad = 0;
    var $enser = 0;

    public function lista() {
        $pro = array();
        $sql = $this->query('SELECT * FROM producto');
        while ($row = $sql->fetch_array()) {
            $pro[] = array(
                'codigo' => $row['codigo'],
                'departamento' => $row['departamento'],
                'descripcion' => $row['descripcion'],
                'estatus' => (int) $row['estatus'],
                'enser' => (int) $row['enser'],
                'tipo' => (int) $row['tipo'],
                'costo' => (float) $row['costo'],
                'precio1' => (float) $row['precio1'],
                'precio2' => (float) $row['precio2'],
                'precio3' => (float) $row['precio3'],
                'cantidad' => (float) $row['cantidad'],
                'fecha' => $row['fecha_creacion'],
            );
        }
        return $pro;
    }

    public function tipo() {
        $tp = array();
        $sql = $this->query('SELECT codigo,descripcion FROM tipo_producto WHERE estatus = 1 LIMIT 0,40');
        while ($row = $sql->fetch_array()) {
            $tp[] = array(
                'codigo' => (int) $row['codigo'],
                'descripcion' => $row['descripcion']
            );
        }
        return $tp;
    }

    public function unidad() {
        $un = array();
        $sql = $this->query('SELECT codigo,descripcion FROM unidad WHERE estatus = 1 ');
        while ($row = $sql->fetch_array()) {
            $un[] = array(
                'codigo' => (int) $row['codigo'],
                'descripcion' => $row['descripcion']
            );
        }
        return $un;
    }

    public function departamentos() {
        $de = array();
        $sql = $this->query("SELECT codigo,descripcion FROM departamento WHERE estatus = 1");
        while ($row = $sql->fetch_array()) {
            $de[] = array(
                'codigo' => $row['codigo'],
                'descripcion' => $row['descripcion'],
            );
        }
        return $de;
    }

    public function ver($cod) {
        $sql = $this->query('SELECT * FROM producto WHERE codigo="' . $cod . '"');
        while ($row = $sql->fetch_array()) {
            $pro = array(
                'codigo' => $row['codigo'],
                'departamento' => $row['departamento'],
                'descripcion' => $row['descripcion'],
                'tipo' => (int) $row['tipo'],
                'enser' => (int) $row['enser'],
                'unidad' => (int) $row['unidad'],
                'cantidad' => (float) $row['cantidad'],
                'costo' => (float) $row['costo'],
                'precio1' => (float) $row['precio1'],
                'precio2' => (float) $row['precio2'],
                'precio3' => (float) $row['precio3'],
                'imagen' => $row['imagen'],
                'estatus' => (int) $row['estatus'],
                'fecha_creacion' => $row['fecha_creacion'],
            );
        }
        return $pro;
    }

    function checkCodigo($cod) {
        $sql = $this->query('SELECT count(*) AS exist FROM producto WHERE codigo="' . $cod . '"');
        if ($row = $sql->fetch_array()) {
            return boolval($row['exist']);
        }
    }

    public function nuevo() {
        $query = $this->query("INSERT INTO producto VALUES (
              UPPER('$this->codigo'),"
                . "'$this->departamento',"
                . "UPPER('$this->descripcion'),"
                . "UPPER('$this->tipo'), "
                . "'$this->enser' ,"
                . "UPPER('$this->unidad'),"
                . "$this->costo,"
                . "$this->precio1,"
                . "$this->precio2,"
                . "$this->precio3,"
                . "0,"
                . "'',"
                . "1,"
                . " NOW())");
        return $this->getResponse($this->ver($this->codigo));
    }

    public function actualizar($id) {
        $this->query("UPDATE producto SET " .
                "descripcion = UPPER('$this->descripcion'), " .
                "unidad = UPPER('$this->unidad')".
                "WHERE codigo = '$id'");
        return $this->getResponse($this->ver($id));
    }

    public function entrada($cod, $can, $pre = 0) {
        $this->query("UPDATE producto set cantidad = cantidad + ('$can') WHERE codigo = '$cod'");
        $sql2 = $this->query("SELECT costo from producto where codigo = '$cod' ");
        $row2 = $sql2->fetch_array();
        if ($row2['costo'] < $pre) {
            $this->query("UPDATE producto set costo = '$pre' WHERE codigo = '$cod'");
        }
    }

    public function salida($cod, $can) {
        $this->query("UPDATE producto set cantidad = cantidad - ('$can') WHERE codigo = '$cod'");
    }

    public function cancelar($id) {
        $sql = $this->query("SELECT * FROM producto WHERE codigo= '$id' ");
        if ($row = $sql->fetch_array()) {
            if ($row['estatus'] === '1') {
                $this->query("UPDATE producto SET "
                        . "estatus = 0 "
                        . "WHERE codigo = '$id' ");
            } else {
                $this->query("UPDATE producto SET "
                        . "estatus = 1 "
                        . "WHERE codigo = '$id' ");
            }
            return $this->getResponse(true);
        }
    }

}
