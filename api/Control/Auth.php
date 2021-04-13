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
        return $user->login($email, $clave);
    }
    function getToken(){
        
    }
}
