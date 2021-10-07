<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Prototipo;

/**
 * Description of newPHPClass
 *
 * @author victo
 */
class Notas extends \conexion {

    protected $tabla;
    protected $insert;
    protected $detalle;
    protected $rif;
    protected $ref;
    public $cod_rif = '';
    public $cod_ref = '';
    public $descripcion = '';
    public $nota = '';
    public $monto = 0;
    public $iva = 0;
    public $detalles = [];

    public function recibir() {
        $this->cod_rif = $this->postString($this->rif);
        $this->cod_ref = $this->postIntenger($this->ref);
        $this->descripcion = $this->postString("descripcion");
        $this->monto = $this->postFloat("monto");
        $this->iva = $this->postFloat("iva");
        $this->detalles = $this->postArray("detalles");
    }

    //put your code here
    public function lista() {
        $pen = array();
        $query = $this->query("SELECT * FROM $this->tabla");
        while ($row = $query->fetch_array()) {
            $detalle = array();
            $sql = $this->query("SELECT producto FROM $this->detalle WHERE nota = " . $row['codigo']);
            while ($row2 = $sql->fetch_array()) {
                $detalle[] = $row2['producto'];
            }
            $pen[] = array(
                'codigo' => (int) $row['codigo'],
                'ref' => $row[$this->ref],
                'rif' => $row[$this->rif],
                'fecha' => $row['fecha'],
                'nombre' => $row['nombre'],
                'monto' => (float) $row['monto'],
                'usuario' => (int) $row['usuario'],
                'estado' => (int) $row['estado'],
                $detalle
            );
        }
        return $this->getResponse($pen);
    }

    function detalles($id) {
        $sql = "SELECT * FROM $this->tabla where codigo = $id";
        $query = $this->query($sql);
        if ($row = $query->fetch_array()) {
            $sql = $this->query("SELECT producto FROM $this->detalle WHERE nota = " . $row['codigo']);
            while ($row = $sql->fetch_array()) {
                $detalle = $producto->ver($row['producto']);
                $detalle['unidades'] = (float) $row['cantidad'];
                $detalle['precio'] = (float) $row['precio'];
            }
            return array(
                'codigo' => (int) $row['codigo'],
                'ref' => $row[$this->ref],
                'rif' => $row[$this->rif],
                'fecha' => $row['fecha'],
                'nombre' => $row['nombre'],
                'monto' => (float) $row['monto'],
                'usuario' => (int) $row['usuario'],
                'estado' => (int) $row['estado'],
                $detalle
            );
        } else {
            return $this->getNotFount('nota no encontrada');
        }
    }

    function nuevo() {
        //usuario
        $user = $_SESSION['id_usuario'];
        $sql = $this->query("SELECT COUNT(*) as cant FROM `$this->insert`");
        $row = $sql->fetch_array();
        $cod = $row['cant'] + 1;
        $dolar = new \Modelos\Dolares();
        $tasa = $dolar->valor();
        $this->query("INSERT INTO `$this->tabla` VALUES ("
                . "'$cod',"
                . "'$this->cod_ref',"
                . "'$this->cod_rif',"
                . "'$this->num_con',"
                . "NOW(),"
                . "'$this->descripcion',"
                . "$this->monto, "
                . "$this->iva,"
                . "$this->total,"
                . "2,"
                . "$user)");
        //;
        $productos = new \Modelos\Producto();
        foreach ($this->detalles as $iten) {
            $monto = $iten->unidades * $iten->precio;
            $this->query("INSERT INTO `$this->detalle` VALUES("
                    . "$cod,"
                    . "'$iten->codigo',"
                    . "$iten->unidades,"
                    . "$iten->precio)");
            $config = new \Config('costo');
            $productos->cargar($iten->codigo);
            if ($productos->inventario !== 1) {
                $productos->cargarStock($iten->codigo);
            }
        }
        $this->actualizarEstado();
        return $this->getResponse($cod);
    }

    function cancelar($id) {
        $query = $this->query("UPDATE `$this->tabla` SET `estatus`= 0 WHERE codigo = $id");
        $sql2 = $this->query("select * from $this->detalle where cod_compra = '$id' ");
        $productos = new \Modelos\Producto();
        while ($row = $sql2->fetch_array()) {
            $productos->cargarStock($row['cod_producto']);
        }
        $this->actualizarEstado();
        return 1;
    }

    function operacionesValidas($codigo, $where) {
        $query = $this->query("SELECT "
                . "SUM( cantidad ) as cantidad "
                . "FROM $this->detalle, $this->tabla WHERE "
                . "producto = '$codigo' AND $where "
                . "codigo = nota AND "
                . "estatus > 0");
        while ($row = $query->fetch_array()) {
            return (float) $row['cantidad'];
        }
        return 0;
    }

    function entradasValidas($codigo, $where = '') {
        return $this->operacionesValidas($codigo, $where);
    }

    function salidasValidas($codigo, $where = '') {
        return $this->operacionesValidas($codigo, $where);
    }

}
