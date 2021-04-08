<?php

namespace Modelos;

class Factura extends \Prototipo\Operaciones {

    var $costo = 0;
    var $cod_cliente = '';
    var $porc_impuesto = 0;
    var $condicion = '';
    var $id_cotizacion = 0;
    var $id_nota = 0;
    var $user = 0;

    function lista() {
        $pen = array();
        $sql = "SELECT factura.codigo as codFact, fecha,telefono, correo,contacto,nombre,total,factura.estatus as status,factura.usuario  FROM factura,cliente WHERE factura.cod_cliente = cliente.codigo order by fecha DESC ";
        $query = $this->query($sql);
        while ($row = $query->fetch_array()) {
            $detalle = array();
            $sql = $this->query('SELECT codProducto FROM detallefactura WHERE codFactura = ' . $row['codFact']);
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
                'usuario' => (int) $row['usuario'],
                'status' => (int) $row['status'],
                'detalles' => $detalle
            );
        }
        return $this->getResponse($pen);
    }

    function detalles($id) {
        $query = $this->query("SELECT * FROM factura where codigo = $id");
        $cotizacion = array();
        if ($row = $query->fetch_array()) {
            //datos del cliente
            $cliente = new Cliente();
            $cotizacion = $cliente->detalles($row['cod_cliente']);
            $cotizacion['cod_cliente'] = $row['cod_cliente'];

            $factura['codigo'] = $row['codigo'];
            $factura['cod_cliente'] = $row['cod_cliente'];
            $factura['fecha'] = $row['fecha'];
            $factura['impuesto'] = $row['iva'];
            $factura['condicion'] = $row['condicion'];
            $query = $this->query("SELECT * FROM `usuario` where codigo = '" . $row['usuario'] . "'");
            if ($row = $query->fetch_array()) {
                $factura['user'] = $row['nombre'];
            }
            $factura['detalles'] = array();
            $query = $this->query("SELECT * from detallefactura where codFactura = '$id'");
            $producto = new Producto();
            while ($row = $query->fetch_array()) {
                $detalle = $producto->ver($row['codProducto']);
                $detalle['unidades'] = (float) $row['cantidad'];
                $detalle['precio'] = (float) $row['precio_unit'];
                $factura['detalles'][] = $detalle;
            }
        }
        return $this->getResponse($factura);
    }

    function nuevo() {
        $this->getCondiciones();
        $this->cod_cliente = $this->postString('cod_cliente');
        $this->porc_impuesto = $this->postString('porc_impuesto');
        $this->costo = $this->postString('costo');
        $this->condicion = $this->postString('condicion');
        $this->id_cotizacion = $this->postString('id_cotizacion');
        $this->id_nota = $this->postString('id_nota');

        if ($this->id_nota > 0) {
            $nota = new Nota();
            $this->user = $nota->procesar($this->id_nota);
        } elseif ($this->id_cotizacion > 0) {
            $cotizacion = new Cotizacion();
            $this->user = $cotizacion->procesar($this->id_cotizacion);
        } else {
            $this->user = $_SESSION['id_usuario'];
        }

        $sql = $this->query('SELECT COUNT(*) as cant FROM `factura`');
        $row = $sql->fetch_array();
        $num_factura = $row['cant'] + 1;
        $sql = $this->query("INSERT into factura values("
                . "$num_factura,"
                . "UPPER('$this->cod_cliente'),"
                . " NOW(),"
                . " '$this->condicion',"
                . " $this->porc_impuesto,"
                . " $this->costo,"
                . " $this->impuesto,"
                . " $this->subtotal,"
                . " $this->total,"
                . " UPPER('$this->nota'), "
                . "$this->user ,"
                . "2)");

        $producto = new Producto();
        foreach ($this->detalles as $pro) {
            $monto = $pro->unidades * $pro->precio;
            $this->query("INSERT INTO detallefactura VALUES " .
                    "('$num_factura',"
                    . "'$pro->codigo',"
                    . "$pro->unidades,"
                    . "$pro->precio),"
                    . "$monto ");
            $producto->salida($pro->codigo, $pro->unidades);
        }
        return $this->getResponse($num_factura);
    }

    function cancelar($id) {
        $sql = "UPDATE `factura` SET `estatus`= 0 WHERE codigo = $id";
        $query = $this->query($sql);
        $sql2 = $this->query("select * from detallefactura where codFactura = '$id' ");
        while ($row = $sql2->fetch_array()) {
            $cod = $row['codProducto'];
            $cantidad = intval($row['cantidad']);
            $this->query("UPDATE producto set cantidad = cantidad + $cantidad WHERE codigo = '$cod' ");
        }
        return $this->getResponse(1);
    }

}
