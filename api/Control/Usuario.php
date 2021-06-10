<?php

namespace Control;

class Usuario {

    function lista() {
        $Usuario = new \Modelos\Usuario();
        return json_encode($Usuario->lista());
    }

    function detalles($id){
        $Usuario = new \Modelos\Usuario();
        return json_encode($Usuario->detalles($id));
    }

    function nuevo(){
        $Usuario = new \Modelos\Usuario();
        $Usuario->nombre = $Usuario->postString("nombre");
        $Usuario->correo = $Usuario->postString("correo");
        $Usuario->clave = $Usuario->postString("clave");
        $Usuario->nivel = $Usuario->postString("nivel");

        if ($Usuario->nombre == '') {
            $Usuario->setError('El nombre es requerido');
        }

        if ($Usuario->correo == '') {
            $Usuario->setError('El email es requerido');
        }

        if (!filter_var($Usuario->correo, FILTER_VALIDATE_EMAIL)) {
            $Usuario->setError('Email mal escrito');
        }

        if ($Usuario->checkCorreo($Usuario->correo)) {
            $Usuario->setError('Este email ya esta siendo usado');
        }        

        if ($Usuario->clave == '') {
            $Usuario->setError('La clave es requerida');
        }

        if($Usuario->nivel == '') {
            $Usuario->setError('El nivel es requerido');
        }

        //Validar si hubo errores
        if ($Usuario->response > 300) {
            return json_encode($Usuario->getResponse());
        }

        return json_encode($Usuario->nuevo());
    }

    function actualizar($id){
        $Usuario = new \Modelos\Usuario();
        $Usuario->nombre = $Usuario->postString("nombre");
        $Usuario->correo = $Usuario->postString("correo");
        $Usuario->clave = $Usuario->postString("clave");
        $Usuario->nivel = $Usuario->postString("nivel");

        // Validar que exista codigo
        if (!$Usuario->checkCodigo($id)) {
            $Usuario->setError('El usuario no existe');
        }

        if ($Usuario->nombre == '') {
            $Usuario->setError('El nombre es requerido');
        }

        if ($Usuario->correo == '') {
            $Usuario->setError('El email es requerido');
        }

        if (!filter_var($Usuario->correo, FILTER_VALIDATE_EMAIL)) {
            $Usuario->setError('Email mal escrito');
        }

        if ($Usuario->checkCorreo($Usuario->correo)) {
            $Usuario->setError('Este email ya esta siendo usado');
        }

        if ($Usuario->clave == '') {
            $Usuario->setError('La clave es requerida');
        }

        if($Usuario->nivel == '') {
            $Usuario->setError('El nivel es requerido');
        }
        //Validar si hubo errores
        if ($Usuario->response > 300) {
            return json_encode($Usuario->getResponse());
        }

        return json_encode($Usuario->actualizar($id));
    }

    function cancelar($id){
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

    function eliminar_rol($id){
        $role = new \Modelos\Auth();
        $role->eliminarRol($id);
    }

    function listar_permisos() {
        $permisos = new \Modelos\Auth();
        return json_encode($permisos->listar_permisos());
    }

}
