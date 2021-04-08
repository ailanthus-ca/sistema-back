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
        return json_encode($Orden->nuevo());
    }

    function cancelar($id) {
        $Orden = new \Modelos\Orden();
        return json_encode($Orden->cancelar($id));
    }

    function seguimiento($id) {
        $Cotizacion = new \Modelos\Orden();
        return json_encode($Cotizacion->seguimiento($id));
    }

    function seguimiento_nuevo($id) {
        $Cotizacion = new \Modelos\Orden();
        $descripcion = $Cotizacion->postString('descripcion');
        return json_encode($Cotizacion->seguimiento_nuevo($id, $descripcion));
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

}
