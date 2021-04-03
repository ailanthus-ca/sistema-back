<?php

namespace Prototipo;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Operaciones
 *
 * @author victo
 */
class Operaciones extends \conexion {

    protected $con;
    //variables generales 
    var $codigo = 0;
    var $nota = '';
    var $impuesto = 0;
    var $subtotal = 0;
    var $total = 0;
    var $forma_pago = '';
    var $tiempo_entrega = '';
    var $validez = '';
    var $detalles = array();

    protected function getDataGeneral() {
        $this->nota = $this->postString("nota");
        $this->impuesto = $this->postFloat("impuesto");
        $this->subtotal = $this->postFloat("subtotal");
        $this->total = $this->postFloat("total");
        $this->detalles = $this->postArray("detalles");
    }

    protected function getCondiciones() {
        $this->getDataGeneral();
        $this->forma_pago = $this->postString("forma_pago");
        $this->tiempo_entrega = $this->postString("tiempo_entrega");
        $this->validez = $this->postString("validez");
    }

}
