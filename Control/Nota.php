<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Control;

/**
 * Description of Nota
 *
 * @author victo
 */
class Nota extends \conexion {

    function lista() {
        $Factura = new \Modelos\Nota();
        echo json_encode($Factura->lista());
    }

    function detalles($id) {
        $Factura = new \Modelos\Nota();
        echo json_encode($Factura->detalles($id));
    }

    function nuevo() {
        $Factura = new \Modelos\Nota();
        echo json_encode($Factura->nuevo());
    }
    function cancelar($id) {
        $Nota = new \Modelos\Nota();
        echo json_encode($Nota->cancelar($id));
    }
    function PDF($id) {
        $Nota = new \Modelos\Nota();
        $data = $Nota->detalles($id);
        $pdf = new \PDF\Nota();
        ob_start();
        $pdf->ver($data);
        $content = ob_get_clean();
        $pdf->ouput('Compra.pdf', $content);
    }

}
