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
        $compras->cod_compra = $compras->postIntenger('cod_compra');
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

        // Validar que exista el cod_proveedor
        if ($compras->cod_proveedor == '') {
            $compras->setError('Debe mandar un proveedor');
        }
        // Validar proveedor
        $proveedor = new \Modelos\Proveedor();
        $proveedor->detalles($compras->cod_proveedor);
        if ($proveedor->response == 404) {
            $compras->setError('El proveedor mandado no existe');
        }
        // Validar si existe al menos un item(producto)
        if (count($compras->detalles)==0) {
            $compras->setError('No se mandaron productos');
        }
        // Validar total
        if ($compras->total == 0) {
            $compras->setError('No se mando el total');
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
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

}
