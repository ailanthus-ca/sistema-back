<?php

namespace Modelos;

class Producto extends \conexion {

    public function lista() {
        $where = ' WHERE estatus = 1 AND departamento!=""';
        if (isset($_POST['tipo'])) {
            $where += ' and tipo=' . $_POST['enser'];
        }
        if (isset($_POST['stock'])) {
            $where += ' and cantidad>0';
        }
        $pro = array();
        $sql = $this->con->query('SELECT * FROM producto' . $where) or die($con->error);
        while ($row = $sql->fetch_array()) {
            $pro[] = array(
                'codigo' => $row['codigo'],
                'departamento' => $row['departamento'],
                'descripcion' => $row['descripcion'],
                'estatus' => (int) $row['estatus'],
                'enser' => (int) $row['enser'],
                'tipo' => (int) $row['tipo'],
                'costo' => (float) $row['costo'],
                'precio1' => (float) $row['precio1'],
                'precio2' => (float) $row['precio2'],
                'precio3' => (float) $row['precio3'],
                'cantidad' => (float) $row['cantidad'],
            );
        }
        return $pro;
    }

    public function tipo() {
        $tp = array();
        $sql = $this->con->query('SELECT codigo,descripcion FROM tipo_producto WHERE estatus = 1 LIMIT 0,40');
        while ($row = $sql->fetch_array()) {
            $tp[] = array(
                'codigo' => (int) $row['codigo'],
                'descripcion' => $row['descripcion']
            );
        }
        return $tp;
    }

    public function unidad() {
        $un = array();
        $sql = $this->con->query('SELECT codigo,descripcion FROM unidad WHERE estatus = 1 ');
        while ($row = $sql->fetch_array()) {
            $un[] = array(
                'codigo' => (int) $row['codigo'],
                'descripcion' => $row['descripcion']
            );
        }
        return $un;
    }

    public function departamentos() {
        $de = array();
        $sql = $this->con->query("SELECT codigo,descripcion FROM departamento WHERE estatus = 1");
        while ($row = $sql->fetch_array()) {
            $de[] = array(
                'codigo' => $row['codigo'],
                'descripcion' => $row['descripcion'],
            );
        }
        return $de;
    }

    public function ver($cod) {
        $sql = $this->con->query('SELECT * FROM producto WHERE codigo="' . $cod . '"');
        while ($row = $sql->fetch_array()) {
            $pro = array(
                'codigo' => $row['codigo'],
                'departamento' => $row['departamento'],
                'descripcion' => $row['descripcion'],
                'tipo' => (int) $row['tipo'],
                'enser' => (int) $row['enser'],
                'unidad' => (int) $row['unidad'],
                'costo' => (float) $row['costo'],
                'precio1' => (float) $row['precio1'],
                'precio2' => (float) $row['precio2'],
                'precio3' => (float) $row['precio3'],
                'imagen' => $row['imagen'],
                'estatus' => (int) $row['estatus'],
                'fecha_creacion' => $row['fecha_creacion'],
            );
        }
        return $pro;
    }

    public function nuevo() {
        //datos de tipo String
        $departamento = $this->con->real_escape_string(strip_tags($_POST["departamento"], ENT_QUOTES));
        $descripcion = $this->con->real_escape_string(strip_tags($_POST["descripcion"], ENT_QUOTES));
        //datos de tipo Flotante
        $costo = floatval($_POST['costo']);
        $precio1 = floatval($_POST['precio1']);
        $precio2 = floatval($_POST['precio2']);
        $precio3 = floatval($_POST['precio3']);
        //claves foraneas por id tipo entero
        $tipo = intval($_POST["tipo"]);
        $unidad = intval($_POST["unidad"]);
        //dato opcional de tipo tipo booleano
        if (isset($_POST['enser'])) {
            $enser = $_POST['enser'];
        } else {
            $enser = 0;
        }
        //calcular cantodad de productos con el mismo departamento
        $query = $this->con->query("SELECT count(*) AS num FROM producto WHERE departamento = '$departamento'") or die(json_encode(array('error' => 1, 'msn' => $this->con->error)));
        if ($row = mysqli_fetch_array($query)) {
            $num = $row['num'];
        }
        //crear el nuevo codigo
        $codigo_producto = $departamento . $num;
        //buscar si el codigo ya existe
        $query_err = $this->con->query("SELECT * FROM producto WHERE codigo = '$codigo_producto'") or die(json_encode(array('error' => 1, 'msn' => $this->con->error)));
        $rest = array();
        if ($row_err = mysqli_fetch_array($query_err)) {
            $rest['msn'] = "Ya existe un registro con el mismo codigo";
            $rest['error'] = 1;
        }
        //crear el nuevo producto
        $sql = "INSERT INTO producto 
              (codigo,departamento, descripcion, tipo, enser, unidad, costo, precio1, precio2, precio3, cantidad, imagen, estatus, fecha_creacion) 
              VALUES (UPPER('$codigo_producto'),'$departamento',UPPER('$descripcion'),UPPER('$tipo'), '$enser' ,UPPER('$unidad'),
              $costo,$precio1,$precio2,$precio3,0,'',1, NOW())";

        $query = $this->con->query($sql) or die(json_encode(array('error' => 1, 'msn' => $this->con->error)));
        if ($query) {
            $rest['msn'] = "Producto registrado satisfactoriamente.";
            $rest['error'] = 0;
            $rest['codigo'] = $codigo_producto;
        }
        return $this->ver($codigo_producto);
    }

    public function entrada($cod, $can, $pre = 0) {
        $this->con->query("UPDATE producto set cantidad = cantidad + ('$can') WHERE codigo = '$cod' ")or die('ajustar cantidad ' . $this->con->error);
        $sql2 = $this->con->query("SELECT costo from producto where codigo = '$cod' ")or die('comprobar precio ' . $this->con->error);
        $row2 = $sql2->fetch_array();
        if ($row2['costo'] < $pre) {
            $this->con->query("UPDATE producto set costo = '$pre' WHERE codigo = '$can' ")or die('ajustar precio ' . $this->con->error);
        }
    }

    public function salida($cod, $can) {
        $this->con->query("UPDATE producto set cantidad = cantidad - ('$can') WHERE codigo = '$cod' ")or die('ajustar cantidad ' . $this->con->error);
    }

}
