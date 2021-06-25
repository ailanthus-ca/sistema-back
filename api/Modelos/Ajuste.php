<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modelos;

/**
 * Description of Ajuste
 *
 * @author victo
 */
class Ajuste extends \conexion {

    var $estado = 'Ajuste';
    var $tipo_ajuste = '';
    var $fecha = '';
    var $nota = '';
    var $usuario = 0;

    public function lista() {
        $data = array();
        $query = $this->query("SELECT ajusteinv.codigo as codFact, tipo_ajuste, fecha, ajusteinv.estatus, usuario, usuario.nombre as nombre, nota FROM `ajusteinv`, `usuario` WHERE ajusteinv.usuario = usuario.codigo");
        while ($row = $query->fetch_array()) {
            $detalle = array();
            $sql = $this->query("SELECT cod_producto FROM detalleajusteinv WHERE cod_ajuste = " . $row['codFact']);
            while ($row2 = $sql->fetch_array()) {
                $detalle[] = $row2['cod_producto'];
            }
            $data[] = array(
                'codigo' => (int) $row['codFact'],
                'usuario' => (int) $row['usuario'],
                'nombre' => $row['nombre'],
                'tipo' => $row['tipo_ajuste'],
                'fecha' => $row['fecha'],
                'nota' => $row['nota'],
                'status' => (int) $row['estatus'],
                'detalles' => $detalle
            );
        }
        return $this->getResponse($data);
    }

    public function detalles($id) {
        $sql = "SELECT * FROM ajusteinv WHERE codigo = $id";
        $query = $this->query($sql);
        $ajuste = array();
        if ($row = $query->fetch_array()) {
            // Datos del usuario
            $usuario = new Usuario();
            $usuario = $usuario->detalles($row['usuario']);
            $ajuste['usuario'] = $usuario['nombre'];
            $ajuste['cod_usuario'] = $row['usuario'];
            //datos del ajuste
            $ajuste['codigo'] = (int) $row['codigo'];
            $ajuste['fecha'] = $row['fecha'];
            $ajuste['tipo'] = $row['tipo_ajuste'];
            $ajuste['status'] = (int) $row['estatus'];
            $ajuste['nota'] = $row['nota'];
            //Detalle de la ajuste
            $query = $this->query("SELECT * from detalleajusteinv where cod_ajuste = $id");
            $ajuste['detalles'] = array();
            $producto = new Producto();
            while ($row = $query->fetch_array()) {
                $detalle = $producto->ver($row['cod_producto']);
                $detalle['unidades'] = (float) $row['cantidad'];
                $detalle['comentario'] = $row['descripcion'];
                $detalle['data'] = json_decode($row['data']);
                $ajuste['detalles'][] = $detalle;
            }
            return $this->getResponse($ajuste);
        } else {
            $this->getNotFount();
            return $this->getResponse(array());
        }
    }

    public function nuevo() {
        $id_usuario = $_SESSION['id_usuario'];
        $this->query("INSERT INTO ajusteinv "
                . "(codigo, tipo_ajuste, fecha, nota, usuario, estatus) VALUES ("
                . "null, "
                . "UPPER('$this->tipo_ajuste'), "
                . "NOW(), "
                . "UPPER('$this->nota'), "
                . "$id_usuario, "
                . "1)");
        $id_ajus = $this->con->insert_id;
        switch ($this->tipo_ajuste) {
            case 'ENTRADA': $this->detalleEntrada($id_ajus);
                break;
            case 'SALIDA': $this->detalleSalida($id_ajus);
                break;
            case 'COSTO': $this->detalleCosto($id_ajus);
                break;
            case 'UTILIDAD': $this->detalleUtilidad($id_ajus);
                break;
        }
        $this->actualizarEstado();
        return $this->getResponse($this->detalles($id_ajus));
    }

    function detalleEntrada($id_ajus) {
        $producto = new Producto();
        foreach ($this->detalles as $pro) {
            $this->query("INSERT INTO detalleajusteinv VALUES ("
                    . "'$id_ajus',"
                    . "'$pro->codigo',"
                    . "'$pro->unidades',"
                    . "'$pro->comentario',"
                    . "'') ");
            $producto->entrada($pro->codigo, $pro->unidades);
        }
    }

