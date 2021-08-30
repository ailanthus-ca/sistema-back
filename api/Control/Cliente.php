<?php

namespace Control;

class Cliente {

    function lista() {
        $Cliente = new \Modelos\Cliente();
        return json_encode($Cliente->lista());
    }

    function detalles($id) {
        $Cliente = new \Modelos\Cliente();
        return json_encode($Cliente->detalles($id));
    }

    function nuevo() {
        $Cliente = new \Modelos\Cliente();
        $Cliente->codigo = $Cliente->postString("codigo");
        $Cliente->telefono = $Cliente->postString("telefono");
        $Cliente->email = $Cliente->postString("correo");
        $Cliente->nombre = $Cliente->postString("nombre");
        $Cliente->contacto = $Cliente->postString("contacto");
        $Cliente->direccion = $Cliente->postString("direccion");
        $Cliente->tipo_contribuyente = $Cliente->postString("tipo_contribuyente");
        $Cliente->retencion = $Cliente->postFloat('retencion');

        // Validar que exista el codigo
        if ($Cliente->codigo == '') {
            $Cliente->setError('No se mando RIF/cédula');
        }
        // Validar que exista el nombre
        if ($Cliente->nombre == '') {
            $Cliente->setError('No se mando el nombre');
        }
        // Validar que exista el correo
        if ($Cliente->email == '') {
            $Cliente->setError('No se mando un email');
        }
        // Validar que exista el contacto
        if ($Cliente->contacto == '') {
            $Cliente->setError('No se mando un contacto');
        }
        // Validar que exista el contacto
        if ($Cliente->tipo_contribuyente == '') {
            $Cliente->setError('No se mando un tipo de contribuyente');
        }
        // Validar que exista el contacto
        if ($Cliente->tipo_contribuyente == 'ESPECIAL') {
            // Validar que exista una retencion
            if ($Cliente->retencion == 0) {
                $Cliente->setError('No se mando ninguna retención');
            }
        }
        //Validar si hubo errores
        if ($Cliente->response > 300) {
            return json_encode($Cliente->getResponse());
        }
        // Validar que exista cliente
        if ($Cliente->checkCodigo($Cliente->codigo)) {
            return $Cliente->getResponse($Cliente->detalles($Cliente->codigo));
        }

        return json_encode($Cliente->nuevo());
    }

    function actualizar($id) {
        $Cliente = new \Modelos\Cliente();
        $Cliente->telefono = $Cliente->postString("telefono");
        $Cliente->email = $Cliente->postString("correo");
        $Cliente->nombre = $Cliente->postString("nombre");
        $Cliente->contacto = $Cliente->postString("contacto");
        $Cliente->direccion = $Cliente->postString("direccion");
        $Cliente->tipo_contribuyente = $Cliente->postString("tipo_contribuyente");
        $Cliente->retencion = $Cliente->postFloat('retencion');

        // Validar que exista codigo
        if (!$Cliente->checkCodigo($id)) {
            $Cliente->setError('Cliente no existe');
        }
        // Validar que exista el nombre
        if ($Cliente->nombre == '') {
            $Cliente->setError('No se mando el nombre');
        }
        // Validar que exista el correo
        if ($Cliente->email == '') {
            $Cliente->setError('No se mando un email');
        }
        // Validar que exista el contacto
        if ($Cliente->contacto == '') {
            $Cliente->setError('No se mando un contacto');
        }
        // Validar que exista el contacto
        if ($Cliente->tipo_contribuyente == '') {
            $Cliente->setError('No se mando un tipo de contribuyente');
        }
        //Validar si hubo errores
        if ($Cliente->response > 300) {
            return json_encode($Cliente->getResponse());
        }
        return json_encode($Cliente->actualizar($id));
    }

    function cancelar($id) {
        $Cliente = new \Modelos\Cliente();
        return json_encode($Cliente->cancelar($id));
    }

}
