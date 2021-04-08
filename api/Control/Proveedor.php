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
        return json_encode($Proveedor->nuevo());
    }

}
