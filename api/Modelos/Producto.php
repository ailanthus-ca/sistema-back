<?php

namespace Modelos;

class Producto extends \conexion {

    var $estado = 'Producto';
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
        $sql = $this->query('SELECT producto.*, unidad.descripcion as medida FROM producto,unidad WHERE producto.unidad=unidad.codigo ');
        while ($row = $sql->fetch_array()) {
            $pro[] = array(
                'codigo' => $row['codigo'],
                'departamento' => $row['departamento'],
                'descripcion' => $row['descripcion'],
                'estatus' => (int) $row['estatus'],
                'enser' => (int) $row['enser'],
                'tipo' => (int) $row['tipo'],
                'unidad' => (int) $row['unidad'],
                'medida' => $row['medida'],
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

    public function ver($cod) {
        $sql = $this->query('SELECT producto.*,unidad.descripcion as medida FROM producto,unidad WHERE producto.unidad=unidad.codigo AND producto.codigo="' . $cod . '"');
        while ($row = $sql->fetch_array()) {
            $pro = array(
                'codigo' => $row['codigo'],
                'departamento' => $row['departamento'],
                'descripcion' => $row['descripcion'],
                'tipo' => (int) $row['tipo'],
                'enser' => (int) $row['enser'],
                'unidad' => (int) $row['unidad'],
                'medida' => $row['medida'],
                'cantidad' => (float) $row['cantidad'],
                'costo' => (float) $row['costo'],
                'precio1' => (float) $row['precio1'],
                'precio2' => (float) $row['precio2'],
                'precio3' => (float) $row['precio3'],
                'imagen' => $row['imagen'],
                'estatus' => (int) $row['estatus'],
                'fecha_creacion' => $row['fecha_creacion'],
            );
            return $pro;
        }
    }

    public function cargar($cod) {
        $sql = $this->query('SELECT * FROM producto WHERE codigo="' . $cod . '"');
        while ($row = $sql->fetch_array()) {
            $this->codigo = $row['codigo'];
            $this->departamento = $row['departamento'];
            $this->descripcion = $row['descripcion'];
            $this->tipo = (int) $row['tipo'];
            $this->enser = (int) $row['enser'];
            $this->unidad = (int) $row['unidad'];
            $this->cantidad = (float) $row['cantidad'];
            $this->costo = (float) $row['costo'];
            $this->precio1 = (float) $row['precio1'];
            $this->precio2 = (float) $row['precio2'];
            $this->precio3 = (float) $row['precio3'];
            $this->imagen = $row['imagen'];
            $this->estatus = (int) $row['estatus'];
            $this->fecha_creacion = $row['fecha_creacion'];
        }
    }

    function checkStock($cant) {
        return ($this->cantidad >= $cant);
    }

    function checkPrecio($precio) {
        $uti = ($this->precio1 / 100) + 1;
        $pre = $this->costo * $uti;
        return ($pre <= $precio);
    }

    function checkCosto($precio) {
        return ($this->costo <= $precio);
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
        $this->actualizarEstado();
        return $this->getResponse($this->ver($this->codigo));
    }

    public function actualizar($id) {
        $this->query("UPDATE producto SET " .
                "descripcion = UPPER('$this->descripcion'), " .
                "unidad = UPPER('$this->unidad')" .
                "WHERE codigo = '$id'");
        $this->actualizarEstado();
        return $this->getResponse($this->ver($id));
    }

    public function entrada($cod, $can, $pre = 0) {
        $this->query("UPDATE producto set cantidad = cantidad + ('$can') WHERE codigo = '$cod'");
        $sql2 = $this->query("SELECT costo from producto where codigo = '$cod' ");
        $row2 = $sql2->fetch_array();
        if ($row2['costo'] < $pre) {
            $this->costo($cod, $pre);
        }
        $this->actualizarEstado();
    }

    public function salida($cod, $can) {
        $this->query("UPDATE producto set cantidad = cantidad - ('$can') WHERE codigo = '$cod'");
        $this->actualizarEstado();
    }

    public function costo($cod, $pre) {
        $this->query("UPDATE producto set costo = $pre WHERE codigo = '$cod'");
        $this->actualizarEstado();
    }

    public function utilidad($cod, $p1 = 0, $p2 = 0, $p3 = 0) {
        $set = "";
        if ($p1 != 0) {
            $set .= ", precio1 = $p1";
        }
        if ($p2 != 0) {
            $set .= ", precio2 = $p2";
        }
        if ($p3 != 0) {
            $set .= ", precio3 = $p3";
        }
        $this->query("UPDATE producto set $set WHERE codigo = '$cod'");
        $this->actualizarEstado();
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
            $this->actualizarEstado();
            return $this->getResponse(true);
        }
    }

    public function listaWhere($where) {
        $pro = array();
        $sql = $this->query("SELECT producto.*, unidad.descripcion as medida FROM producto,unidad WHERE producto.unidad=unidad.codigo $where");
        while ($row = $sql->fetch_array()) {
            $pro[] = array(
                'codigo' => $row['codigo'],
                'departamento' => $row['departamento'],
                'descripcion' => $row['descripcion'],
                'estatus' => (int) $row['estatus'],
                'enser' => (int) $row['enser'],
                'tipo' => (int) $row['tipo'],
                'unidad' => (int) $row['unidad'],
                'medida' => $row['medida'],
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

}
