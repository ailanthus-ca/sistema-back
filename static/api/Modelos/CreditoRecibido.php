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
class CreditoRecibido extends \Prototipo\Notas {

    var $estado = 'CreditoRecibido';

    public function __construct() {
        parent::__construct();
        $this->tabla = 'creditos_recibidos_lista';
        $this->insert = 'creditosrecibidos';
        $this->detalle = 'detallescreditosrecibidos';
        $this->rif = 'cod_proveedor';
        $this->ref = 'cod_compra';
    }
}
