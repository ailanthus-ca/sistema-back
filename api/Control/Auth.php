<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Control;

/**
 * Description of auth
 *
 * @author Ailanthus
 */
class Auth {

    function login() {
        $user = new \Modelos\Usuario();
        $email = $user->postString('correo');
        $clave = $user->postString('clave');
        return json_encode($user->login($email, $clave));
    }

    function token() {
        $auth = new \Auth();
        return json_encode(array('token' => $auth->generateToken()));
    }

    function me() {
        $auth = new \Auth();
        return json_encode($auth);
    }

    function close() {
        $auth = new \Auth();
        $auth->close();
    }

    function estado() {
        $estado = new \Config('estado');
        return json_encode($estado->get());
    }

    function migracion() {
        $c = new \Modelos\Configuracion();
        $factura = new \Config('factura');
        $factura->setMany($c->getFactura());
        $region = new \Config('region');
        $region->setMany($c->getRegion());
        $empresa = new \Config('empresa');
        $empresa->setMany($c->getEmpresa());
        $ventas = new \Config('ventas');
        return json_encode(array('factura' => $factura->cargar(), 'region' => $region->cargar(), 'empresa' => $empresa->cargar(), 'ventas' => $ventas->cargar()));
    }

}
