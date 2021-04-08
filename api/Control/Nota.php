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
        $Nota = new \Modelos\Nota();
        return json_encode($Nota->lista());
    }

    function detalles($id) {
        $Nota = new \Modelos\Nota();
        return json_encode($Nota->detalles($id));
    }

    function nuevo() {
        $Nota = new \Modelos\Nota();
        $Nota->cod_cliente = $Nota->postString('cod_cliente');
        $Nota->id_cotizacion = $Nota->postString('id_cotizacion');
        $this->nota = $this->postString("nota");
        $this->total = $this->postFloat("total");
        if ($Nota->id_cotizacion > 0) {
            $cotizacion = new Cotizacion();
            $Nota->user = $cotizacion->procesar($Nota->id_cotizacion);
        } else {
            $Nota->user = $_SESSION['id_usuario'];
        }
        return json_encode($Nota->nuevo());
    }

    function cancelar($id) {
        $Nota = new \Modelos\Nota();
        return json_encode($Nota->cancelar($id));
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
