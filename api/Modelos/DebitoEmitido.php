<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modelos;

/**
 * Description of creditosEmitidos
 *
 * @author victo
 */
class DebitoEmitido extends \Prototipo\Notas {

    var $estado = 'DebitoEmitido';

    public function __construct() {
        parent::__construct();
        $this->tabla = 'debitos_emitidos_lista';
        $this->insert = 'debitosemitidos';
        $this->detalle = 'detallesdebitosemitidos';
        $this->rif = 'cod_cliente';
        $this->ref = 'cod_factura';
    }
}
