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

    var $estado = 'Nota';
    var $id_cotizacion = 0;
    var $cod_cliente = '';
    var $user = 0;

    function lista() {
        $pen = array();
        $sql = "SELECT * FROM nota_lista";
        $query = $this->query($sql);
        while ($row = $query->fetch_array()) {
            $detalle = array();
            $sql = $this->query('SELECT producto FROM detallesNotas WHERE nota = ' . $row['codFact']);
            while ($row2 = $sql->fetch_array()) {
                $detalle[] = $row2['producto'];
            }
            $pen[] = array(
                (int) $row['codFact'],
                $row['cod_cliente'],
                $row['nombre'],
                $row['fecha'],
                (float) $row['total'],
                (int) $row['usuario'],
                (int) $row['status'],
                $detalle
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
            //datos del usuario
            $usuario = new Usuario();
            $usuario = $usuario->detalles($row['usuario']);
            $notasalida['usuario'] = $usuario['nombre'];
            $notasalida['cod_usuario'] = (int) $row['usuario'];
            //datos de nota de entrega
            $notasalida['codigo'] = (int) $row['codigo'];
            $notasalida['cod_cliente'] = $row['cod_cliente'];
            $notasalida['fecha'] = $row['fecha'];
            $notasalida['nota'] = $row['nota'];
            $notasalida['status'] = (int) $row['estatus'];
            $notasalida['dolar'] = (float) $row['dolar'];
            $notasalida['tasa'] = (float) $row['dolar'];
            //detalle de nota de entrega
            $notasalida['detalles'] = array();
            $sql = "SELECT * from detallesNotas where nota = '" . $notasalida['codigo'] . "'";
            $query = $this->query($sql);
            $producto = new Producto();
            while ($row = $query->fetch_array()) {
                $detalle = $producto->ver($row['producto']);
                $detalle['unidades'] = (float) $row['cantidad'];
                $detalle['precio'] = (float) $row['precio'];
                $notasalida['detalles'][] = $detalle;
            }
            return $this->getResponse($notasalida);
        }
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
            $sql = "SELECT * from detallesNotas where nota = '" . $notasalida['codigo'] . "'";
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

        $dolar = new \Modelos\Dolares();
        $tasa = $dolar->valor();
        $sql = $this->query("INSERT INTO `notasalida` VALUES ("
                . "null,"
                . "'$this->cod_cliente',"
                . "NOW(),"
                . "$this->total,"
                . "'$this->nota',"
                . "1,"
                . "$this->user,"
                . "$tasa)");
        $nota = $this->con->insert_id;
        $producto = new Producto();
        foreach ($this->detalles as $pro) {
            $this->query("INSERT INTO detallesNotas VALUES " .
                    "('$nota','$pro->codigo',$pro->unidades,$pro->precio) ");
            if ($producto->inventario !== 1)
                $producto->cargarStock($pro->codigo);
        }
        $this->actualizarEstado();
        return $this->getResponse($nota);
    }

    function cancelar($id) {
        $query = $this->query("UPDATE `notasalida` SET `estatus`= 0 WHERE codigo = $id");
        $sql2 = $this->query("select * from detallesNotas where nota = '$id' ");
        $producto = new Producto();
        while ($row = $sql2->fetch_array()) {
            $producto->cargarStock($row['producto']);
        }
        $this->actualizarEstado();
        return $this->getResponse(1);
    }

    function facturar($id) {
        $query = $this->query("UPDATE `notasalida` SET `estatus`= 1 WHERE codigo = $id");
        $sql = $this->query("select usuario from notasalida WHERE codigo = $id");
        if ($row = $sql->fetch_array()) {
            $user_id = (int) $row['usuario'];
        }
        $this->actualizarEstado();
        return $this->getResponse($user_id);
    }

    function listaWithProducto($codigo, $where) {
        $pen = array();
        $query = $this->query("SELECT "
                . "notasalida.codigo as codFact, "
                . "fecha, "
                . "telefono, "
                . "correo, "
                . "contacto, "
                . "nombre, "
                . "total, "
                . "notasalida.estatus as status, "
                . "notasalida.usuario, "
                . "detallesNotas.cantidad, "
                . "detallesNotas.precio "
                . "FROM notasalida, detallesNotas, cliente "
                . "WHERE notasalida.cod_cliente = cliente.codigo "
                . "AND detallesNotas.nota = notasalida.codigo "
                . "AND producto = '$codigo' "
                . "$where "
                . "order by fecha DESC ");
        while ($row = $query->fetch_array()) {
            $pen[] = array(
                'operacion' => 'NOTA',
                'tipo' => 'SALIDA',
                'orden' => strtotime($row['fecha']),
                'codigo' => (int) $row['codFact'],
                'fecha' => $row['fecha'],
                'nombre' => $row['nombre'],
                'telefono' => $row['telefono'],
                'correo' => $row['correo'],
                'contacto' => $row['contacto'],
                'monto' => (float) $row['total'],
                'usuario' => (int) $row['usuario'],
                'status' => (int) $row['status'],
                'cantidad' => (float) $row['cantidad'],
                'precio_unit' => (float) $row['precio']
            );
        }
        return $this->getResponse($pen);
    }

    function listaWhere($where) {
        $pen = array();
        $query = $this->query("SELECT "
                . "notasalida.codigo as codFact, "
                . "fecha, "
                . "nombre, "
                . "total, "
                . "nota, "
                . "notasalida.estatus as status, "
                . "notasalida.usuario "
                . "FROM notasalida,cliente "
                . "WHERE notasalida.cod_cliente = cliente.codigo "
                . " $where "
                . " order by fecha DESC");
        while ($row = $query->fetch_array()) {
            $pen[] = array(
                'codigo' => (int) $row['codFact'],
                'fecha' => $row['fecha'],
                'nombre' => $row['nombre'],
                'monto' => (float) $row['total'],
                'nota' => (float) $row['nota'],
                'usuario' => (int) $row['usuario'],
                'status' => (int) $row['status'],
            );
        }
        return $this->getResponse($pen);
    }

    function productos($where) {
        $query = $this->query("SELECT "
                . "producto.codigo as codigo, "
                . "producto.descripcion as descripcion, "
                . "SUM( detallesNotas.cantidad ) as cantidad, "
                . "SUM( detallesNotas.precio*detallesNotas.cantidad ) as monto "
                . "FROM detallesNotas,  producto, notasalida WHERE "
                . "producto.codigo = detallesNotas.producto AND "
                . "notasalida.codigo = detallesNotas.nota "
                . "$where "
                . "GROUP BY `producto`.`codigo`");
        $pen = array();
        while ($row = $query->fetch_array()) {
            $pen[] = array(
                'codigo' => $row['codigo'],
                'descripcion' => $row['descripcion'],
                'cantidad' => (float) $row['cantidad'],
                'monto' => (float) $row['monto'],
            );
        }
        return $this->getResponse($pen);
    }

    public function mes_actual() {
        $mes = date("n");
        $ano = date("Y");
        $query = $this->query("SELECT SUM(total) AS ventas FROM notasalida WHERE estatus = 1 AND MONTH(fecha)=$mes AND YEAR(fecha)=$ano");
        if ($row = $query->fetch_array()) {
            return (int) $row['ventas'];
        }
        return 0;
    }

    function salidasValidas($codigo, $where = '') {
        $query = $this->query("SELECT "
                . "SUM( cantidad ) as cantidad "
                . "FROM detallesNotas, notasalida WHERE "
                . "producto = '$codigo' AND $where "
                . "codigo = detallesNotas.nota AND "
                . "estatus = 1");
        while ($row = $query->fetch_array()) {
            return (float) $row['cantidad'];
        }
        return 0;
    }

    // ------------------------------------ GRAFICAS ------------------------------------

    public function totalNotas() {
        $query = $this->query("SELECT COUNT(*) AS total FROM `notasalida`");
        $pen = 0;
        while ($row = $query->fetch_array()) {
            $pen = (int) $row['total'];
        }
        return $this->getResponse($pen);
    }

    public function torta($where) {
        $query = $this->query("SELECT "
                . "estatus AS RANK, "
                . "COUNT(estatus) AS CANT "
                . "FROM notasalida "
                . "WHERE $where "
                . "GROUP BY estatus");
        $pen = array();
        while ($row = $query->fetch_array()) {
            $pen[] = array(
                'cantidad' => (int) $row['CANT'],
                'estatus' => (int) $row['RANK']
            );
        }
        return $this->getResponse($pen);
    }

}
