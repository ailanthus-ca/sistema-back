<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Request {

    private $modulo = '';
    private $operacion = '';
    private $parametro = '';

    public function __construct() {
        if (isset($_GET['url'])) {
            $ruta = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
            $ruta = explode("/", $ruta);
            $ruta = array_filter($ruta);
            if (isset($ruta[0]))
                $this->modulo = $ruta[0];
            if (isset($ruta[1]))
                $this->operacion = $ruta[1];
            if (isset($ruta[2]))
                $this->parametro = $ruta[2];
        }
    }

    public function getmodulo() {
        return $this->modulo;
    }

    public function getoperacion() {
        return $this->operacion;
    }

    public function getparametro() {
        return $this->parametro;
    }

}
