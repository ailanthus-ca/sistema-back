<?php

namespace Modelos;

class Usuario extends \conexion {

    function lista() {
        $cl = array();
        $sql = $this->query('SELECT * FROM usuario WHERE estatus=1');
        while ($row = $sql->fetch_array()) {
            $cl[] = array(
                'codigo' => $row['codigo'],
                'nombre' => $row['nombre'],
                'correo' => $row['correo'],
                'clave' => $row['clave']
            );
            return $this->getResponse($cl);
        }
    }

    function login($emil, $clave) {
        $auth = new \Auth();
        $sql = $this->query("SELECT * FROM usuario WHERE correo = '$emil' ");
        if ($user = $sql->fetch_array()) {
            if ($user['clave'] == crypt($clave, $user['clave']) && $user['estatus'] == 1) {
                $_SESSION['id_usuario'] = $user['codigo'];
                $_SESSION['usuario'] = $user['nombre'];
                $_SESSION['nivel'] = $user['nivel'];
                $auth->setPHPSeccion();
                $auth->setPermisos();
                return $this->getResponse(array(
                            'token' => $auth->generateToken(),
                            'user' => $_SESSION
                ));
            } else {
                header("HTTP/1.0 401 Success");
                return array('error' => 'clave errada');
            }
        } else {
            header("HTTP/1.0 401 Success");
            return array('error' => 'correo no existe');
        }
    }

}
