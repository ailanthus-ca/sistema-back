<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modelos;

class NotaClientes extends \conexion {

    var $id_factura = 0;
    var $tipo = "";
    var $descripcion = "";
    var $monto = 0;
    var $detalles = array();

    function lista() {
        $this->query("SELECT * FROM emitidas_lista");
        $data = array();
        while ($row = $sql->fetch_array()) {
            $data[] = array(
                'codigo' => $row['id'],
                'cod_documento' => $row['codigo'],
                'nombre' => $row['nombre'],
                'rif' => $row['rif'],
                'monto' => $row['monto'],
                'status' => $row['estatus'],
            );
        }
        return $data;
    }

    function nuevo() {
        $sql = $this->query('SELECT MAX(id) AS cant FROM emitidas_lista ');
        $row = $sql->fetch_array();
        $num_factura = $row['cant'] + 1;
        $this->query("INSERT INTO "
                . "notas_emitidas(cod_factura,descripcion,tipo,monto,estatus) "
                . "VALUES($this->id_factura,'$this->descripcion','$this->tipo',$this->monto,2)");
        foreach ($this->detalles as $pro) {
            $monto = $pro->unidades * $pro->precio;
            $this->query("INSERT INTO detallefactura VALUES " .
                    "('$num_factura',"
                    . "'$pro->codigo',"
                    . "$pro->unidades,"
                    . "$pro->precio,"
                    . "$monto )");
            $producto->cargar($pro->codigo);
            if ($producto->inventario !== 1 && $this->id_nota === 0)
                $producto->cargarStock($pro->codigo);
        }
    }

    function detalles() {
        
    }

    function cancelar() {
        
    }

}
