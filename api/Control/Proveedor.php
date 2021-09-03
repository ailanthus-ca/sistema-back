<?php

namespace Control;

class Proveedor {

    function lista() {
        $Proveedor = new \Modelos\Proveedor();
        return json_encode($Proveedor->lista());
    }

    function detalles($id) {
        $Proveedor = new \Modelos\Proveedor();
        return json_encode($Proveedor->detalles($id));
    }

    function nuevo() {
        $Proveedor = new \Modelos\Proveedor();
        $Proveedor->codigo = $Proveedor->postString("codigo");
        $Proveedor->telefono = $Proveedor->postString("telefono");
        $Proveedor->email = $Proveedor->postString("correo");
        $Proveedor->nombre = $Proveedor->postString("nombre");
        $Proveedor->contacto = $Proveedor->postString("contacto");
        $Proveedor->direccion = $Proveedor->postString("direccion");

        // Validar que exista el codigo
        if ($Proveedor->codigo == '') {
            $Proveedor->setError(array('codigo' => 'No se mando RIF/cédula'));
        }
        if($Proveedor->checkCodigo($Proveedor->codigo)){
            $Proveedor->setError(array('codigo' => 'ya existe este RIF/cédula'));            
        }
        // Validar que exista el nombre
        if ($Proveedor->nombre == '') {
            $Proveedor->setError(array('nombre' => 'No se mando el nombre'));
        }
        // Validar que exista el correo
        if ($Proveedor->telefono == '') {
            $Proveedor->setError(array('telefono' => 'No se mando un telefono'));
        }
        // Validar que exista el contacto
        if ($Proveedor->contacto == '') {
            $Proveedor->setError(array('contacto' => 'No se mando un contacto'));
        }
        //Validar si hubo errores
        if ($Proveedor->response > 300) {
            return json_encode($Proveedor->getResponse());
        }
        // Validar que exista proveedor
        if ($Proveedor->checkCodigo($Proveedor->codigo)) {
            return $Proveedor->getResponse($Proveedor->detalles($Proveedor->codigo));
        }

        return json_encode($Proveedor->nuevo());
    }

    function actualizar($id) {
        $Proveedor = new \Modelos\Proveedor();
        $Proveedor->codigo = $Proveedor->postString("codigo");
        $Proveedor->telefono = $Proveedor->postString("telefono");
        $Proveedor->email = $Proveedor->postString("correo");
        $Proveedor->nombre = $Proveedor->postString("nombre");
        $Proveedor->contacto = $Proveedor->postString("contacto");
        $Proveedor->direccion = $Proveedor->postString("direccion");

        // Validar que exista el codigo
        if ($Proveedor->codigo == '') {
            $Proveedor->setError(array('codigo' => 'No se mando RIF/cédula'));
        }
        // Validar que exista el nombre
        if ($Proveedor->nombre == '') {
            $Proveedor->setError(array('nombre' => 'No se mando el nombre'));
        }
        // Validar que exista el correo
        if ($Proveedor->email == '') {
            $Proveedor->setError(array('email' => 'No se mando un email'));
        }
        // Validar que exista el contacto
        if ($Proveedor->contacto == '') {
            $Proveedor->setError(array('contacto' => 'No se mando un contacto'));
        }
        //Validar si hubo errores
        if ($Proveedor->response > 300) {
            return json_encode($Proveedor->getResponse());
        }

        return json_encode($Proveedor->actualizar($id));
    }

    function cancelar($id) {
        $Proveedor = new \Modelos\Proveedor();
        return json_encode($Proveedor->cancelar($id));
    }

}
