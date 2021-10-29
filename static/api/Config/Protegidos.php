<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Protegidos {

    //Modulos protegidos
    public $Modulos = array('NOTA', 'COTIZACION', 'ORDEN', 'PROVEEDOR', 'CLIENTE');
    public $CLIENTE = array(
        //Modulo ---> Metodos de CLIENTE
        'NOTA' => array('lista'),
        'COTIZACION' => array('lista'),
        'FACTURA' => array('lista'),
    );
    public $NOTA = array(
        //Modulo ---> Metodos de NOTA
        'FACTURA' => array('lista', 'detalles')
    );
    public $COTIZACION = array(
        //Modulo ---> Metodos de COTIZACION
        'FACTURA' => array('lista', 'detalles'),
        'NOTA' => array('lista', 'detalles'),
    );
    public $PROVEEDOR = array(
        //Modulo ---> Metodos de PROVEEDOR
        'ORDEN' => array('lista', 'detalles'),
        'COMPRA' => array('lista', 'detalles'),
    );
    public $ORDEN = array(
        //Modulo ---> Metodos de ORDEN
        'COMPRA' => array('lista', 'detalles'),
    );
    public function Permitir($Permisos, $obj, $operacion) {
        if (in_array($obj, $this->Modulos)) {
            foreach ($Permisos as $per) {
                if (isset($this->$obj[$per])) {
                    if (in_array($operacion, $this->$obj[$per]))
                        return true;
                }
            }
        }
        return false;
    }

}
