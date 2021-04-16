<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modelos;

/**
 * Description of Nota
 *
 * @author victo
 */
class Nota extends \Prototipo\Operaciones {

    var $id_cotizacion = 0;
    var $cod_cliente = '';
    var $user = 0;

    function lista() {
        $pen = array();
        $sql = "SELECT notasalida.codigo as codFact, fecha,telefono, correo,contacto,nombre,total,notasalida.estatus as status,notasalida.usuario  FROM notasalida,cliente WHERE notasalida.cod_cliente = cliente.codigo order by fecha DESC ";
        $query = $this->query($sql);
        while ($row = $query->fetch_array()) {
            $detalle = array();
            $sql = $this->query('SELECT producto FROM detallesnotas WHERE nota = ' . $row['codFact']);
            while ($row2 = $sql->fetch_array()) {
                $detalle[] = $row2['producto'];
            }
            $pen[] = array(
                'codigo' => (int) $row['codFact'],
                'fecha' => $row['fecha'],
                'nombre' => $row['nombre'],
                'telefono' => $row['telefono'],
                'correo' => $row['correo'],
                'contacto' => $row['contacto'],
                'monto' => (float) $row['total'],
                'usuario' => (int) $row['usuario'],
                'status' => (int) $row['status'],
                'detalles' => $detalle
            );
        }
        return $this->getResponse($pen);
    }

    function detalles($id) {
        $query = $this->query("SELECT * FROM notasalida where codigo = $id");
        $cotizacion = array();
        if ($row = $query->fetch_array()) {
            //datos del cliente
            $cliente = new Cliente();
            $notasalida = $cliente->detalles($row['cod_cliente']);
            $notasalida['cod_cliente'] = $row['cod_cliente'];

            $notasalida['codigo'] = $row['codigo'];
            $notasalida['cod_cliente'] = $row['cod_cliente'];
            $notasalida['fecha'] = $row['fecha'];
            $notasalida['nota'] = $row['nota'];
            $query = $this->query("SELECT * FROM `usuario` where codigo = '" . $row['usuario'] . "'");
            if ($row = $query->fetch_array()) {
                $notasalida['user'] = $row['nombre'];
            }
            $notasalida['detalles'] = array();
            $sql = "SELECT * from detallesnotas where nota = '" . $notasalida['codigo'] . "'";
            $query = $this->query($sql);
            while ($row = $query->fetch_array()) {
                $producto = new Producto();
                $detalle = $producto->ver($row['producto']);
                $detalle['unidades'] = (float) $row['cantidad'];
                $detalle['precio'] = (float) $row['precio'];
                $notasalida['detalles'][] = $detalle;
            }
        }
        return $this->getResponse($notasalida);
    }

    public function cargar($cod) {
        $sql = $this->query('SELECT * FROM notasalida WHERE codigo="' . $cod . '"');
        while ($row = $sql->fetch_array()) {
            $notasalida['codigo'] = $row['codigo'];

            $cliente = new Cliente();
            $notasalida = $cliente->detalles($row['cod_cliente']);
            $notasalida['cod_cliente'] = $row['cod_cliente'];

            $notasalida['fecha'] = $row['fecha'];
            $notasalida['total'] = (int) $row['total'];
            $notasalida['nota'] = (int) $row['nota'];
            $query = $this->query("SELECT * FROM `usuario` where codigo = '" . $row['usuario'] . "'");
            if ($row = $query->fetch_array()) {
                $notasalida['user'] = $row['nombre'];
            }

            $notasalida['detalles'] = array();
            $sql = "SELECT * from detallesnotas where nota = '" . $notasalida['codigo'] . "'";
            $query = $this->query($sql);
            while ($row = $query->fetch_array()) {
                $producto = new Producto();
                $detalle = $producto->ver($row['producto']);
                $detalle['unidades'] = (float) $row['cantidad'];
                $detalle['precio'] = (float) $row['precio'];
                $notasalida['detalles'][] = $detalle;
            }
        }
    }

    function checkCodigo($cod) {
        $sql = $this->query('SELECT count(*) AS exist FROM notasalida WHERE codigo="' . $cod . '"');
        if ($row = $sql->fetch_array()) {
            return boolval($row['exist']);
        }
    }

    function nuevo() {
        $sql = $this->query("INSERT INTO `notasalida` VALUES ("
                . "null,"
                . "'$this->cod_cliente',"
                . "NOW(),"
                . "$this->total,"
                . "'$this->nota',"
                . "1,"
                . "$this->user)");
        $nota = $this->con->insert_id;
        $producto = new Producto();
        foreach ($this->detalles as $pro) {
            $this->query("INSERT INTO detallesNotas VALUES " .
                    "('$nota','$pro->codigo',$pro->unidades,$pro->precio) ");
            $producto->salida($pro->codigo, $pro->unidades);
        }
        return $this->getResponse($nota);
    }

    function cancelar($id) {
        $query = $this->query("UPDATE `notasalida` SET `estatus`= 0 WHERE codigo = $id");
        $sql2 = $this->query("select * from detallesnotas where nota = '$id' ");
        $producto = new Producto();
        while ($row = $sql2->fetch_array()) {
            $cod = $row['producto'];
            $cantidad = intval($row['cantidad']);
            $producto->entrada($cod, $cantidad);
        }
        return $this->getResponse(1);
    }

    function facturar($id) {
        $query = $this->query("UPDATE `notasalida` SET `estatus`= 1 WHERE codigo = $id");
        $sql = $this->query("select usuario from notasalida WHERE codigo = $id");
        if ($row = $sql->fetch_array()) {
            $user_id = (int) $row['usuario'];
        }
        return $this->getResponse($user_id);
    }

}
