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
        return json_encode($Cliente->nuevo());
    }

}