    function detalleSalida($id_ajus) {
        $producto = new Producto();
        foreach ($this->detalles as $pro) {
            $this->query("INSERT INTO detalleajusteinv VALUES ("
                    . "'$id_ajus',"
                    . "'$pro->codigo',"
                    . "'$pro->unidades',"
                    . "'$pro->comentario',"
                    . "'') ");
            $producto->salida($pro->codigo, $pro->unidades);
        }
    }

    function detalleCosto($id_ajus) {
        $producto = new Producto();
        foreach ($this->detalles as $pro) {
            $produc = $producto->ver($pro->codigo);
            $data = json_encode(array('costo' => (float) $produc['costo'], 'tasa' => (float) $produc['tasa'],));
            $this->query("INSERT INTO detalleajusteinv VALUES ("
                    . "'$id_ajus',"
                    . "'$pro->codigo',"
                    . "$pro->precio,"
                    . "'$pro->comentario',"
                    . "'$data') ");
            $dolar = new \Modelos\Dolares();
            $tasa = $dolar->valor();
            $producto->costo($pro->codigo, $pro->precio, $tasa);
        }
    }

    function detalleUtilidad($id_ajus) {
        $producto = new Producto();
        foreach ($this->detalles as $pro) {
            $produc = $producto->ver($pro->codigo);
            $data = json_encode(array(
                'previo' => array(
                    'precio1' => (float) $produc['precio1'],
                    'precio2' => (float) $produc['precio2'],
                    'precio3' => (float) $produc['precio3']),
                'actual' => array(
                    'precio1' => (float) $pro->precio1,
                    'precio2' => (float) $pro->precio2,
                    'precio3' => (float) $pro->precio3)
            ));
            $this->query("INSERT INTO detalleajusteinv VALUES ("
                    . "'$id_ajus',"
                    . "'$pro->codigo',"
                    . "'1,"
                    . "'$pro->comentario',"
                    . "'$data') ");
            $producto->utilidad($pro->codigo, $pro->precio1, $pro->precio2, $pro->precio3);
        }
    }

    function deshacerEntrada($detalles) {
        $producto = new Producto();
        foreach ($detalles as $pro) {
            $producto->salida($pro['codigo'], $pro['unidades']);
        }
    }

    function deshacerSalida($detalles) {
        $producto = new Producto();
        foreach ($detalles as $pro) {
            $producto->entrada($pro['codigo'], $pro['unidades']);
        }
    }

    function deshacerCosto($detalles) {
        $producto = new Producto();
        foreach ($detalles as $pro) {
            $producto->cargar($pro['codigo']);
            if ($producto->igualCosto($pro['data']->costo, $pro['data']->tasa))
                $producto->costo($pro['codigo'], $pro['data']->costo, $pro['data']->tasa);
        }
    }

    function deshacerUtilidad($detalles) {
        $producto = new Producto();
        foreach ($detalles as $pro) {
            $producto->cargar($pro['codigo']);
            if ($producto->igualUtilidad($pro['data']->previo->precio1,
                            $pro['data']->previo->precio2,
                            $pro['data']->previo->precio3))
                $producto->utilidad($pro['codigo'],
                        $pro['data']->previo->precio1,
                        $pro['data']->previo->precio2,
                        $pro['data']->previo->precio3);
        }
    }

    function cancelar($id) {
        $sql = "UPDATE `ajusteinv` SET `estatus`= 0 WHERE codigo = $id";
        $query = $this->query($sql);
        $this->actualizarEstado();
        return $this->getResponse($this->detalles($id));
    }

    function listaWithProducto($codigo, $where) {
        $pen = array();
        $sql = $this->query("select "
                . "fecha, "
                . "ajusteinv.codigo as codigo, "
                . "tipo_ajuste, "
                . "usuario.nombre as nombre, "
                . "cantidad "
                . "from ajusteinv, detalleajusteinv, usuario WHERE "
                . "usuario.codigo = usuario AND "
                . "ajusteinv.codigo = cod_ajuste AND "
                . "(ajusteinv.tipo_ajuste = 'ENTRADA' OR "
                . "ajusteinv.tipo_ajuste = 'SALIDA') AND "
                . "cod_producto = '$codigo' "
                . "$where");
        while ($row = $sql->fetch_array()) {
            $pen[] = array(
                'operacion' => 'AJUSTE',
                'tipo' => $row['tipo_ajuste'],
                'orden' => strtotime($row['fecha']),
                'fecha' => $row['fecha'],
                'codigo' => $row['codigo'],
                'nombre' => $row['nombre'],
                'cantidad' => $row['cantidad']
            );
        }
        return $this->getResponse($pen);
    }

}
