<?php

namespace Modelos;

class Compra extends \Prototipo\Operaciones {

    var $id_orden = 0;
    var $cod_proveedor = '';
    var $cod_documento = '';
    var $fecha_doc = '';
    var $num_con = '';

    public function lista() {
        $pen = array();
        $sql = "SELECT "
                . "compra.codigo as codFact,"
                . "telefono,correo,contacto, "
                . "fecha,"
                . " nombre,"
                . "total,"
                . "compra.estatus as status,"
                . "compra.nota,"
                . "compra.usuario  "
                . "FROM compra,proveedor "
                . "WHERE compra.cod_proveedor = proveedor.codigo order by fecha DESC ";
        $query = $this->query($sql);
        while ($row = mysqli_fetch_array($query)) {
            $detalle = array();
            $sql = $this->query("SELECT cod_producto FROM detallecompra WHERE cod_compra = " . $row['codFact']);
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
                'nota' => $row['nota'],
                'usuario' => (int) $row['usuario'],
                'status' => (int) $row['status'],
                'detalles' => $detalle
            );
        }
        return $this->getResponse($pen);
    }

    function detalles($id) {
        $sql = "SELECT * FROM compra where codigo = $id";
        $query = $this->query($sql);
        $compra = array();
        if ($row = $query->fetch_array()) {
            //datos del proveedor
            $proveedor = new Proveedor();
            $compra = $proveedor->detalles($row['cod_proveedor']);
            $compra['cod_proveedor'] = $row['cod_proveedor'];
            //datos de la compra
            $compra['codigo'] = (int) $row['codigo'];
            $compra['fecha'] = $row['fecha'];
            $compra['cod_documento'] = $row['cod_documento'];
            $compra['fecha_documento'] = $row['fecha_documento'];
            $compra['nota'] = $row['nota'];
            $compra['estatus'] = (int) $row['estatus'];
            $compra['impuesto'] = (float) $row['impuesto'];
            $sql = "SELECT * FROM `usuario` where codigo = '" . $row['usuario'] . "'";
            $query = $this->query($sql);
            if ($row = $query->fetch_array()) {
                $compra['user'] = $row['nombre'];
            }
            $compra['detalles'] = array();
            $sql = "SELECT * from detallecompra where cod_compra = '" . $compra['codigo'] . "'";
            $query = $this->query($sql);
            $producto = new Producto();
            while ($row = $query->fetch_array()) {
                $detalle = $producto->ver($row['cod_producto']);
                $detalle['unidades'] = (float) $row['cantidad'];
                $detalle['precio'] = (float) $row['precio_unit'];
                $compra['detalles'][] = $detalle;
            }
            return $compra;
        } else {
            return $this->getNotFount('compra no encontrada');
        }
    }

    function checkCodigo($cod) {
        $sql = $this->query('SELECT count(*) AS exist FROM compra WHERE codigo="' . $cod . '"');
        if ($row = $sql->fetch_array()) {
            return boolval($row['exist']);
        }
    }

    function nuevo() {
        //usuario
        $user = $_SESSION['id_usuario'];
        $sql = $this->query('SELECT COUNT(*) as cant FROM `compra`');
        $row = $sql->fetch_array();
        $cod_compra = $row['cant'] + 1;
        $this->query("INSERT INTO compra VALUES ("
                . "'$cod_compra',"
                . "'$this->cod_proveedor',"
                . "'$this->cod_documento',"
                . "'$this->num_con',"
                . "NOW(),"
                . "'$this->fecha_doc',"
                . "$this->subtotal, "
                . "$this->impuesto,"
                . "$this->total,"
                . "'$this->nota',"
                . "$user,"
                . "$this->etatus)");
        //;
        $productos = new \Modelos\Producto();
        foreach ($this->detalles as $iten) {
            $monto = $iten->unidades * $iten->precio;
            $this->query("INSERT INTO `detallecompra` VALUES("
                    . "$cod_compra,"
                    . "'$iten->codigo',"
                    . "$iten->unidades,"
                    . "$iten->precio,"
                    . "$monto)");
            $productos->entrada($iten->codigo, $iten->unidades, $iten->precio);
        }
        if ($this->id_orden > 0) {
            $orden = new \Modelos\Orden();
            $orden->procesar($this->id_orden);
        }
        return $this->getResponse($cod_compra);
    }

    function cancelar($id) {
        $sql = "UPDATE `compra` SET `estatus`= 0 WHERE codigo = $id";
        $query = $this->query($sql);
        $sql2 = $this->query("select * from detallecompra where cod_compra = '$id' ");
        $productos = new \Modelos\Producto();
        while ($row = $sql2->fetch_array()) {
            $cod = $row['cod_producto'];
            $cantidad = intval($row['cantidad']);
            $productos->salida($cod, $cantidad);
        }
        return 1;
    }

    public function getFactura() {
        $this->cod_documento = $this->postString('cod_documento');
        $this->num_con = $this->postString('num_con');
        $fecha = (isset($_POST['fecha_doc']) && $_POST['fecha_doc'] != NULL) ? $_POST['fecha_doc'] : '';
        //fecha valida
        $this->fecha_doc = date("Y-m-d", strtotime($fecha));
        //factura ingresada
        if ($this->cod_documento === '') {
            $this->etatus = 1;
        } else {
            $this->etatus = 2;
        }
    }

    function facturar($id) {
        $query = $this->query("UPDATE `compra` SET  "
                . "nun_control='$this->num_con',"
                . "`cod_documento`='$this->cod_documento',`"
                . "fecha_documento`='$this->fecha_doc',"
                . "`estatus`= $this->etatus WHERE codigo = $id");
        return 1;
    }

}
