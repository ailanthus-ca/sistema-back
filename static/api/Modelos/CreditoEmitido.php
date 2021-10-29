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
class CreditoEmitido extends \Prototipo\Notas {

    var $estado = 'CreditosEmitidos';

    public function __construct() {
        parent::__construct();
        $this->tabla = 'creditos_emitidos_lista';
        $this->insert = 'creditosrecibidos';
        $this->detalle = 'detallescreditosemitidos';
        $this->rif = 'cod_cliente';
        $this->ref = 'cod_factura';
    }
}
