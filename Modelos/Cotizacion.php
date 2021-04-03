<?php

namespace Modelos;

class Cotizacion extends \Prototipo\Operaciones {

    var $cod_cliente = '';

    public function lista() {
        $pen = array();
        $sql = "SELECT cotizacion.codigo as codFact,telefono,correo,contacto, fecha, nombre,total,cotizacion.estatus as status, nota,usuario,tasa   FROM cotizacion,cliente WHERE cotizacion.cod_cliente = cliente.codigo order by fecha desc";
        $query = $this->query($sql);
        while ($row = mysqli_fetch_array($query)) {
            $detalle = array();
            $sql = $this->query('SELECT codProducto FROM detallecotizacion WHERE codCotizacion = ' . $row['codFact']);
            while ($row2 = $sql->fetch_array()) {
                $detalle[] = $row2['codProducto'];
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
                'tasa' => (float) $row['tasa'],
                'detalles' => $detalle,
            );
        }
        return $this->getResponse($pen);
    }

    public function detalles($id) {
        $sql = "SELECT * FROM cotizacion where codigo = $id";
        $query = $this->query($sql);
        $cotizacion = array();
        if ($row = $query->fetch_array()) {
            //datos del proveedor
            $cliente = new Cliente();
            $cotizacion = $cliente->detalles($row['cod_cliente']);
            $cotizacion['cod_cliente'] = $row['cod_cliente'];
            //datos de la cotizacion
            $cotizacion['codigo'] = (int) $row['codigo'];
            $cotizacion['forma_pago'] = $row['forma_pago'];
            $cotizacion['tiempo_entrega'] = $row['tiempo_entrega'];
            $cotizacion['validez'] = $row['validez'];
            $cotizacion['nota'] = $row['nota'];
            $cotizacion['cod_cliente'] = $row['cod_cliente'];
            $cotizacion['fecha'] = $row['fecha'];
            $cotizacion['subtotal'] = (float) $row['subtotal'];
            $cotizacion['total'] = (float) $row['total'];
            $cotizacion['impuesto'] = (float) $row['iva'];
            $cotizacion['tasa'] = (float) $row['tasa'];
            $cotizacion['estatus'] = (int) $row['estatus'];
            $sql = "SELECT * FROM `usuario` where codigo = '" . $row['usuario'] . "'";
            $query = $this->query($sql);
            if ($row = $query->fetch_array()) {
                $cotizacion['user'] = $row['nombre'];
            }
            $query = $this->query("SELECT * from detallecotizacion where codCotizacion = $id");
            $cotizacion['detalles'] = array();
            $producto = new Producto();
            while ($row = $query->fetch_array()) {
                $detalle = $producto->ver($row['codProducto']);
                $detalle['unidades'] = (float) $row['cantidad'];
                $detalle['precio'] = (float) $row['precio_unit'];
                $cotizacion['detalles'][] = $detalle;
            }
        }
        return $this->getResponse($cotizacion);
    }

    public function nuevo() {
        $this->getCondiciones();
        $this->cod_cliente = $this->postString('cod_cliente');
        $plantilla_id = $this->postIntenger('plantilla');
        $id_usuario = $_SESSION['id_usuario'];
        $query = $this->query("INSERT into cotizacion values("
                . "null,"
                . "UPPER('$this->cod_cliente'),"
                . " NOW(),"
                . " $this->impuesto,"
                . " $this->subtotal,"
                . " $this->total,"
                . " UPPER('$this->forma_pago'),"
                . " UPPER('$this->tiempo_entrega'),"
                . " UPPER('$this->validez'),"
                . " UPPER('$this->nota'),"
                . "$tasa,"
                . " 1,"
                . "$id_usuario)");
        $id_cotizacion = $this->con->insert_id;
        foreach ($detalles as $pro) {
            $monto = $pro->unidades * $pro->precio;
            $this->query("INSERT INTO detallecotizacion VALUES ("
                    . "'$id_cotizacion',"
                    . "'$pro->codigo',"
                    . "'$pro->unidades',"
                    . "'$pro->precio', "
                    . "'$monto',"
                    . "'$pro->comentario') ");
        }
        if ($plantilla_id > 0) {
            $plantilla = new Plantilla();
            $plantilla->borrar($plantilla_id);
        }
        return $this->getResponse($id_cotizacion);
    }

    public function guardar() {
        $plantilla_id = $this->postIntenger('plantilla');
        $plantilla = new Plantilla();
        return $plantilla->guardar($plantilla_id);
    }

    public function seguimiento($id) {
        // $id_usuario = $_SESSION['id_usuario'];
        $sql = "SELECT descripcion,nombre,fecha,correo FROM cotizacion_seguimiento,usuario where usuario=codigo AND cod_cotizacion = $id";
        $query = $this->query($sql);
        $cotizacion = array();
        while ($row = $query->fetch_array()) {
            $cotizacion[] = array(
                'descripcion' => $row['descripcion'],
                'usuario' => $row['nombre'],
                'correo' => $row['correo'],
                'fecha' => $row['fecha'],
            );
        }
        return $this->getResponse($cotizacion);
    }

    public function seguimiento_nuevo($id) {
        $id_usuario = $_SESSION['id_usuario'];
        $descripcion = $this->con->real_escape_string(strip_tags($_POST["descripcion"], ENT_QUOTES));
        $fecha = date('Y-m-d H:i:s');
        $sql = "INSERT INTO cotizacion_seguimiento (cod_cotizacion,descripcion,usuario,fecha) VALUES ($id,UPPER('$descripcion'),$id_usuario,'$fecha')";
        $query = $this->query($sql);
        return $this->getResponse(1);
    }

    function cancelar($id) {
        $sql = "UPDATE `cotizacion` SET `estatus`= 0 WHERE codigo = $id";
        $query = $this->query($sql);
        return $this->getResponse(1);
    }

    function procesar($id) {
        $query = $this->query("UPDATE `cotizacion` SET `estatus`= 2 WHERE codigo = $id");
        $sql = $this->query("select usuario from cotizacion WHERE codigo = $id");
        if ($row = $sql->fetch_array()) {
            $user_id =(int) $row['usuario'];
        }
        return $this->getResponse($user_id);
    }

}
