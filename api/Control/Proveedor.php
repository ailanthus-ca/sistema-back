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
            $Proveedor->setError('No se mando RIF/cédula');
            return  $Proveedor->getResponse();
        }
        // Validar que exista el nombre
        if ($Proveedor->nombre == '') {
            $Proveedor->setError('No se mando el nombre');
            return  $Proveedor->getResponse();
        }
        // Validar que exista el correo
        if ($Proveedor->email == '') {
            $Proveedor->setError('No se mando un email');
            return  $Proveedor->getResponse();
        }
        // Validar que exista el contacto
        if ($Proveedor->contacto == '') {
            $Proveedor->setError('No se mando un contacto');
            return  $Proveedor->getResponse();
        }
        // Validar que exista una retencion
        if ($Proveedor->retencion == 0) {
            $Proveedor->setError('No se mando ninguna retención');
            return  $Proveedor->getResponse();
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

        // Validar proveedor
        $Proveedor->detalles($id);
        if ($Proveedor->response == 400) {
            return  $Proveedor->getResponse();
        }
        // Validar que exista el codigo
        if ($Proveedor->codigo == '') {
            $Proveedor->setError('No se mando RIF/cédula');
            return  $Proveedor->getResponse();
        }
        // Validar que exista el nombre
        if ($Proveedor->nombre == '') {
            $Proveedor->setError('No se mando el nombre');
            return  $Proveedor->getResponse();
        }
        // Validar que exista el correo
        if ($Proveedor->email == '') {
            $Proveedor->setError('No se mando un email');
            return  $Proveedor->getResponse();
        }
        // Validar que exista el contacto
        if ($Proveedor->contacto == '') {
            $Proveedor->setError('No se mando un contacto');
            return  $Proveedor->getResponse();
        }
        // Validar que exista una retencion
        if ($Proveedor->retencion == 0) {
            $Proveedor->setError('No se mando ninguna retención');
            return  $Proveedor->getResponse();
        }

        return json_encode($Proveedor->actualizar($id));
    }

    function cancelar($id){
        $Proveedor = new \Modelos\Proveedor();
        return json_encode($Proveedor->cancelar($id));
    }

}
