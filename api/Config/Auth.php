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
    var $nivel = -1;
    var $fecha = '';
    var $rol = '';
    var $permisos = array();

    function __construct() {
        $this->fecha = date('Y-m-d');
        if (!isset($_SESSION)) {
            session_start();
        }
        $this->cargar();
    }

    function isLog() {
        if ($this->id_usuario !== 0) {
            return true;
        }
        return false;
    }

    function cargar() {
        if (empty($_SESSION['usuario'])) {
            $this->setTokenSeccion();
        }
        $this->setPHPSeccion();
    }

    function generateToken() {
        if ($this->id_usuario !== 0)
            $this->cargar();
        if ($this->id_usuario !== 0) {
            $this->getPermisos();
            $data = json_encode($this);
            $token = $this->safeEncrypt($data);
            return $token;
        }
    }

    function setPHPSeccion() {
        if (!empty($_SESSION['usuario'])) {
            $this->id_usuario = (int) $_SESSION['id_usuario'];
            $this->usuario = (string) $_SESSION['usuario'];
            $this->nivel = (int) $_SESSION['nivel'];
            if (empty($_SESSION['permisos'])) {
                $this->setPermisos();
                $_SESSION['rol'] = $this->rol;
                $_SESSION['permisos'] = $this->permisos;
            } else {
                $this->rol = (string) $_SESSION['rol'];
                $this->permisos = $_SESSION['permisos'];
            }
        }
    }

    function setTokenSeccion() {
        $token = $this->getBearerToken();
        if (isset($token)) {
            $seccion = $this->getTokenSeccion();
            if (empty($seccion->fecha)) {
                if ($this->fecha === $seccion->fecha) {
                    $_SESSION['id_usuario'] = (int) $seccion->id_usuario;
                    $_SESSION['usuario'] = (string) $seccion->usuario;
                    $_SESSION['nivel'] = (int) $seccion->nivel;
                    $_SESSION['rol'] = (string) $this->rol;
                    $_SESSION['permisos'] = $seccion->permisos;
                }
            }
        }
    }

    function getTokenSeccion() {
        $token = $this->getBearerToken();
        $data = $this->safeDecrypt($token);
        return json_decode($data);
    }

    function setPermisos() {
        $auth = new \Modelos\Auth();
        $rol = $auth->detalles_rol($this->nivel);
        $this->rol = $rol['nombre'];
        $this->permisos = $rol['permisos'];
        if (empty($_SESSION['permisos'])) {
            $_SESSION['rol'] = $this->rol;
            $_SESSION['permisos'] = $this->permisos;
        }
    }

    function getPermisos() {
        if (count($this->permisos) == 0)
            $this->setPermisos();
        return $this->permisos;
    }

    function close() {
        $_SESSION = array();
        session_destroy();
    }

}
