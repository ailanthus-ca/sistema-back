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
        $Proveedor->direccion = $postString("direccion");
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
        return json_encode($Proveedor->actualizar($id));
    }

}
