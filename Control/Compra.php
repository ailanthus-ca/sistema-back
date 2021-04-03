<?php

namespace Control;

class Compra {

    function lista() {
        $compras = new \Modelos\Compra();
        echo json_encode($compras->lista());
    }

    function detalles($id) {
        $compras = new \Modelos\Compra();
        echo json_encode($compras->detalles($id));
    }

    function cancelar($id) {
        $compras = new \Modelos\Compra();
        echo json_encode($compras->Cancelar($id));
    }

    function facturar($id) {
        $compras = new \Modelos\Compra();
        echo json_encode($compras->facturar($id));
    }

    function nuevo() {
        $compras = new \Modelos\Compra();
        echo json_encode($compras->nuevo());
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
