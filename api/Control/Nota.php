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
        $Nota->codigo = $Nota->postString('codigo');
        $Nota->cod_cliente = $Nota->postString('cod_cliente');
        $Nota->id_cotizacion = $Nota->postString('id_cotizacion');
        $Nota->nota = $Nota->postString("nota");
        $Nota->total = $Nota->postFloat("total");
        $Nota->detalles = $Nota->postArray("detalles");
        if ($Nota->id_cotizacion > 0) {
            $cotizacion = new Cotizacion();
            $Nota->user = $cotizacion->procesar($Nota->id_cotizacion);
        } else {
            $Nota->user = $_SESSION['id_usuario'];
        }

        // Validar que exista el cliente
        if ($Nota->cod_cliente == '') {
            $Nota->setError('Debe mandar un cliente');
        }
        // Validar cliente
        $Cliente=new \Modelos\Cliente();
        $Cliente->detalles($Nota->cod_cliente);
        if($Cliente->response==404){
            $Nota->setError('El cliente mandado no existe');         
        }
        // Validar si existe al menos un item(producto)
        if (count($Nota->detalles)==0) {
            $Nota->setError('No se mandaron productos');
        }
        // Validar total
        if ($Nota->total == 0) {
            $Nota->setError('No se mando el total');
        }
        //Validar si hubo errores
        if ($Nota->response > 300) {
            return json_encode($Nota->getResponse());
        }
        // Validar que exista Nota
        if ($Nota->checkCodigo($Nota->codigo)) {
            return $Nota->getResponse($Nota->detalles($Nota->codigo));
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
