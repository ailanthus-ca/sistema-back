<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Control;

/**
 * Description of Dolares
 *
 * @author victo
 */
class Dolares {

    function grafica() {
        $dolar = new \Modelos\Dolares();
        return json_encode($dolar->grafica());
    }

    function valor() {
        $dolar = new \Modelos\Dolares();
        return json_encode($dolar->valor());
    }

    function set() {
        $dolar = new \Modelos\Dolares();
        $dolar->valor = $dolar->postFloat('valor');
        return json_encode($dolar->set());
    }

}
