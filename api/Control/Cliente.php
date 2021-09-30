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
            $Cliente->setError(array('codigo' => 'No se mando RIF/cédula'));
        }
        if ($Cliente->checkCodigo($Cliente->codigo)) {
            $Cliente->setError(array('codigo' => 'ya existe este RIF/cédula'));
        }
        // Validar que exista el nombre
        if ($Cliente->nombre == '') {
            $Cliente->setError(array('nombre' => 'No se mando el nombre'));
        }
        // Validar que exista el correo
        if ($Cliente->telefono == '') {
            $Cliente->setError(array('telefono' => 'No se mando un telefono'));
        }
        // Validar que exista el contacto
        if ($Cliente->contacto == '') {
            $Cliente->setError(array('contacto' => 'No se mando un contacto'));
        }
        // Validar que exista el contacto
        if ($Cliente->tipo_contribuyente == '') {
            $Cliente->setError(array('tipo_contribuyente' => 'No se mando un tipo de contribuyente'));
        }
        // Validar que exista el contacto
        if ($Cliente->tipo_contribuyente == 'ESPECIAL') {
            // Validar que exista una retencion
            if ($Cliente->retencion == 0) {
                $Cliente->setError(array('retencion' => 'No se mando ninguna retención'));
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

        // Validar que exista el codigo
        if ($Cliente->codigo == '') {
            $Cliente->setError(array('codigo' => 'No se mando RIF/cédula'));
        }
        // Validar que exista el nombre
        if ($Cliente->nombre == '') {
            $Cliente->setError(array('nombre' => 'No se mando el nombre'));
        }
        // Validar que exista el correo
        if ($Cliente->email == '') {
            $Cliente->setError(array('email' => 'No se mando un email'));
        }
        // Validar que exista el contacto
        if ($Cliente->contacto == '') {
            $Cliente->setError(array('contacto' => 'No se mando un contacto'));
        }
        // Validar que exista el contacto
        if ($Cliente->tipo_contribuyente == '') {
            $Cliente->setError(array('tipo_contribuyente' => 'No se mando un tipo de contribuyente'));
        }
        // Validar que exista el contacto
        if ($Cliente->tipo_contribuyente == 'ESPECIAL') {
            // Validar que exista una retencion
            if ($Cliente->retencion == 0) {
                $Cliente->setError(array('retencion' => 'No se mando ninguna retención'));
            }
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
