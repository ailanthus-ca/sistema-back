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
        $sql = $this->query('SELECT usuario.*,roles.nombre as rol FROM usuario,roles WHERE roles.id=usuario.nivel');
        while ($row = $sql->fetch_array()) {
            $cl[] = array(
                'codigo' => (int) $row['codigo'],
                'nombre' => $row['nombre'],
                'correo' => $row['correo'],
                'rol' => $row['rol'],
                'nivel' => (int) $row['nivel'],
                'estado' => (int) $row['estatus']
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
                return array('error' => 'CLAVE ERRADA');
            }
        } else {
            header("HTTP/1.0 401 Success");
            return array('error' => 'CORREO NO EXISTE');
        }
    }

    function clave($id) {
        $clave = \crypt($this->clave);
        $this->query("UPDATE usuario SET " .
                "clave = '$clave', " .
                "WHERE codigo = $id ");
        return $this->getResponse(1);
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

    function checkCorreo($correo) {
        $sql = $this->query("SELECT COUNT(*) AS exist FROM `usuario` WHERE correo = '$correo'");
        if ($row = $sql->fetch_array()) {
            return boolval($row['exist']);
        }
    }

    function nuevo() {
        $mi = new \Middleware();
        // $clave = \crypt($this->clave, $mi->key);
        $clave = \crypt($this->clave);
        $sql = $this->query('SELECT MAX(codigo) AS cant FROM usuario');
        $row = $sql->fetch_array();
        $cod = $row['cant'] + 1;
        $this->query("INSERT INTO usuario VALUES("
                . "$cod,"
                . "UPPER('$this->nombre'), "
                . "UPPER('$this->correo'), "
                . "'$clave', "
                . "$this->nivel, "
                . "1) ");
        $this->codigo = $this->con->insert_id;
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
                        . "WHERE codigo = $id ");
            } else {
                $this->query("UPDATE usuario SET "
                        . "estatus = 1 "
                        . "WHERE codigo = $id ");
            }
            $this->actualizarEstado();
            return $this->getResponse(true);
        }
    }
    
    public function getVendedores() {
        $cl = array();
        $sql = $this->query("SELECT DISTINCT usuario.* FROM `usuario`,permisos_roles,permisos WHERE nivel = id_role AND id_permiso = id AND permisos.nombre='VENDEDOR' AND usuario.estatus=1");
        while ($row = $sql->fetch_array()) {
            $cl[] = array(
                'codigo' => (int) $row['codigo'],
                'nombre' => $row['nombre'],
                'correo' => $row['correo'],
                'nivel' => (int) $row['nivel'],
                'estado' => (int) $row['estatus']
            );
        }
        return $this->getResponse($cl);
    }
}
