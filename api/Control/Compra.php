<?php

namespace Control;

class Compra {

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
        $compras->cod_documento = $compras->postString('cod_documento');
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
        $compras->id_orden = $compras->postIntenger('id_orden');
        $compras->cod_proveedor = $compras->postString('cod_proveedor');
        $compras->nota = $compras->postString("nota");
        $compras->impuesto = $compras->postFloat("impuesto");
        $compras->subtotal = $compras->postFloat("subtotal");
        $compras->total = $compras->postFloat("total");
        $compras->detalles = $compras->postArray("detalles");
        $compras->cod_documento = $compras->postString('cod_documento');
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
        return json_encode($compras->nuevo());
    }

    function PDF($id) {
        $compras = new \Modelos\Compra();
        $data = $compras->detalles($id);
        $pdf = new \PDF\Compra();
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

}
