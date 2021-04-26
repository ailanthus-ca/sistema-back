<?php

namespace Control;

class Factura extends \conexion {

    function lista() {
        $Factura = new \Modelos\Factura();
        return json_encode($Factura->lista());
    }

    function detalles($id) {
        $Factura = new \Modelos\Factura();
        return json_encode($Factura->detalles($id));
    }

    function nuevo() {
        $Factura = new \Modelos\Factura();
        $Factura->cod_cliente = $Factura->postString('cod_cliente');
        $Factura->porc_impuesto = $Factura->postString('porc_impuesto');
        $Factura->costo = $Factura->postString('costo');
        $Factura->condicion = $Factura->postString('condicion');
        $Factura->id_cotizacion = $Factura->postString('id_cotizacion');
        $Factura->id_nota = $Factura->postString('id_nota');
        $Factura->nota = $Factura->postString("nota");
        $Factura->impuesto = $Factura->postFloat("impuesto");
        $Factura->subtotal = $Factura->postFloat("subtotal");
        $Factura->total = $Factura->postFloat("total");
        $Factura->detalles = $Factura->postArray("detalles");

        $Factura->codigo = $Factura->postString('codigo');

        if ($Factura->id_nota > 0) {
            $nota = new Nota();
            $Factura->user = $nota->procesar($Factura->id_nota);
        } elseif ($Factura->id_cotizacion > 0) {
            $cotizacion = new Cotizacion();
            $Factura->user = $cotizacion->procesar($Factura->id_cotizacion);
        } else {
            $Factura->user = $_SESSION['id_usuario'];
        }

        // Validar que exista el cliente
        if ($Factura->cod_cliente == '') {
            $Factura->setError('Debe mandar un cliente');
        }
        // Validar cliente
        $Cliente = new \Modelos\Cliente();
        $Cliente->detalles($Factura->cod_cliente);
        if ($Cliente->response == 404) {
            $Factura->setError('El cliente mandado no existe');
        }
        // Validar si existe al menos un item(producto)
        if (count($Factura->detalles) == 0) {
            $Factura->setError('No se mandaron productos');
        }
        // Validar total
        if ($Factura->total == 0) {
            $Factura->setError('No se mando el total');
        }
        $producto = new \Modelos\Producto();
        foreach ($Factura->detalles as $pro) {
            $producto->cargar($pro->codigo);
            if (!$producto->checkCosto($pro->precio)) {
                $Factura->setError($producto->descripcion . 'NO SE PUEDE VENDER POR DEBAJO DEL COSTO');
            }
            if (!$producto->checkPrecio($pro->precio)) {
                $Factura->setError($producto->descripcion . 'NO SE PUEDE VENDER POR DEBAJO DEL PRECIO 1');
            }
            if (!$producto->checkStock($pro->unidades)) {
                $Factura->setError($producto->descripcion . 'NO TIENE STOCK SUFICIENTE PARA REALIZAR LA VENTA');
            }
        }
        //Validar si hubo errores
        if ($Factura->response > 300) {
            return json_encode($Factura->getResponse());
        }
        // Validar que exista factura
        if ($Factura->checkCodigo($Factura->codigo)) {
            return $Factura->getResponse($Factura->detalles($Factura->codigo));
        }

        return json_encode($Factura->nuevo());
    }

    function cancelar($id) {
        $Factura = new \Modelos\Factura();
        return json_encode($Factura->cancelar($id));
    }

    function PDF($id) {
        $Factura = new \Modelos\Factura();
        $data = $Factura->detalles($id);
        $pdf = new \PDF\Factura();
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

    function reporte($rango, $p1, $p2) {
        $Factura = new \Modelos\Factura();
        $where = " AND factura.estatus = 2";
        switch ($rango) {
            case 'ano':
                $where = " AND YEAR(fecha) = $p1 ";
                $titulo = "AÑO $p1";
                break;
            case 'mes':
                $where = " AND YEAR(fecha)= $p1 AND month(fecha) = $p2 ";
                $m = $Factura->numberToMes($p2);
                $titulo = "$m DEl $p1";
                break;
            case 'rango':
                $date1 = new \DateTime($p1);
                $date2 = new \DateTime($p2);
                $where = " AND fecha between '$p1' AND '$p2' ";
                $titulo = "DESDE " . $date1->format("d/m/Y") . " HASTA " . $date2->format("d/m/Y");
                break;
            default :
                $where = "";
                $titulo = "TODO";
                break;
        }
        $data = array(
            'lista' => $Factura->listaWhere($where),
            'titulo' => $titulo,
            'operacion' => 'FACTURA'
        );
        $pdf = new \PDF\Reportes();
        $pdf->version = 'factura';
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

    function reporteVendedor($user, $rango, $p1, $p2) {
        $Factura = new \Modelos\Factura();
        $where = " AND factura.usuario=$user AND factura.estatus = 2";
        $usuario = new \Modelos\Usuario();
        $userData = $usuario->detalles($user);
        $titulo = $userData['nombre'] . '<br>';
        switch ($rango) {
            case 'ano':
                $where .= " AND YEAR(fecha) = $p1 ";
                $titulo .= "AÑO $p1";
                break;
            case 'mes':
                $where .= " AND YEAR(fecha)= $p1 AND month(fecha) = $p2 ";
                $m = $Factura->numberToMes($p2);
                $titulo .= " $m DEL $p1";
                break;
            case 'rango':
                $date1 = new \DateTime($p1);
                $date2 = new \DateTime($p2);
                $where .= "AND fecha between '$p1' AND '$p2' ";
                $titulo .= " DESDE " . $date1->format("d/m/Y") . " HASTA " . $date2->format("d/m/Y");
                break;
        }
        $data = array(
            'facturas' => $Factura->listaWhere($where),
            'titulo' => $titulo
        );
        $pdf = new \PDF\Reportes();
        $pdf->version = 'factura';
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

    function de($cod, $rango, $p1, $p2) {
        $facturas = new \Modelos\Factura();
        switch ($rango) {
            case 'ano':
                $where = " AND YEAR(fecha) = $p1 ";
                $titulo = "AÑO $p1";
                break;
            case 'mes':
                $where = " AND YEAR(fecha)= $p1 AND month(fecha) = $p2 ";
                $m = $facturas->numberToMes($p2);
                $titulo = "$m DEL $p1";
                break;
            case 'rango':
                $date1 = new \DateTime($p1);
                $date2 = new \DateTime($p2);
                $where = " AND fecha between '$p1' AND '$p2' ";
                $titulo = "DESDE " . $date1->format("d/m/Y") . " HASTA " . $date2->format("d/m/Y");
                break;
            default :
                $where = "";
                $titulo = "TODO";
                break;
        }
        $producto = new \Modelos\Producto();
        $pro = $producto->ver($cod);
        $data = array(
            'facturas' => $facturas->listaWithProducto($cod, $where . ' AND factura.estatus > 0'),
            'titulo' => $pro['descripcion'] . '<br>' . $titulo,
            'operacion' => 'FACTURAS'
        );
        $pdf = new \PDF\Reportes();
        $pdf->version = 'facturaPor';
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

}
