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
        
        //validaciones para cod_cliente 
        if ($Cotizacion->cod_cliente == '') {
            $Cotizacion->setError('Debe mandar un cliente');
            return  $Cotizacion->getResponse();
        }
        // Validar cliente
        $Cliente=new \Modelos\Cliente();
        $Cliente->detalles($Cotizacion->cod_cliente);
        if($Cliente->response==404){
            $Cotizacion->setError('El cliente mandado no existe');
            return  $Cotizacion->getResponse();            
        }
        // Validar total
        if ($Cotizacion->total == 0) {
            $Cotizacion->setError('No se mando el total');
            return  $Cotizacion->getResponse();
        }
        // Validar si existe al menos un item(producto)
        if (count($Cotizacion->detalles)==0) {
            $Cotizacion->setError('No se mandaron productos');
            return  $Cotizacion->getResponse();
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
        $pdf = new \PDF\Cotizacion();
        ob_start();
        $pdf->dolar($data);
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

}
