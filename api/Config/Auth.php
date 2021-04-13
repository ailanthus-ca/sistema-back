<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Auth
 *
 * @author Ailanthus
 */
class Auth extends Middleware {

    var $id_usuario = 0;
    var $usuario = '';
    var $nivel = 5;
    var $permisos = array();

    function __construct() {
        if (empty($_SESSION['usuario'])) {
            session_start();
        }
        if (empty($_SESSION['usuario'])) {
            $token = $this->getBearerToken();
            if (isset($token)) {
                $seccion = $this->getTokenSeccion();
                if (empty($seccion->fecha)) {
                    if (date('Y-m-d') === $seccion->fecha) {
                        $_SESSION['id_usuario'] = (int) $seccion->id_usuario;
                        $_SESSION['usuario'] = (string) $seccion->usuario;
                        $_SESSION['nivel'] = (int) $seccion->nivel;
                    }
                }
            }
        }
        if (!empty($_SESSION['usuario'])) {
            $this->id_usuario = (int) $_SESSION['id_usuario'];
            $this->usuario = (string) $_SESSION['usuario'];
            $this->nivel = (int) $_SESSION['nivel'];
        }
    }

    function isLog() {
        if ($this->id_usuario !== 0) {
            return true;
        }
        return false;
    }

}
