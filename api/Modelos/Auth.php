<?php

namespace Modelos;

class Auth extends \conexion {

    var $nombre = '';
    var $permisos = array();

    public function listar_roles() {
        $roles = array();
        $sql = $this->con->query("SELECT * FROM roles");
        while ($row = $sql->fetch_array()) {
            $roles[] = array(
                'id' => $row['id'],
                'nombre' => $row['nombre']
            );
        }

        return $this->getResponse($roles);
    }

    public function detalles_rol($id) {
        $sql = $this->query("SELECT * from roles where id = '$id' ");
        $data = array();
        if ($row = $sql->fetch_array()) {
            $data['id'] = $row['id'];
            $data['nombre'] = $row['nombre'];
            $p = $this->query("SELECT id_permiso from permisos_roles where id_role = " . $data['id']);
            $permisos = array();
            while ($row = $p->fetch_array()) {
                $permisos[] = $this->nombre_permiso($row['id_permiso']);
            }
            $data['permisos'] = $permisos;
            return $this->getResponse($data);
        } else {
            $this->getNotFount();
            return $this->getResponse(array());
        }
    }

    public function nuevo_rol() {
        $this->query("INSERT INTO roles(nombre) VALUES("
                . "UPPER('$this->nombre'))");
        $id_rol = $this->con->insert_id;
        foreach ($this->permisos as $per) {
            $this->query("INSERT INTO permisos_roles VALUES("
                    . "$per, "
                    . "$id_rol)");
        }
        return $this->getResponse($this->detalles_rol($id_rol));
    }

    public function actualizarRol($id) {
        $this->query("UPDATE roles SET " .
                "nombre = UPPER('$this->nombre'), " .
                "WHERE id = 0$id");
        $this->query("DELETE FROM `permisos_roles` WHERE id_role = 0$id");
        foreach ($this->permisos as $per) {
            $this->query("INSERT INTO permisos_roles VALUES("
                    . "$per, "
                    . "0$id)");
        }
        return $this->getResponse($this->detalles_rol($id));
        $this->getNotFount();
        return $this->getResponse();
    }

    function checkNivelUsuario($nivel) {
        $sql = $this->query("SELECT count(*) AS exist FROM usuario WHERE nivel=0$nivel");
        if ($row = $sql->fetch_array()) {
            return (intval($row['exist']) > 0);
        }
    }

    public function eliminarRol($id) {
        if ($this->checkNivelUsuario($id)) {
            $this->setError('EXISTEN USUARIOS CON ESTE ROL NO SE PUEDE ELIMINAR');
        }
        return $this->getResponse();
        $this->query("DELETE FROM `permisos_roles` WHERE id_role = 0$id");
        $this->query("DELETE roles WHERE id = 0$id");
        return json_encode(['ok' => 'rol elimiado']);
    }

    public function listar_permisos() {
        $permisos = array();
        $sql = $this->con->query("SELECT * FROM permisos");
        while ($row = $sql->fetch_array()) {
            $permisos[] = array(
                'id' => $row['id'],
                'nombre' => $row['nombre']
            );
        }
        return $this->getResponse($permisos);
    }

    function nombre_permiso($id) {
        $sql = $this->query("SELECT nombre from permisos where id = $id");
        if ($row = $sql->fetch_array()) {
            return $row['nombre'];
        }
    }

}
