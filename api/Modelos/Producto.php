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
    var $exento = 0;
    var $dolar = 0;
    var $inventario = 1;

    function fechaCambios() {
        $sql = $this->query('SELECT MAX(actualizado) AS cant FROM producto');
        while ($row = $sql->fetch_array()) {
            return $row['cant'];
        }
        return '';
    }

    public function cambios($fecha, $hora) {
        $pro = array();
        $act = $this->fechaCambios();
        $sol = ($fecha !== '') ? " AND `actualizado` > '$fecha $hora'" : '';
        $sql = $this->query('SELECT producto.*, unidad.descripcion as medida, tipo_producto.inventario as inventario '
                . 'FROM producto,unidad, tipo_producto '
                . "WHERE producto.unidad=unidad.codigo AND tipo_producto.codigo = producto.tipo $sol");
        while ($row = $sql->fetch_array()) {
            $pro[] = array(
                $row['codigo'],
                $row['departamento'],
                $row['descripcion'],
                (int) $row['estatus'],
                (int) $row['enser'],
                (int) $row['tipo'],
                (int) $row['unidad'],
                $row['medida'],
                (float) $row['costo'],
                (float) $row['precio1'],
                (float) $row['precio2'],
                (float) $row['precio3'],
                (float) $row['cantidad'],
                $row['fecha_creacion'],
                (int) $row['inventario'],
                (boolean) $row['exento'],
                (float) $row['dolar'],
            );
        }
        return $this->getResponse([
                    'fecha' => $act,
                    'data' => $pro,
        ]);
    }

    public function lista() {
        $pro = array();
        $sql = $this->query('SELECT producto.*, unidad.descripcion as medida, tipo_producto.inventario as inventario '
                . 'FROM producto,unidad, tipo_producto '
                . 'WHERE producto.unidad=unidad.codigo AND tipo_producto.codigo = producto.tipo');
        while ($row = $sql->fetch_array()) {
            $pro[] = array(
                $row['codigo'],
                $row['departamento'],
                $row['descripcion'],
                (int) $row['estatus'],
                (int) $row['enser'],
                (int) $row['tipo'],
                (int) $row['unidad'],
                $row['medida'],
                (float) $row['costo'],
                (float) $row['precio1'],
                (float) $row['precio2'],
                (float) $row['precio3'],
                (float) $row['cantidad'],
                $row['fecha_creacion'],
                (int) $row['inventario'],
                (boolean) $row['exento'],
                (float) $row['dolar'],
            );
        }
        return $pro;
    }

    public function ver($cod) {
        $sql = $this->query('SELECT producto.*, unidad.descripcion as medida, tipo_producto.inventario as inventario FROM producto,unidad, tipo_producto WHERE producto.unidad=unidad.codigo AND tipo_producto.codigo = producto.tipo AND producto.codigo="' . $cod . '"');
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
                'inventario' => (int) $row['inventario'],
                'tasa' => (float) $row['dolar'],
                'exento' => (boolean) $row['exento'],
            );
            return $pro;
        }
    }

    public function cargar($cod) {
        $sql = $this->query('SELECT producto.*, unidad.descripcion as medida, tipo_producto.inventario as inventario FROM producto,unidad, tipo_producto WHERE producto.unidad=unidad.codigo AND tipo_producto.codigo = producto.tipo AND producto.codigo="' . $cod . '"');
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
            $this->dolar = (float) $row['dolar'];
            $this->inventario = (int) $row['inventario'];
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

    function checkCosto($precio, $tasa = 0) {
        $config = new \Config('costo');
        $costoConfig = $config->get();
        $costo = $this->costo;
        if ($costoConfig['tasa'] && $tasa > 0 && $this->dolar > 0) {
            $costo = $this->costo / $this->dolar;
            $precio = $precio / $tasa;
        }
        return ($costo <= $precio);
    }

    function igualCosto($precio, $tasa = 1) {
        return ($this->costo === $precio && $this->dolar === tasa);
    }

    function igualUtilidad($p1 = 0, $p2 = 0, $p3 = 0) {
        return ($this->precio1 === $p1 && $this->precio2 === $p2 && $this->precio3 === $p3);
    }

    function checkCodigo($cod) {
        $sql = $this->query('SELECT count(*) AS exist FROM producto WHERE codigo="' . $cod . '"');
        if ($row = $sql->fetch_array()) {
            return boolval($row['exist']);
        }
    }

    public function nuevo() {
        $query = $this->query("INSERT INTO producto VALUES ("
                . "UPPER('$this->codigo'), "
                . "'$this->departamento', "
                . "UPPER('$this->descripcion'), "
                . "UPPER('$this->tipo'), "
                . "'$this->enser', "
                . "UPPER('$this->unidad'), "
                . "$this->costo, "
                . "$this->precio1, "
                . "$this->precio2, "
                . "$this->precio3, "
                . "0, "
                . "'', "
                . "1, "
                . " NOW(), " 
                . " NOW(), "
                . "'$this->exento', "
                . "$this->dolar)");
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

    public function cargarStock($cod) {
        $pro = $this->ver($cod);
        $cant = 0;
        if ($pro['inventario'] !== 1)
            $cant = $this->calcularStock($cod);
        $this->query("UPDATE producto set cantidad = $cant WHERE codigo = '$cod'");
        $this->actualizarEstado();
    }

    public function costo($cod, $pre, $tasa) {
        $this->query("UPDATE producto set costo = $pre, dolar = $tasa WHERE codigo = '$cod'");
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
        $sql = $this->query("SELECT * FROM producto WHERE codigo = '$id' ");
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
        $sql = $this->query('SELECT producto.*, unidad.descripcion as medida, tipo_producto.inventario as inventario '
                . 'FROM producto,unidad, tipo_producto '
                . 'WHERE producto.unidad=unidad.codigo AND tipo_producto.codigo = producto.tipo '
                . "$where");
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
                'inventario' => (int) $row['inventario'],
                'fecha' => $row['fecha_creacion'],
            );
        }
        return $pro;
    }

    public function totalProductos() {
        $query = $this->query("SELECT COUNT(*) AS total FROM `producto`");
        $pen = 0;
        while ($row = $query->fetch_array()) {
            $pen = (int) $row['total'];
        }
        return $this->getResponse($pen);
    }

    public function calcularStock($cod) {
        $fac = new Factura();
        $not = new Nota();
        $com = new Compra();
        $aju = new Ajuste();
        //salidas
        $factu = $fac->salidasValidas($cod);
        $notas = $not->salidasValidas($cod);
        $ajuSa = $aju->salidasValidas($cod);
        //entradas
        $ajuEn = $aju->entradasValidas($cod);
        $compr = $com->entradasValidas($cod);
        return ($ajuEn + $compr) - ($factu + $notas + $ajuSa);
    }

    public function stockAfecha($cod, $where) {
        $fac = new Factura();
        $not = new Nota();
        $com = new Compra();
        $aju = new Ajuste();
        //salidas
        $factu = $fac->salidasValidas($cod, $where);
        $notas = $not->salidasValidas($cod, $where);
        $ajuSa = $aju->salidasValidas($cod, $where);
        //entradas
        $ajuEn = $aju->entradasValidas($cod, $where);
        $compr = $com->entradasValidas($cod, $where);
        return ($ajuEn + $compr) - ($factu + $notas + $ajuSa);
    }

}
