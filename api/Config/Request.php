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
    private $parametro1 = '';
    private $parametro2 = '';
    private $parametro3 = '';
    private $parametro4 = '';
    private $parametro5 = '';

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
            if (isset($ruta[3]))
                $this->parametro1 = $ruta[3];
            if (isset($ruta[4]))
                $this->parametro2 = $ruta[4];
            if (isset($ruta[5]))
                $this->parametro3 = $ruta[5];
            if (isset($ruta[6]))
                $this->parametro4 = $ruta[6];
            if (isset($ruta[7]))
                $this->parametro5 = $ruta[7];
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

    public function getparametro2() {
        return $this->parametro1;
    }

    public function getparametro3() {
        return $this->parametro2;
    }

    public function getparametro4() {
        return $this->parametro3;
    }

    public function getparametro5() {
        return $this->parametro4;
    }

    public function getparametro6() {
        return $this->parametro5;
    }

}
