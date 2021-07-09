<?php

namespace Modelos;

class Orden extends \Prototipo\Operaciones {

    var $estado = 'Orden';
    var $cod_proveedor;

    function lista() {
        $pen = array();
        $sql = "SELECT ordencompra.codigo as codFact,telefono,correo,contacto, fecha, nombre,total,ordencompra.estatus as status, nota,usuario FROM ordencompra,proveedor WHERE ordencompra.cod_proveedor = proveedor.codigo order by fecha DESC ";
        $query = $this->query($sql);
        while ($row = $query->fetch_array()) {
            $detalle = array();
            $sql = $this->query('SELECT cod_producto FROM detalleordencompra WHERE cod_orden = ' . $row['codFact']);
            while ($row2 = $sql->fetch_array()) {
                $detalle[] = $row2['cod_producto'];
            }
            $pen[] = array(
                'codigo' => (int) $row['codFact'],
                'fecha' => $row['fecha'],
                'nombre' => $row['nombre'],
                'telefono' => $row['telefono'],
                'correo' => $row['correo'],
                'contacto' => $row['contacto'],
                'monto' => (float) $row['total'],
                'status' => (int) $row['status'],
                'nota' => $row['nota'],
                'usuario' => (int) $row['usuario'],
                'detalles' => $detalle
            );
        }
        return $this->getResponse($pen);
    }

    function detalles($id) {
        $sql = "SELECT * FROM  ordencompra where codigo = $id";
        $query = $this->query($sql);
        $orden = array();
        while ($row = $query->fetch_array()) {
            //datos del proveedor
            $proveedor = new Proveedor();
            $orden = $proveedor->detalles($row['cod_proveedor']);
            $orden['cod_proveedor'] = $row['cod_proveedor'];
            //datos del usuario
            $usuario = new Usuario();
            $user = $usuario->detalles($row['usuario']);
            $orden['usuario'] = $user['nombre'];
            //datos de la orden
            $orden['codigo'] = (int) $id;
            $orden['forma_pago'] = $row['forma_pago'];
            $orden['tiempo_entrega'] = $row['tiempo_entrega'];
            $orden['validez'] = $row['validez'];
            $orden['nota'] = $row['nota'];
            $orden['fecha'] = $row['fecha'];
            $orden['subtotal'] = (float) $row['subtotal'];
            $orden['impuesto'] = (float) $row['impuesto'];
            $orden['total'] = (float) $row['total'];
            $orden['estatus'] = (int) $row['estatus'];
            //detalle de la orden de compra
            $orden['detalles'] = array();
            $sql = $this->query("SELECT * from detalleordencompra where cod_orden = $id");
            while ($row = $sql->fetch_array()) {
                $producto = new Producto();
                $detalle = $producto->ver($row['cod_producto']);
                $detalle['unidades'] = (float) $row['cantidad'];
                $detalle['precio'] = (float) $row['precio_unit'];
                $orden['detalles'][] = $detalle;
            }
        }
        return $this->getResponse($orden);
    }

    function checkCodigo($cod) {
        $sql = $this->query('SELECT count(*) AS exist FROM ordencompra WHERE codigo="' . $cod . '"');
        if ($row = $sql->fetch_array()) {
            return boolval($row['exist']);
        }
    }

    function nuevo() {
        $user = $_SESSION['id_usuario'];
        $sql = $this->query("INSERT INTO ordencompra VALUES ("
                . "null,"
                . "UPPER('$this->cod_proveedor'),"
                . "NOW(),"
                . "$this->subtotal,"
                . "$this->impuesto,"
                . "$this->total, "
                . "UPPER('$this->forma_pago'),"
                . " UPPER('$this->tiempo_entrega')"
                . ", UPPER('$this->validez'), "
                . "UPPER('$this->nota'),"
                . "$user, "
                . "1)");
        $id_orden = $this->con->insert_id;

        foreach ($this->detalles as $pro) {
            $monto = $pro->unidades * $pro->precio;
            $this->query("INSERT INTO detalleordencompra VALUES " .
                    "('$id_orden',"
                    . "'$pro->codigo',"
                    . "$pro->precio,"
                    . "$pro->unidades,"
                    . " $monto) ");
        }
        $this->actualizarEstado();
        return $this->getResponse($id_orden);
    }

    function cancelar($id) {
        $sql = "UPDATE `ordencompra` SET `estatus`= 0 WHERE codigo = $id";
        $query = $this->query($sql);
        $this->actualizarEstado();
        return $this->getResponse(1);
    }

    function procesar($id) {
        $sql = "UPDATE `ordencompra` SET `estatus`= 2 WHERE codigo = $id";
        $query = $this->query($sql);
        $this->actualizarEstado();
        return $this->getResponse(1);
    }

    public function seguimiento($id) {
        // $id_usuario = $_SESSION['id_usuario'];
        $sql = "SELECT descripcion,nombre,fecha,correo FROM orden_seguimiento,usuario where usuario=codigo AND cod_cotizacion = $id";
        $query = $this->query($sql);
        $cotizacion = array();
        while ($row = $query->fetch_array()) {
            $cotizacion[] = array(
                'descripcion' => $row['descripcion'],
                'usuario' => $row['nombre'],
                'correo' => $row['correo'],
                'fecha' => $row['fecha'],
            );
        };
        return $this->getResponse($cotizacion);
    }

    public function seguimiento_nuevo($id, $descripcion) {
        $id_usuario = $_SESSION['id_usuario'];
        $fecha = date('Y-m-d H:i:s');
        $sql = "INSERT INTO orden_seguimiento (cod_orden,descripcion,usuario,fecha) VALUES ($id,UPPER('$descripcion'),$id_usuario,'$fecha')";
        $query = $this->query($sql);
        return $this->getResponse(1);
    }

    function listaWhere($where){
        $pen = array();
        $query = $this->query("SELECT "
            ."ordencompra.codigo as codFact, "
            ."telefono, "
            ."correo, "
            ."contacto, " 
            ."fecha, "
            ."nombre, "
            ."total, "
            ."ordencompra.estatus as status, " 
            ."nota, "
            ."usuario " 
            ."FROM ordencompra,proveedor " 
            ."WHERE ordencompra.cod_proveedor = proveedor.codigo "
            ." $where "
            ."order by fecha DESC");
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

    function listaWithProducto($codigo, $where) {
        $pen = array();
        $query = $this->query("SELECT DISTINCT "
                . "ordencompra.codigo as codFact, "
                . "fecha,telefono, "
                . "correo, "
                . "contacto, "
                . "nombre, "
                . "total, "
                . "ordencompra.estatus as status, "
                . "ordencompra.usuario, "
                . "detalleordencompra.cantidad, "
                . "detalleordencompra.precio_unit "
                . "FROM ordencompra, cliente, detalleordencompra "
                . "WHERE ordencompra.cod_proveedor = proveedor.codigo "
                . "AND detalleordencompra.cod_orden = ordencompra.codigo "
                . "AND detalleordencompra.cod_producto = '$codigo' "
                . " $where "
                . "order by fecha DESC ");
        while ($row = $query->fetch_array()) {
            $pen[] = array(
                'operacion' => 'ORDEN DE COMPRA',
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
                'precio_unit' => (float) $row['precio_unit']
            );
        }
        return $this->getResponse($pen);
    }

    // ---------------------------------- GRAFICAS ---------------------------------

    public function totalOrdenes()
    {
        $query = $this->query("SELECT COUNT(*) AS total FROM `ordencompra`");
        $pen = 0;
        while ($row = $query->fetch_array()) {
            $pen = (int) $row['total'];
        }
        return $this->getResponse($pen);
    }

}
