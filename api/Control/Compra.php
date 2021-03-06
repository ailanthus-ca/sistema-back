<?php

namespace Control;

class Compra {

    public function cambios($fecha, $hora) {
        $compras = new \Modelos\Compra();
        return json_encode($compras->cambios($fecha, $hora));
    }

    function lista() {
        $compras = new \Modelos\Compra();
        return json_encode($compras->lista());
    }

    function detalles($id) {
        $compras = new \Modelos\Compra();
        return json_encode($compras->detalles($id));
    }

    function cancelar($id) {
        $compras = new \Modelos\Compra();
        return json_encode($compras->Cancelar($id));
    }

    function facturar($id) {
        $compras = new \Modelos\Compra();
        $compras->cod_documento = $compras->postString('cod_doc');
        $compras->num_con = $compras->postString('num_con');
        $fecha = (isset($_POST['fecha_doc']) && $_POST['fecha_doc'] != NULL) ? $_POST['fecha_doc'] : '';
        //fecha valida
        $compras->fecha_doc = date("Y-m-d", strtotime($fecha));
        //factura ingresada
        if ($compras->cod_documento === '') {
            $compras->etatus = 1;
        } else {
            $compras->etatus = 2;
        }
        return json_encode($compras->facturar($id));
    }

    function nuevo() {
        $compras = new \Modelos\Compra();
        $compras->cod_compra = $compras->postIntenger('cod_compra');
        $compras->id_orden = $compras->postIntenger('id_orden');
        $compras->cod_proveedor = $compras->postString('cod_proveedor');
        $compras->nota = $compras->postString("nota");
        $compras->impuesto = $compras->postFloat("impuesto");
        $compras->subtotal = $compras->postFloat("subtotal");
        $compras->total = $compras->postFloat("total");
        $compras->detalles = $compras->postArray("detalles");
        $compras->cod_documento = $compras->postString('cod_documento');
        $compras->num_con = $compras->postString('num_control');
        $fecha = (isset($_POST['fecha_documento']) && $_POST['fecha_documento'] != NULL) ? $_POST['fecha_documento'] : '';
        //fecha valida
        $compras->fecha_doc = date("Y-m-d", strtotime($fecha));
        //factura ingresada
        if ($compras->cod_documento === '') {
            $compras->etatus = 1;
        } else {
            $compras->etatus = 2;
        }

        // Validar que exista el cod_proveedor
        if ($compras->cod_proveedor == '') {
            $compras->setError('DEBE ASIGNAR UN PROVEEDOR');
        }
        // Validar proveedor
        $proveedor = new \Modelos\Proveedor();
        $proveedor->detalles($compras->cod_proveedor);
        if ($proveedor->response == 404) {
            $compras->setError('EL PROVEEDOR ASIGNADO NO EXISTE');
        }
        // Validar si existe al menos un item(producto)
        if (count($compras->detalles) == 0) {
            $compras->setError('NO SE MANDARON PRODUCTOS');
        }
        // Validar total
        if ($compras->total == 0) {
            $compras->setError('NO SE MANDO EL TOTAL');
        }
        //Validar si hubo errores
        if ($compras->response > 300) {
            return json_encode($compras->getResponse());
        }
        // Validar que exista compra
        if ($compras->checkCodigo($compras->cod_compra)) {
            return $compras->getResponse($compras->detalles($compras->cod_compra));
        }

        return json_encode($compras->nuevo());
    }

