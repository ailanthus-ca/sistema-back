<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modelos;

class NotaCredito extends \conexion {

    var $id_factura = 0;
    var $tipo = "";
    var $descripcion = "";

    function lista() {
        $this->query("");
    }

    function nuevo() {
        
    }

    function detalles() {
        
    }

    function cancselar() {
        
    }

    function finalizar() {
        
    }

}
