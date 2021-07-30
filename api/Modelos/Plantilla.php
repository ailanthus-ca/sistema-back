<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modelos;

/**
 * Description of Plantilla
 *
 * @author victo
 */
class Plantilla extends \Prototipo\Operaciones {

    var $estado = 'Plantilla';
    var $cod_cliente = '';
    var $id_usuario = '';

    public function lista() {
        $pen = array();
        $sql = "SELECT tmp_cotizacion.codigo as codFact, fecha, nombre,total,tmp_cotizacion.estatus as status, nota,usuario   "
                . "FROM tmp_cotizacion,usuario"
                . " WHERE tmp_cotizacion.usuario = usuario.codigo order by fecha desc";
        $query = $this->query($sql) or die($this->con->error);
        while ($row = mysqli_fetch_array($query)) {
            $detalle = array();
            $sql = $this->query('SELECT codProducto FROM detallecotizacion WHERE codCotizacion = ' . $row['codFact']);
            while ($row2 = $sql->fetch_array()) {
                $detalle[] = $row2['codProducto'];
            }
            $pen[] = array(
                'codigo' => $row['codFact'],
                'fecha' => $row['fecha'],
                'nombre' => $row['nombre'],
                'monto' => (float) $row['total'],
                'status' => (int) $row['status'],
                'nota' => $row['nota'],
                'usuario' => (int) $row['usuario'],
                'detalles' => $detalle,
            );
        }
        return $this->getResponse($pen);
    }

    public function detalle($id) {
        $query = $this->query("SELECT * FROM tmp_cotizacion where codigo = $id");
        $cotizacion = array();
        if ($row = $query->fetch_array()) {
            //datos del cliente
            $cliente = new Cliente();
            $cotizacion['cliente'] = $cliente->detalles($row['cod_cliente']);
            $cotizacion['cod_cliente'] = $row['cod_cliente'];
            //datos del usuario
            $usuario = new Usuario();
            $compra['usuario'] = $usuario->detalles($row['usuario']);
            $compra['cod_usuario'] = $row['usuario'];
            //datos de plantilla
            $cotizacion['codigo'] = $row['codigo'];
            $cotizacion['forma_pago'] = $row['forma_pago'];
            $cotizacion['tiempo_entrega'] = $row['tiempo_entrega'];
            $cotizacion['validez'] = $row['validez'];
            $cotizacion['nota'] = $row['nota'];
            $cotizacion['fecha'] = $row['fecha'];
            $cotizacion['impuesto'] = $row['iva'];
            //detalle de la plantilla
            $cotizacion['detalles'] = array();
            $query = $this->query("SELECT * from tmp_detalle_cotizacion where codCotizacion = $id");
            $producto = new Producto();
            while ($row = $query->fetch_array()) {
                $detalle = $producto->ver($row['codProducto']);
                $detalle['unidades'] = (float) $row['cantidad'];
                $detalle['precio'] = (float) $row['precio_unit'];
                $detalle['comentario'] =  $row['comentario'];
                $cotizacion['detalles'][] = $detalle;
            }
        }
        return $this->getResponse($cotizacion);
    }

    public function guardar($id_cotizacion) {
        if ($id_cotizacion > 0) {
            echo $id_cotizacion;
            return $this->actualizar($id_cotizacion);
        } else {
            return $this->nuevo();
        }
    }

    public function saveDetalles($id_cotizacion) {
        foreach ($this->detalles as $pro) {
            $monto = $pro->unidades * $pro->precio;
            $this->query("INSERT INTO tmp_detalle_cotizacion VALUES ("
                    . "'$id_cotizacion',"
                    . "'$pro->codigo',"
                    . "'$pro->unidades',"
                    . "'$pro->precio', "
                    . "'$monto',"
                    . "'$pro->comentario') ");
        }
        $this->actualizarEstado();
    }

    public function nuevo() {
        $this->id_usuario = $_SESSION['id_usuario'];
        $this->query("INSERT into tmp_cotizacion values("
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
                . " 1,"
                . "$this->id_usuario)");
        $id_cotizacion = $this->con->insert_id;
        $this->saveDetalles($id_cotizacion);
        return $this->getResponse($id_cotizacion);
    }

    public function actualizar($id_cotizacion) {
        $id_usuario = $_SESSION['id_usuario'];
        $this->query("DELETE FROM `tmp_detalle_cotizacion` WHERE codCotizacion=$id_cotizacion");
        $query = $this->query("UPDATE `tmp_cotizacion` SET"
                . " `cod_cliente`='$this->cod_cliente',"
                . "`fecha`=NOW(),"
                . "`iva`='$this->impuesto',"
                . "`subtotal`='$this->subtotal',"
                . "`total`='$this->total',"
                . "`forma_pago`=UPPER('$this->forma_pago'),"
                . "`tiempo_entrega`=UPPER('$this->tiempo_entrega'),"
                . "`validez`=UPPER('$this->validez'),"
                . "`nota`=UPPER('$this->nota') "
                . "WHERE `codigo`='$id_cotizacion'");
        $this->query("DELETE FROM `tmp_detalle_cotizacion` WHERE codCotizacion=$id_cotizacion");
        $this->saveDetalles($id_cotizacion);
        return $this->getResponse($id_cotizacion);
    }

    public function borrar($id_cotizacion) {
        $this->query("DELETE FROM `tmp_cotizacion` WHERE codigo=$id_cotizacion");
        $this->query("DELETE FROM `tmp_detalle_cotizacion` WHERE codCotizacion=$id_cotizacion");
    }

}
