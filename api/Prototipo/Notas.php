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
class NotasCliente extends \conexion {

    protected $tabla;
    protected $insert;
    protected $detalles;
    protected $rif;
    protected $ref;
    public $nota = '';
    public $monto = 0;
    public $iva = 0;

    //put your code here
    public function lista() {
        $pen = array();
        $query = $this->query("SELECT * FROM $this->tabla");
        while ($row = $query->fetch_array()) {
            $detalle = array();
            $sql = $this->query("SELECT producto FROM $this->detalles WHERE nota = " . $row['codigo']);
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
        $compra = array();
        if ($row = $query->fetch_array()) {
            //datos del proveedor
            $proveedor = new Proveedor();
            $compra = $proveedor->detalles($row['cod_proveedor']);
            $compra['cod_proveedor'] = $row['cod_proveedor'];
            //datos del usuario
            $usuario = new Usuario();
            $user = $usuario->detalles($row['usuario']);
            $compra['usuario'] = $user['nombre'];
            $compra['cod_usuario'] = (int) $row['usuario'];
            //datos de la compra
            $compra['codigo'] = (int) $row['codigo'];
            $compra['fecha'] = $row['fecha'];
            $compra['cod_documento'] = $row['cod_documento'];
            $compra['nun_control'] = $row['nun_control'];
            $compra['fecha_documento'] = $row['fecha_documento'];
            $compra['nota'] = $row['nota'];
            $compra['dolar'] = $row['dolar'];
            $compra['estatus'] = (int) $row['estatus'];
            $compra['impuesto'] = (float) $row['impuesto'];
            //Detalle de la compra
            $compra['detalles'] = array();
            $sql = "SELECT * from detallecompra where cod_compra = '" . $compra['codigo'] . "'";
            $query = $this->query($sql);
            $producto = new Producto();
            while ($row = $query->fetch_array()) {
                $detalle = $producto->ver($row['cod_producto']);
                $detalle['unidades'] = (float) $row['cantidad'];
                $detalle['precio'] = (float) $row['precio_unit'];
                $compra['detalles'][] = $detalle;
            }
            return $compra;
        } else {
            return $this->getNotFount('compra no encontrada');
        }
    }

    function nuevo() {
        //usuario
        $user = $_SESSION['id_usuario'];
        $sql = $this->query('SELECT COUNT(*) as cant FROM `compra`');
        $row = $sql->fetch_array();
        $cod_compra = $row['cant'] + 1;
        $dolar = new \Modelos\Dolares();
        $tasa = $dolar->valor();
        $this->query("INSERT INTO compra VALUES ("
                . "'$cod_compra',"
                . "'$this->cod_proveedor',"
                . "'$this->cod_documento',"
                . "'$this->num_con',"
                . "NOW(),"
                . "'$this->fecha_doc',"
                . "$this->subtotal, "
                . "$this->impuesto,"
                . "$this->total,"
                . "'$this->nota',"
                . "$user,"
                . "$this->etatus,"
                . "$tasa)");
        //;
        $productos = new \Modelos\Producto();
        foreach ($this->detalles as $iten) {
            $monto = $iten->unidades * $iten->precio;
            $this->query("INSERT INTO `detallecompra` VALUES("
                    . "$cod_compra,"
                    . "'$iten->codigo',"
                    . "$iten->unidades,"
                    . "$iten->precio,"
                    . "$monto)");
            $config = new \Config('costo');
            $productos->cargar($iten->codigo);
            if ($productos->inventario !== 1) {
                $productos->cargarStock($iten->codigo);
            }
            $costo = $config->get();
            if ($costo['costo'] < 3) {
                if ($costo['costo'] === 2 && $productos->checkCosto($iten->precio, $tasa))
                    $productos->costo($iten->codigo, $iten->precio, $tasa);
                elseif ($costo['costo'] === 1)
                    $productos->costo($iten->codigo, $iten->precio, $tasa);
            }
        }
        if ($this->id_orden > 0) {
            $orden = new \Modelos\Orden();
            $orden->procesar($this->id_orden);
        }
        $this->actualizarEstado();
        return $this->getResponse($cod_compra);
    }

    function cancelar($id) {
        $query = $this->query("UPDATE `compra` SET `estatus`= 0 WHERE codigo = $id");
        $sql2 = $this->query("select * from detallecompra where cod_compra = '$id' ");
        $productos = new \Modelos\Producto();
        while ($row = $sql2->fetch_array()) {
            $productos->cargarStock($row['cod_producto']);
        }
        $this->actualizarEstado();
        return 1;
    }

}
