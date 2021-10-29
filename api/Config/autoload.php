<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class autoload {

    public static function run() {
        spl_autoload_register(function($class) {
            $ruta = str_replace("\\", "/", $class) . ".php";
            if (file_exists(DR . "/Config/" . $ruta)) {
                include DR . "/Config/" . $ruta;
            } 
            if (file_exists(DR ."/". $ruta)) {
                include DR ."/". $ruta;
            }
        });
    }

}