    function PDF($id) {
        $compras = new \Modelos\Compra();
        $data = $compras->detalles($id);
        $pdf = new \PDF\Compra();
        ob_start();
        $pdf->ver($data,'BS');
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

    function PDFD($id) {
        $compras = new \Modelos\Compra();
        $data = $compras->detalles($id);
        if ($data['tasa'] == 0)
            return "<h1>ESTA COMPRA NO POSEE MONTO EN DOLARES</h1>";
        $d = $data['detalles'];
        $data['detalles'] = array();
        $detalle = array();
        foreach ($d as $row) {
            $detalle = $row;
            $detalle['precio'] = $row['precio'] / $data['tasa'];
            $data['detalles'][] = $detalle;
        }
        $pdf = new \PDF\Compra();
        ob_start();
        $pdf->ver($data,'$');
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

    function reporte($rango, $p1, $p2) {
        $Factura = new \Modelos\Compra();
        $where = " AND factura.estatus = 2";
        switch ($rango) {
            case 'ano':
                $where = " AND YEAR(fecha) = $p1 ";
                $titulo = "A??O $p1";
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
            'compras' => $Factura->listaWhere($where),
            'titulo' => $titulo,
        );
        $pdf = new \PDF\Reportes();
        $pdf->version = 'compra';
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

    function de($cod, $rango, $p1, $p2) {
        $compras = new \Modelos\Compra();
        switch ($rango) {
            case 'ano':
                $where = " AND YEAR(fecha) = $p1 ";
                $titulo = "A??O $p1";
                break;
            case 'mes':
                $where = " AND YEAR(fecha)= $p1 AND month(fecha) = $p2 ";
                $m = $compras->numberToMes($p2);
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
        $producto = new \Modelos\Producto();
        $pro = $producto->ver($cod);
        $data = array(
            'compras' => $compras->listaWithProducto($cod, $where . ' AND compra.estatus > 0'),
            'titulo' => $pro['descripcion'] . '<br>' . $titulo
        );
        $pdf = new \PDF\Reportes();
        $pdf->version = 'compraPor';
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

    function productos($dpt, $rango, $p1, $p2) {
        $compra = new \Modelos\Compra();
        switch ($rango) {
            case 'ano':
                $where = " AND YEAR(fecha) = $p1 ";
                $titulo = "A??O $p1";
                break;
            case 'mes':
                $where = " AND YEAR(fecha)= $p1 AND month(fecha) = $p2 ";
                $m = $compra->numberToMes($p2);
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
        if ($dpt !== 'TODO') {
            $where .= " and departamento = '$dpt'";
            $dp = new \Modelos\Departamento();
            $row = $dp->detalles($dpt);
            $titulo .= '<br> DEL DEPARTAMENTO ' . $row['descripcion'];
        }
        $data = array(
            'itens' => $compra->productos($where . ' AND compra.estatus > 0'),
            'titulo' => $titulo,
            'operacion' => 'COMPRA'
        );
        $pdf = new \PDF\Reportes();
        $pdf->version = 'productosDe';
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

    function torta($rango, $p1, $p2) {
        $compra = new \Modelos\Compra();
        $data = array();
        switch ($rango) {
            case 'ano':
                $where = " YEAR(fecha) = $p1 ";
                $titulo = "A??O $p1";
                break;
            case 'mes':
                $where = " YEAR(fecha)= $p1 AND month(fecha) = $p2 ";
                $m = $compra->numberToMes($p2);
                $titulo = "$m DEl $p1";
                break;
            default :
                $where = "";
                $titulo = "TODO";
                break;
        }
        $data = $compra->torta($where);
        return json_encode($data);
    }

    function linea($rango, $p1, $p2) {
        $compra = new \Modelos\Compra();
        $data = array();
        switch ($rango) {
            case 'ano':
                $data = $compra->compraAno($p1);
                break;
            case 'mes':
                $data = $compra->compraMes($p1, $p2);
                break;
        }
        return json_encode($data);
    }

    function creditos() {
        $c = new \Modelos\CreditoRecibido;
        return json_encode($c->lista());
    }

    function detallesCredito($cod) {
        $c = new \Modelos\CreditoRecibido;
        return json_encode($c->detalles($cod));
    }

    function nuevoCredito() {
        $c = new \Modelos\CreditoRecibido;
        $c->recibir();
        return json_encode($c->nuevo());
    }

    function eliminarCredito($cod) {
        $c = new \Modelos\CreditoRecibido;
        return json_encode($c->cancelar($cod));
    }

    function debitos() {
        $d = new \Modelos\CreditoRecibido;
        return json_encode($d->lista());
    }

    function detallesDebito($dod) {
        $d = new \Modelos\DebitoRecibido;
        return json_encode($d->detalles($dod));
    }

    function nuevoDebito() {
        $d = new \Modelos\DebitoRecibido;
        $d->recibir();
        return json_encode($d->nuevo());
    }

    function eliminarDebito($cod) {
        $d = new \Modelos\DebitoRecibido;
        return json_encode($d->cancelar($cod));
    }

}
