<?php

namespace Control;

class Factura extends \Prototipo\Controller {

    public function cambios($fecha, $hora) {
        $Factura = new \Modelos\Factura();
        return json_encode($Factura->cambios($fecha, $hora));
    }

    function lista() {
        $Factura = new \Modelos\Factura();
        return json_encode($Factura->lista());
    }

    function vendedores() {
        $users = new \Modelos\Usuario();
        return json_encode($users->getVendedores());
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
        $Factura->id_cotizacion = $Factura->postIntenger('id_cotizacion');
        $Factura->id_nota = $Factura->postIntenger('id_nota');
        $Factura->nota = $Factura->postString("nota");
        $Factura->impuesto = $Factura->postFloat("impuesto");
        $Factura->subtotal = $Factura->postFloat("subtotal");
        $Factura->total = $Factura->postFloat("total");
        $Factura->detalles = $Factura->postArray("detalles");

        $Factura->codigo = $Factura->postString('codigo');

        if ($Factura->id_nota > 0) {
            $nota = new \Modelos\Nota();
            $Factura->user = $nota->facturar($Factura->id_nota);
        } elseif ($Factura->id_cotizacion > 0) {
            $cotizacion = new \Modelos\Cotizacion();
            $Factura->user = $cotizacion->procesar($Factura->id_cotizacion);
        } else {
            $Factura->user = $_SESSION['id_usuario'];
        }

        // Validar que exista el cliente
        if ($Factura->cod_cliente == '') {
            $Factura->setError('DEBE ASIGNAR UN CLIENTE');
        }
        // Validar cliente
        $Cliente = new \Modelos\Cliente();
        $Cliente->detalles($Factura->cod_cliente);
        if ($Cliente->response == 404) {
            $Factura->setError('EL CLIENTE ASIGNADO NO EXISTE');
        }
        // Validar si existe al menos un item(producto)
        if (count($Factura->detalles) == 0) {
            $Factura->setError('NO SE MANDARON PRODUCTOS');
        }
        // Validar total
        if ($Factura->total == 0) {
            $Factura->setError('NO SE MANDO EL TOTAL');
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
        $get = $this->getRango($rango, $p1, $p2);
        $where = $get['w'];
        $titulo = $get['t'];
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
        $nota = new \Modelos\Nota();
        $usuario = new \Modelos\Usuario();
        $userData = $usuario->detalles($user);
        $titulo = $userData['nombre'] . '<br>';
        $get = $this->getRango($rango, $p1, $p2);
        $data = array(
            'facturas' => $Factura->listaWhere(" AND factura.usuario=$user AND factura.estatus > 0 " . $get['w']),
            'notas' => $nota->listaWhere(" AND notasalida.usuario=$user AND notasalida.estatus = 1 " . $get['w']),
            'operacion' => 'VENDEDOR',
            'titulo' => $titulo . $get['t']
        );
        $pdf = new \PDF\Reportes();
        $pdf->version = 'vendedor';
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

    function reporteVendedores($rango, $p1, $p2) {
        $get = $this->getRango($rango, $p1, $p2);
        $usuario = new \Modelos\Usuario();
        $vendedores = $usuario->getVendedores();
        $Factura = new \Modelos\Factura();
        $nota = new \Modelos\Nota();
        $comiciones = [];
        $pdf = new \PDF\Reportes();
        $pdf->version = 'vendedor';
        ob_start();
        foreach ($vendedores as $v) {
            $fac = $Factura->listaWhere(" AND factura.usuario=" . $v['codigo'] . " AND factura.estatus > 0 " . $get['w']);
            $not = $nota->listaWhere(" AND notasalida.usuario=" . $v['codigo'] . " AND notasalida.estatus = 1 " . $get['w']);
            if (count($fac) > 0 || count($not) > 0)
                $pdf->ver(array(
                    'operacion' => 'VENDEDOR',
                    'titulo' => $v['nombre'] . '<br>' . $get['t'],
                    'facturas' => $fac, 'notas' => $not
                ));
        }
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

    function de($cod, $rango, $p1, $p2) {
        $facturas = new \Modelos\Factura();
        $get = $this->getRango($rango, $p1, $p2);
        $where = $get['w'];
        $titulo = $get['t'];
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

    function productos($dpt, $rango, $p1, $p2) {
        $facturas = new \Modelos\Factura();
        $get = $this->getRango($rango, $p1, $p2);
        $where = $get['w'];
        $titulo = $get['t'];
        if ($dpt !== 'TODO') {
            $where .= " and departamento = '$dpt'";
            $dp = new \Modelos\Departamento();
            $row = $dp->detalles($dpt);
            $titulo .= '<br> DEL DEPARTAMENTO ' . $row['descripcion'];
        }
        $data = array(
            'itens' => $facturas->productos($where . ' AND factura.estatus > 0'),
            'titulo' => $titulo,
            'operacion' => 'FACTURAS'
        );
        $pdf = new \PDF\Reportes();
        $pdf->version = 'productosDe';
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

    function torta($rango, $p1, $p2) {
        $factura = new \Modelos\Factura();
        $get = $this->getRango($rango, $p1, $p2);
        $where = $get['w'];
        $titulo = $get['t'];
        $data = $factura->torta($where);
        return json_encode($data);
    }

    function linea($rango, $p1, $p2) {
        $factura = new \Modelos\Factura();
        $data = array();
        switch ($rango) {
            case 'ano':
                $data = $factura->ventaAno($p1);
                break;
            case 'mes':
                $data = $factura->ventaMes($p1, $p2);
                break;
        }
        return json_encode($data);
    }

    function utilidad($ano, $mes) {
        $factura = new \Modelos\Factura();
        $data = $factura->utilidad($ano, $mes);
        return json_encode($data);
    }

    function equilibrio($ano, $mes) {
        $equilibrio = new \Modelos\Equilibrio();
        $equilibrio->pto = $equilibrio->postFloat("pto");
        if ($equilibrio->pto > 0) {
            $data = $equilibrio->set();
            return json_encode($data);
        } else {
            $data = $equilibrio->get($ano, $mes);
            return json_encode($data);
        }
    }

    function prueba($ano) {
        $factura = new \Modelos\Factura();
        return json_encode($factura->prueba($ano));
    }

    function mejor_mes() {
        $nota = new \Modelos\Nota();
        $factura = new \Modelos\Factura();
        $total = $factura->mes_actual() + $nota->mes_actual();
        $factura->guardar_mes();
        return json_encode(array('mejor' => $factura->mejor_mes(), 'actual' => $total));
    }

    function creditos() {
        $c = new \Modelos\CreditoEmitido;
        return json_encode($c->lista());
    }

    function detallesCredito($cod) {
        $c = new \Modelos\CreditoEmitido;
        return json_encode($c->detalles($cod));
    }

    function nuevoCredito() {
        $c = new \Modelos\CreditoEmitido;
        $c->recibir();
        return json_encode($c->nuevo());
    }

    function eliminarCredito($cod) {
        $c = new \Modelos\CreditoEmitido;
        return json_encode($c->cancelar($cod));
    }

    function debitos() {
        $d = new \Modelos\CreditoEmitido;
        return json_encode($d->lista());
    }

    function detallesDebito($dod) {
        $d = new \Modelos\DebitoEmitido;
        return json_encode($d->detalles($dod));
    }

    function nuevoDebito() {
        $d = new \Modelos\DebitoEmitido;
        $d->recibir();
        return json_encode($d->nuevo());
    }

    function eliminarDebito($cod) {
        $d = new \Modelos\DebitoEmitido;
        return json_encode($d->cancelar($cod));
    }

}
