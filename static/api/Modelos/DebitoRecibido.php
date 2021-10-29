<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modelos;

/**
 * Description of creditosRecibidos
 *
 * @author victo
 */
class DebitoRecibido extends \Prototipo\Notas {

    var $estado = 'DebitoRecibido';

    public function __construct() {
        parent::__construct();
        $this->tabla = 'debitos_recibidos_lista';
        $this->insert = 'debitosrecibidos';
        $this->detalle = 'detallesdebitosrecibidos';
        $this->rif = 'cod_proveedor';
        $this->ref = 'cod_compra';
    }
}
