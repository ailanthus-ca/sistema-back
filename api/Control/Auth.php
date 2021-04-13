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

    function listar_roles(){
    	$roles = new \Modelos\Auth();
    	return json_encode($roles->listar_roles());
    }

    function detalles_rol($id){
        $roles = new \Modelos\Auth();
        return json_encode($roles->detalles_rol($id));
    }

    function listar_permisos(){
    	$permisos = new \Modelos\Auth();
    	return json_encode($permisos->listar_permisos());
    }

    function nuevo_rol(){
        $role = new \Modelos\Auth();
        $role->nombre = $role->postString("nombre");
        return json_encode($role->nuevo_rol());

    }
}
