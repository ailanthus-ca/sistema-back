<?php
namespace Control;

class Cotizacion {

    function lista() {
        $Cotizacion = new \Modelos\Cotizacion();
        echo json_encode($Cotizacion->lista());
    }
    
    function detalles($id) {
        $Cotizacion = new \Modelos\Cotizacion();
        echo json_encode($Cotizacion->detalles($id));
    }
    
    function nuevo() {
        $Cotizacion = new \Modelos\Cotizacion();
        echo json_encode($Cotizacion->nuevo());
    }
    
    function cancelar($id) {
        $Cotizacion = new \Modelos\Cotizacion();
        echo json_encode($Cotizacion->cancelar($id));
    }
    function plantillas() {
        $Cotizacion = new \Modelos\Cotizacion();
        echo json_encode($Cotizacion->plantillas());
    }
    
    function plantilla($id) {
        $Cotizacion = new \Modelos\Cotizacion();
        echo json_encode($Cotizacion->plantilla($id));
    }
    
    function guardar() {
        $Cotizacion = new \Modelos\Cotizacion();
        echo json_encode($Cotizacion->guardar());
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

}
