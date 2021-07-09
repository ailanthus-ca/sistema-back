<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Publicos {

    public static function Modulos() {
        return array('USUARIO', 'PRODUCTO', 'MONEDA', 'CONFIG');
    }

    public static function USUARIO() {
        return array('lista');
    }

    public static function PRODUCTO() {
        return array('lista', 'detalles');
    }

    public static function MONEDA() {
        return array('lista', 'detalles');
    }

    public function CONFIG() {
        return array('get', 'contadores');
    }

}
