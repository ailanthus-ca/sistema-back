<?php

namespace Control;

class Cotizacion {

    function lista() {
        $Cotizacion = new \Modelos\Cotizacion();
        return json_encode($Cotizacion->lista());
    }

    function detalles($id) {
        $Cotizacion = new \Modelos\Cotizacion();
        return json_encode($Cotizacion->detalles($id));
    }

    function nuevo() {
        $Cotizacion = new \Modelos\Cotizacion();
        $Cotizacion->cod_cliente = $Cotizacion->postString('cod_cliente');
        $Cotizacion->forma_pago = $Cotizacion->postString("forma_pago");
        $Cotizacion->tiempo_entrega = $Cotizacion->postString("tiempo_entrega");
        $Cotizacion->validez = $Cotizacion->postString("validez");
        $Cotizacion->nota = $Cotizacion->postString("nota");
        $Cotizacion->impuesto = $Cotizacion->postFloat("impuesto");
        $Cotizacion->subtotal = $Cotizacion->postFloat("subtotal");
        $Cotizacion->total = $Cotizacion->postFloat("total");
        $Cotizacion->detalles = $Cotizacion->postArray("detalles");
        $Cotizacion->codigo = $Cotizacion->postString("codigo");

        //validaciones para cod_cliente 
        if ($Cotizacion->cod_cliente == '') {
            $Cotizacion->setError('Debe mandar un cliente');
        }
        // Validar cliente
        $Cliente = new \Modelos\Cliente();
        $Cliente->detalles($Cotizacion->cod_cliente);
        if ($Cliente->response == 404) {
            $Cotizacion->setError('El cliente mandado no existe');
        }
        // Validar total
        if ($Cotizacion->total == 0) {
            $Cotizacion->setError('No se mando el total');
        }
        // Validar si existe al menos un item(producto)
        if (count($Cotizacion->detalles) == 0) {
            $Cotizacion->setError('No se mandaron productos');
        }
        //Validar si hubo errores
        if ($Cotizacion->response > 300) {
            return json_encode($Cotizacion->getResponse());
        }
        // Validar que exista cotizacion
        if ($Cotizacion->checkCodigo($Cotizacion->codigo)) {
            return $Cotizacion->getResponse($Cotizacion->detalles($Cotizacion->codigo));
        }

        return json_encode($Cotizacion->nuevo());
    }

    function cancelar($id) {
        $Cotizacion = new \Modelos\Cotizacion();
        return json_encode($Cotizacion->cancelar($id));
    }

    function seguimiento($id) {
        $Cotizacion = new \Modelos\Cotizacion();
        return json_encode($Cotizacion->seguimiento($id));
    }

    function seguimiento_nuevo($id) {
        $Cotizacion = new \Modelos\Cotizacion();
        $descripcion = $Cotizacion->postString('descripcion');
        return json_encode($Cotizacion->seguimiento_nuevo($id, $descripcion));
    }

    function PDF($id) {
        $Cotizacion = new \Modelos\Cotizacion();
        $data = $Cotizacion->detalles($id);
        $pdf = new \PDF\Cotizacion();
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

    function PDFD($id) {
        $Cotizacion = new \Modelos\Cotizacion();
        $data = $Cotizacion->detalles($id);
        $d = $data['detalles'];
        $data['detalles'] = array();
        $detalle = array();
        foreach ($d as $row) {
            $detalle = $row;
            $detalle['precio'] = $row['precio'] / $data['tasa'];
            $data['detalles'][] = $detalle;
        }
        $pdf = new \PDF\Cotizacion();
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

    function guardar() {
        $Cotizacion = new \Modelos\Plantilla();
        $Cotizacion->cod_cliente = $Cotizacion->postString('cod_cliente');
        $Cotizacion->forma_pago = $Cotizacion->postString("forma_pago");
        $Cotizacion->tiempo_entrega = $Cotizacion->postString("tiempo_entrega");
        $Cotizacion->validez = $Cotizacion->postString("validez");
        $Cotizacion->nota = $Cotizacion->postString("nota");
        $Cotizacion->impuesto = $Cotizacion->postFloat("impuesto");
        $Cotizacion->subtotal = $Cotizacion->postFloat("subtotal");
        $Cotizacion->total = $Cotizacion->postFloat("total");
        $Cotizacion->detalles = $Cotizacion->postArray("detalles");
        return json_encode($Cotizacion->guardar($Cotizacion->postIntenger("plantilla")));
    }

    function cargar($id) {
        $Cotizacion = new \Modelos\Plantilla();
        return json_encode($Cotizacion->detalle($id));
    }

    function plantillas() {
        $Cotizacion = new \Modelos\Plantilla();
        return json_encode($Cotizacion->lista());
    }

    function reporte($rango, $p1, $p2) {
        $Factura = new \Modelos\Cotizacion();
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
            'operacion' => 'COTIZACION'
        );
        $pdf = new \PDF\Reportes();
        $pdf->version = 'factura';
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

}
