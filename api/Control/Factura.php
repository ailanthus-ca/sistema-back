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
