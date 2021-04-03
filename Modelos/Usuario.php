<?php

namespace Modelos;

class Usuario extends \conexion {

    function lista() {
        $cl = array();
        $sql = $this->con->query('SELECT * FROM usuario WHERE estatus=1');
        while ($row = $sql->fetch_array()) {
            $cl[] = array(
                'codigo' => $row['codigo'],
                'nombre' => $row['nombre'],
                'correo' => $row['correo'],
                'clave' => $row['clave']
            );
        }
        return $cl;
    }

    function actual() {
        echo $_SESSION['id_usuario'];
    }

}
