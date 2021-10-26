<?php

namespace Control;

class Cotizacion
{

    public function lista()
    {
        $Cotizacion = new \Modelos\Cotizacion();
        return json_encode($Cotizacion->lista());
    }

    public function detalles($id)
    {
        $Cotizacion = new \Modelos\Cotizacion();
        return json_encode($Cotizacion->detalles($id));
    }

    public function nuevo()
    {
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

    public function cancelar($id)
    {
        $Cotizacion = new \Modelos\Cotizacion();
        return json_encode($Cotizacion->cancelar($id));
    }

    public function seguimiento($id)
    {
        $Cotizacion = new \Modelos\Cotizacion();
        return json_encode($Cotizacion->seguimiento($id));
    }

    public function seguimiento_nuevo($id)
    {
        $Cotizacion = new \Modelos\Cotizacion();
        $descripcion = $Cotizacion->postString('descripcion');
        return json_encode($Cotizacion->seguimiento_nuevo($id, $descripcion));
    }

    public function PDF($id)
    {
        $Cotizacion = new \Modelos\Cotizacion();
        $data = $Cotizacion->detalles($id);
        $pdf = new \PDF\Cotizacion();
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

    public function PDFD($id)
    {
        $Cotizacion = new \Modelos\Cotizacion();
        $data = $Cotizacion->detalles($id);        
        if( $data['tasa']==0) return "<h1>ESTA COTIZACION NO POSEE MONTO EN DOLARES</h1>";    
        $d = $data['detalles'];
        $data['detalles'] = array();
        $detalle = array();
        foreach ($d as $row) {
            $detalle = $row;
            $detalle['precio'] = round($row['precio'] / $data['tasa'], 2);
            $data['detalles'][] = $detalle;
        }
        $pdf = new \PDF\Cotizacion();
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

    public function guardar()
    {
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

    public function cargar($id)
    {
        $Cotizacion = new \Modelos\Plantilla();
        return json_encode($Cotizacion->detalle($id));
    }

    public function plantillas()
    {
        $Cotizacion = new \Modelos\Plantilla();
        return json_encode($Cotizacion->lista());
    }

    public function reporte($rango, $p1, $p2)
    {
        $cotizacion = new \Modelos\Cotizacion();
        switch ($rango) {
            case 'ano':
                $where = " AND YEAR(fecha) = $p1 ";
                $titulo = "AÑO $p1";
                break;
            case 'mes':
                $where = " AND YEAR(fecha)= $p1 AND month(fecha) = $p2 ";
                $m = $cotizacion->numberToMes($p2);
                $titulo = "$m DEL $p1";
                break;
            case 'rango':
                $date1 = new \DateTime($p1);
                $date2 = new \DateTime($p2);
                $where = " AND fecha between '$p1' AND '$p2' ";
                $titulo = "DESDE " . $date1->format("d/m/Y") . " HASTA " . $date2->format("d/m/Y");
                break;
            default:
                $where = "";
                $titulo = "TODO";
                break;
        }
        $data = array(
            'lista' => $cotizacion->listaWhere($where),
            'titulo' => $titulo,
            'operacion' => 'COTIZACION',
        );
        $pdf = new \PDF\Reportes();
        $pdf->version = 'factura';
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

    public function de($cod, $rango, $p1, $p2)
    {
        $cotizacion = new \Modelos\Cotizacion();
        switch ($rango) {
            case 'ano':
                $where = " AND YEAR(fecha) = $p1 ";
                $titulo = "AÑO $p1";
                break;
            case 'mes':
                $where = " AND YEAR(fecha)= $p1 AND month(fecha) = $p2 ";
                $m = $cotizacion->numberToMes($p2);
                $titulo = "$m DEL $p1";
                break;
            case 'rango':
                $date1 = new \DateTime($p1);
                $date2 = new \DateTime($p2);
                $where = " AND fecha between '$p1' AND '$p2' ";
                $titulo = "DESDE " . $date1->format("d/m/Y") . " HASTA " . $date2->format("d/m/Y");
                break;
            default:
                $where = "";
                $titulo = "TODO";
                break;
        }
        $producto = new \Modelos\Producto();
        $pro = $producto->ver($cod);
        $data = array(
            'facturas' => $cotizacion->listaWithProducto($cod, $where . ' AND cotizacion.estatus > 0'),
            'titulo' => $pro['descripcion'] . '<br>' . $titulo,
            'operacion' => 'COTIZACION',
        );
        $pdf = new \PDF\Reportes();
        $pdf->version = 'facturaPor';
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

    public function productos($dpt, $rango, $p1, $p2)
    {
        $cotizacion = new \Modelos\Cotizacion();
        switch ($rango) {
            case 'ano':
                $where = " AND YEAR(fecha) = $p1 ";
                $titulo = "AÑO $p1";
                break;
            case 'mes':
                $where = " AND YEAR(fecha)= $p1 AND month(fecha) = $p2 ";
                $m = $cotizacion->numberToMes($p2);
                $titulo = "$m DEL $p1";
                break;
            case 'rango':
                $date1 = new \DateTime($p1);
                $date2 = new \DateTime($p2);
                $where = " AND fecha between '$p1' AND '$p2' ";
                $titulo = "DESDE " . $date1->format("d/m/Y") . " HASTA " . $date2->format("d/m/Y");
                break;
            default:
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
            'itens' => $cotizacion->productos($where . ' AND cotizacion.estatus > 0'),
            'titulo' => $titulo,
            'operacion' => 'COTIZACION',
        );
        $pdf = new \PDF\Reportes();
        $pdf->version = 'productosDe';
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

    public function torta($rango, $p1, $p2)
    {
        $cotizacion = new \Modelos\Cotizacion();
        $data = array();
        switch ($rango) {
            case 'ano':
                $where = " YEAR(fecha) = $p1 ";
                $titulo = "AÑO $p1";
                break;
            case 'mes':
                $where = " YEAR(fecha)= $p1 AND month(fecha) = $p2 ";
                $m = $cotizacion->numberToMes($p2);
                $titulo = "$m DEl $p1";
                break;
            default:
                $where = "";
                $titulo = "TODO";
                break;
        }
        $data = $cotizacion->torta($where);
        return json_encode($data);
    }

    public function linea($rango, $p1, $p2)
    {
        $cotizacion = new \Modelos\Cotizacion();
        $data = array();
        switch ($rango) {
            case 'ano':
                $data = $cotizacion->cotizacionAno($p1);
                break;
            case 'mes':
                $data = $cotizacion->cotizacionMes($p1, $p2);
                break;
        }
        return json_encode($data);
    }

}
