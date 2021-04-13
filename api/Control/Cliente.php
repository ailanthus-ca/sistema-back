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
            return  $Cliente->getResponse();
        }
        // Validar que exista el nombre
        if ($Cliente->nombre == '') {
            $Cliente->setError('No se mando el nombre');
            return  $Cliente->getResponse();
        }
        // Validar que exista el correo
        if ($Cliente->email == '') {
            $Cliente->setError('No se mando un email');
            return  $Cliente->getResponse();
        }
        // Validar que exista el contacto
        if ($Cliente->contacto == '') {
            $Cliente->setError('No se mando un contacto');
            return  $Cliente->getResponse();
        }
        // Validar que exista el contacto
        if ($Cliente->tipo_contribuyente == '') {
            $Cliente->setError('No se mando un tipo de contribuyente');
            return  $Cliente->getResponse();
        }
        // Validar que exista una retencion
        if ($Cliente->retencion == 0) {
            $Cliente->setError('No se mando ninguna retención');
            return  $Cliente->getResponse();
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

        // Validar cliente
        $Cliente->detalles($id);
        if ($Cliente->response == 404) {
            return  $Cliente->getResponse();
        }
        // Validar que exista el codigo
        if ($Cliente->codigo == '') {
            $Cliente->setError('No se mando RIF/cédula');
            return  $Cliente->getResponse();
        }
        // Validar que exista el nombre
        if ($Cliente->nombre == '') {
            $Cliente->setError('No se mando el nombre');
            return  $Cliente->getResponse();
        }
        // Validar que exista el correo
        if ($Cliente->email == '') {
            $Cliente->setError('No se mando un email');
            return  $Cliente->getResponse();
        }
        // Validar que exista el contacto
        if ($Cliente->contacto == '') {
            $Cliente->setError('No se mando un contacto');
            return  $Cliente->getResponse();
        }
        // Validar que exista el contacto
        if ($Cliente->tipo_contribuyente == '') {
            $Cliente->setError('No se mando un tipo de contribuyente');
            return  $Cliente->getResponse();
        }
        // Validar que exista una retencion
        if ($Cliente->retencion == 0) {
            $Cliente->setError('No se mando ninguna retención');
            return  $Cliente->getResponse();
        }

        return json_encode($Cliente->actualizar($id));
    }

    function cancelar($id){
        $Cliente = new \Modelos\Cliente();
        return json_encode($Cliente->cancelar($id));
    }

}
