<?php

namespace Control;

class Factura extends \conexion {

    function lista() {
        $Factura = new \Modelos\Factura();
        echo json_encode($Factura->lista());
    }

    function detalles($id) {
        $Factura = new \Modelos\Factura();
        echo json_encode($Factura->detalles($id));
    }
    function nuevo() {
        $Factura = new \Modelos\Factura();
        echo json_encode($Factura->nuevo());
    }

    function cancelar($id) {
        $Factura = new \Modelos\Factura();
        echo json_encode($Factura->cancelar($id));
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
