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
            return  $Factura->getResponse();
        }
        // Validar cliente
        $Cliente=new \Modelos\Cliente();
        $Cliente->detalles($Factura->cod_cliente);
        if($Cliente->response==404){
            $Factura->setError('El cliente mandado no existe');
            return  $Factura->getResponse();            
        }
        // Validar si existe al menos un item(producto)
        if (count($Factura->detalles)==0) {
            $Factura->setError('No se mandaron productos');
            return  $Factura->getResponse();
        }
        // Validar total
        if ($Factura->total == 0) {
            $Factura->setError('No se mando el total');
            return  $Factura->getResponse();
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
        $pdf->ouputFactura('Compra.pdf', $content);
    }

}
