<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Control;

/**
 * Description of Config
 *
 * @author victo
 */
class Config {
    
    function getRegion() {
        $config =new \Modelos\Configuracion();
        return json_encode($config->getRegion());
    }

    function getFactura() {
        $config =new \Modelos\Configuracion();
        return json_encode($config->getFactura());
    }

    function getVentas() {
        $config =new \Modelos\Configuracion();
        return json_encode($config->getVentas());
    }

    function getEmpresa() {
        $config =new \Modelos\Configuracion();
        return json_encode($config->getEmpresa());
    }
}
