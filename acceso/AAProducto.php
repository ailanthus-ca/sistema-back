<?php

class producto {

    function listar() {
        require "../config/conexion.php";
        $pro = array();
        $sql = $con->query('SELECT * FROM producto WHERE estatus = 1 AND departamento!=""') or die($con->error);
        while ($row = $sql->fetch_array()) {
            $pro[] = array(
                'codigo' => $row['codigo'],
                'departamento' => $row['departamento'],
                'descripcion' => $row['descripcion'],
                'estatus' => $row['estatus'],
                'enser' => $row['enser'],
                'tipo' => $row['tipo'],
                'costo' => (float) $row['costo'],
                'precio1' => (float) $row['precio1'],
                'precio2' => (float) $row['precio2'],
                'precio3' => (float) $row['precio3'],
                'cantidad' => (int) $row['cantidad'],
            );
        }
        //$test=new stdClass();
        //$test->data=$pro;
        //$test->codigo = $_SESSION['id_usuario'];
        echo json_encode($pro);
    }

    function tipo_producto() {
        require "../config/conexion.php";
        $tp = array();
        $sql = $con->query('SELECT codigo,descripcion FROM tipo_producto WHERE estatus = 1 LIMIT 0,40');
        while ($row = $sql->fetch_array()) {
            $tp[] = array(
                'codigo' => $row['codigo'],
                'descripcion' => $row['descripcion']
            );
        }
        echo json_encode($tp);
    }

    function unidad_medida_producto() {
        require "../config/conexion.php";
        $un = array();
        $sql = $con->query('SELECT codigo,descripcion FROM unidad WHERE estatus = 1 ');
        while ($row = $sql->fetch_array()) {
            $un[] = array(
                'codigo' => $row['codigo'],
                'descripcion' => $row['descripcion']
            );
        }
        echo json_encode($un);
    }

    function departamentos() {
        require "../config/conexion.php";
        $de = array();
        $sql = $con->query("SELECT codigo,descripcion FROM departamento WHERE estatus = 1");
        while ($row = $sql->fetch_array()) {
            $de[] = array(
                'codigo' => $row['codigo'],
                'descripcion' => $row['descripcion'],
            );
        }
        echo json_encode($de);
    }

    function ver($cod) {
        require "../config/conexion.php";
        $sql = $con->query('SELECT * FROM producto WHERE codigo="' . $cod . '"');
        while ($row = $sql->fetch_array()) {
            $pro = array(
                'codigo' => $row['codigo'],
                'departamento' => $row['departamento'],
                'descripcion' => $row['descripcion'],
                'tipo' => $row['tipo'],
                'enser' => $row['enser'],
                'unidad' => $row['unidad'],
                'costo' => (float) $row['costo'],
                'precio1' => (float) $row['precio1'],
                'precio2' => (float) $row['precio2'],
                'precio3' => (float) $row['precio3'],
                'imagen' => $row['imagen'],
                'estatus' => $row['estatus'],
                'fecha_creacion' => $row['fecha_creacion'],
            );
        }
        echo json_encode($pro);
    }

}
