<?php

namespace Control;

class Usuario {

    function lista() {
        $Usuario = new \Modelos\Usuario();
        return json_encode($Usuario->lista());
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
        //return json_encode($role);
        return json_encode($role->actualizarRol($id));
    }

    function listar_permisos() {
        $permisos = new \Modelos\Auth();
        return json_encode($permisos->listar_permisos());
    }

}
