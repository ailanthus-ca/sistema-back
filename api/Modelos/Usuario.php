<?php

namespace Modelos;

class Usuario extends \conexion {

    var $estado = 'Usuario';
    var $codigo = '';
    var $nombre = '';
    var $correo = '';
    var $clave = '';
    var $nivel = '';

    function lista() {
        $cl = array();
        $sql = $this->query('SELECT * FROM usuario WHERE estatus=1');
        while ($row = $sql->fetch_array()) {
            $cl[] = array(
                'codigo' => $row['codigo'],
                'nombre' => $row['nombre'],
                'correo' => $row['correo']
            );
        }
        return $this->getResponse($cl);
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

    function detalles($id) {
        $sql = $this->query("SELECT * FROM usuario WHERE codigo = $id");
        if ($row = $sql->fetch_array()) {
            $data = array(
                'codigo' => $row['codigo'],
                'nombre' => $row['nombre'],
                'correo' => $row['correo']
            );
            return $this->getResponse($data);
        } else {
            return $this->getResponse(array(
                        'codigo' => '',
                        'nombre' => '',
                        'correo' => '')
            );
        }
    }

    function checkCodigo($cod) {
        $sql = $this->query("SELECT count(*) AS exist FROM usuario WHERE codigo= $cod");
        if ($row = $sql->fetch_array()) {
            return boolval($row['exist']);
        }
    }

    function nuevo() {
        $this->query("INSERT INTO usuario(nombre,correo,clave,nivel,estatus) VALUES("
                . "UPPER('$this->nombre'),"
                . "UPPER('$this->correo'),"
                . "$this->clave,"
                . "UPPER('$this->nivel'),"
                . "1)");
        $this->codigo = $this->con->insertId();
        $this->actualizarEstado();
        return $this->getResponse($this->detalles($this->codigo));
    }

    function actualizar($id) {
        $this->query("UPDATE usuario SET " .
                "nombre = UPPER('$this->nombre'), " .
                "correo = UPPER('$this->correo'), " .
                "nivel = '$this->nivel'" .
                "WHERE codigo = $id ");
        $this->actualizarEstado();
        return $this->getResponse($this->detalles($id));
    }

    public function cancelar($id) {
        $sql = $this->query("SELECT * FROM usuario WHERE codigo= $id ");
        if ($row = $sql->fetch_array()) {
            if ($row['estatus'] === '1') {
                $this->query("UPDATE usuario SET "
                        . "estatus = 0 "
                        . "WHERE codigo = '$id' ");
            } else {
                $this->query("UPDATE usuario SET "
                        . "estatus = 1 "
                        . "WHERE codigo = '$id' ");
            }
            $this->actualizarEstado();
            return $this->getResponse(true);
        }
    }

}
