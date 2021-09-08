<?php

namespace Control;

class Usuario {

    function lista() {
        $Usuario = new \Modelos\Usuario();
        return json_encode($Usuario->lista());
    }

    function detalles($id) {
        $Usuario = new \Modelos\Usuario();
        return json_encode($Usuario->detalles($id));
    }

    function nuevo() {
        $Usuario = new \Modelos\Usuario();
        $Usuario->nombre = $Usuario->postString("nombre");
        $Usuario->correo = $Usuario->postString("correo");
        $Usuario->clave = $Usuario->postString("clave");
        $Usuario->nivel = $Usuario->postString("nivel");


        if ($Usuario->nombre == '') {
            $Usuario->setError(array('nombre' => 'El nombre es requerido'));
        }

        if ($Usuario->nivel < 0) {
            $Usuario->setError(array('nivel' => 'El rol es requerido'));
        }

        if ($Usuario->correo == '') {
            $Usuario->setError(array('correo' => 'El email es requerido'));
        } elseif (!filter_var($Usuario->correo, FILTER_VALIDATE_EMAIL)) {
            $Usuario->setError(array('correo' => 'Email mal escrito'));
        } elseif ($Usuario->checkCorreo($Usuario->correo)) {
            $Usuario->setError(array('correo' => 'Este email ya esta siendo usado'));
        }

        if ($Usuario->clave == '') {
            $Usuario->setError(array('clave' => 'La clave es requerida'));
        }

        //Validar si hubo errores
        if ($Usuario->response > 300) {
            return json_encode($Usuario->getResponse());
        }

        return json_encode($Usuario->nuevo());
    }

    function actualizar($id) {
        $Usuario = new \Modelos\Usuario();
        $Usuario->nombre = $Usuario->postString("nombre");
        $Usuario->correo = $Usuario->postString("correo");
        $Usuario->clave = $Usuario->postString("clave");
        $Usuario->nivel = $Usuario->postIntenger("nivel");

        // Validar que exista codigo
        if (!$Usuario->checkCodigo($id)) {
            $Usuario->setError(array('id' => 'El usuario no existe'));
        }

        if ($Usuario->nombre == '') {
            $Usuario->setError(array('nombre' => 'El nombre es requerido'));
        }

        if ($Usuario->nivel < 0) {
            $Usuario->setError(array('nivel' => 'El rol es requerido'));
        }

        if ($Usuario->correo == '') {
            $Usuario->setError(array('correo' => 'El email es requerido'));
        } elseif (!filter_var($Usuario->correo, FILTER_VALIDATE_EMAIL)) {
            $Usuario->setError(array('correo' => 'Email mal escrito'));
        } elseif ($Usuario->checkCorreo($Usuario->correo)) {
            $Usuario->setError(array('correo' => 'Este email ya esta siendo usado'));
        }
        
        //Validar si hubo errores
        if ($Usuario->response > 300) {
            return json_encode($Usuario->getResponse());
        }

        return json_encode($Usuario->actualizar($id));
    }

    function clave($id){
        $Usuario = new \Modelos\Usuario();
        $Usuario->clave = $Usuario->postString("clave");
        return json_encode($Usuario->clave($id));        
    }
    function cancelar($id) {
        $Usuario = new \Modelos\Usuario();
        return json_encode($Usuario->cancelar($id));
    }

    function actual() {
        return json_encode($_SESSION);
    }

    function getToken() {
        $m = new \Middleware();
        return $m->getBearerToken();
    }

    function PruebaToken() {
        $m = new \Middleware();
        return $m->safeDecrypt($m->getBearerToken());
    }

    function listar_roles() {
        $roles = new \Modelos\Auth();
        return json_encode($roles->listar_roles());
    }

    function detalles_rol($id) {
        $roles = new \Modelos\Auth();
        return json_encode($roles->detalles_rol($id));
    }

    function nuevo_rol() {
        $role = new \Modelos\Auth();
        $role->nombre = $role->postString("nombre");
        $role->permisos = $role->postArray("permisos");
        return json_encode($role->nuevo_rol());
    }

    function actualizar_rol($id) {
        $role = new \Modelos\Auth();
        $role->nombre = $role->postString("nombre");
        $role->permisos = $role->postArray("permisos");
        return json_encode($role->actualizarRol($id));
    }

    function eliminar_rol($id) {
        $role = new \Modelos\Auth();
        $role->eliminarRol($id);
    }

    function listar_permisos() {
        $permisos = new \Modelos\Auth();
        return json_encode($permisos->listar_permisos());
    }

}
