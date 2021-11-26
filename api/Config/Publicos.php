<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Publicos {

    public $Modulos = array('USUARIO', 'PRODUCTO', 'MONEDA', 'CONFIG', 'DEPARTAMENTO');
    //Listas publicas
    public $USUARIO = array('lista');
    public $PRODUCTO = array('lista', 'detalles', 'cambios');
    public $DEPARTAMENTO = array('lista', 'detalles');
    public $MONEDA = array('lista', 'detalles');
    public $CONFIG = array('get', 'contadores');
    //Graficas 
    public $FACTURA = array('torta', 'linea', 'linea', 'utilidad', 'equilibrio', 'mejor_mes');
    public $COTIZACION = array('torta', 'linea');
    public $COMPRA = array('torta');
    public $NOTA = array('torta');
    public $DOLARES = array('grafica', 'valor', 'formatter');

}
