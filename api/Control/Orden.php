<?php

namespace Control;

class Orden {

    function lista() {
        $Orden = new \Modelos\Orden();
        return json_encode($Orden->lista());
    }

    function detalles($id) {
        $Orden = new \Modelos\Orden();
        return json_encode($Orden->detalles($id));
    }

    function nuevo() {
        $Orden = new \Modelos\Orden();
        $Orden->cod_proveedor = $Orden->postString('cod_proveedor');
        $Orden->forma_pago = $Orden->postString("forma_pago");
        $Orden->tiempo_entrega = $Orden->postString("tiempo_entrega");
        $Orden->validez = $Orden->postString("validez");
        $Orden->nota = $Orden->postString("nota");
        $Orden->impuesto = $Orden->postFloat("impuesto");
        $Orden->subtotal = $Orden->postFloat("subtotal");
        $Orden->total = $Orden->postFloat("total");
        $Orden->detalles = $Orden->postArray("detalles");

        $Orden->codigo = $Orden->postString('codigo');

        // Validar que exista el cod_proveedor
        if ($Orden->cod_proveedor == '') {
            $Orden->setError('Debe mandar un proveedor');
        }
        // Validar proveedor
        $proveedor = new \Modelos\Proveedor();
        $proveedor->detalles($Orden->cod_proveedor);
        if ($proveedor->response == 404) {
            $Orden->setError('El proveedor mandado no existe');
        }
        // Validar si existe al menos un item(producto)
        if (count($Orden->detalles) == 0) {
            $Orden->setError('No se mandaron productos');
        }
        // Validar total
        if ($Orden->total == 0) {
            $Orden->setError('No se mando el total');
        }

        //Validar si hubo errores
        if ($Orden->response > 300) {
            return json_encode($Orden->getResponse());
        }
        // Validar que exista Orden
        if ($Orden->checkCodigo($Orden->codigo)) {
            return $Orden->getResponse($Orden->detalles($Orden->codigo));
        }

        return json_encode($Orden->nuevo());
    }

    function cancelar($id) {
        $Orden = new \Modelos\Orden();
        return json_encode($Orden->cancelar($id));
    }

    function seguimiento($id) {
        $Orden = new \Modelos\Orden();
        return json_encode($Orden->seguimiento($id));
    }

    function seguimiento_nuevo($id) {
        $Orden = new \Modelos\Orden();
        $descripcion = $Orden->postString('descripcion');
        return json_encode($Orden->seguimiento_nuevo($id, $descripcion));
    }

    function PDF($id) {
        $Orden = new \Modelos\Orden();
        $data = $Orden->detalles($id);
        $pdf = new \PDF\Orden();
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Orden.pdf', $content);
    }

    function reporte($rango, $p1, $p2) {
        $orden = new \Modelos\Orden();
        switch ($rango) {
            case 'ano':
                $where = " AND YEAR(fecha) = $p1 ";
                $titulo = "AÑO $p1";
                break;
            case 'mes':
                $where = " AND YEAR(fecha)= $p1 AND month(fecha) = $p2 ";
                $m = $orden->numberToMes($p2);
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
        $data = array(
            'lista' => $orden->listaWhere($where),
            'titulo' => $titulo,
            'operacion' => 'ORDEN DE COMPRA'
        );
        $pdf = new \PDF\Reportes();
        $pdf->version = 'orden';
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

    function de($cod, $rango, $p1, $p2) {
        $orden = new \Modelos\Orden();
        switch ($rango) {
            case 'ano':
                $where = " AND YEAR(fecha) = $p1 ";
                $titulo = "AÑO $p1";
                break;
            case 'mes':
                $where = " AND YEAR(fecha)= $p1 AND month(fecha) = $p2 ";
                $m = $orden->numberToMes($p2);
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
            'orden' => $orden->listaWithProducto($cod, $where . ' AND ordencompra.estatus > 0'),
            'titulo' => $pro['descripcion'] . '<br>' . $titulo,
            'operacion' => 'ORDEN DE COMPRA'
        );
        $pdf = new \PDF\Reportes();
        $pdf->version = 'ordenPor';
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

    function productos($dpt, $rango, $p1, $p2) {
        $orden = new \Modelos\Orden();
        switch ($rango) {
            case 'ano':
                $where = " AND YEAR(fecha) = $p1 ";
                $titulo = "AÑO $p1";
                break;
            case 'mes':
                $where = " AND YEAR(fecha)= $p1 AND month(fecha) = $p2 ";
                $m = $orden->numberToMes($p2);
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
            'itens' => $orden->productos($where . ' AND ordencompra.estatus > 0'),
            'titulo' => $titulo,
            'operacion' => 'ORDENES DE COMPRA'
        );
        $pdf = new \PDF\Reportes();
        $pdf->version = 'productosDe';
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }
}
