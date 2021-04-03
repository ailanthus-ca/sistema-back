<?php

namespace Control;

class Orden {

    function lista() {
        $Orden = new \Modelos\Orden();
        echo json_encode($Orden->lista());
    }

    function detalles($id) {
        $Orden = new \Modelos\Orden();
        echo json_encode($Orden->detalles($id));
    }

    function nuevo() {
        $Orden = new \Modelos\Orden();
        echo json_encode($Orden->nuevo());
    }

    function cancelar($id) {
        $Orden = new \Modelos\Orden();
        echo json_encode($Orden->cancelar($id));
    }

    function seguimiento($id) {
        $Cotizacion = new \Modelos\Cotizacion();
        echo json_encode($Cotizacion->seguimiento($id));
    }

    function seguimiento_nuevo($id) {
        $Cotizacion = new \Modelos\Cotizacion();
        echo json_encode($Cotizacion->seguimiento_nuevo($id));
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
