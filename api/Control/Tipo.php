<?php

namespace Control;

class Tipo {

    function lista() {
        $tipos = new \Modelos\Tipo();
        return json_encode($tipos->lista());
    }

    function detalles($id) {
        $tipo = new \Modelos\Tipo();
        return json_encode($tipo->detalles($id));
    }

    function nuevo() {
        $tipo = new \Modelos\Tipo();
        $tipo->descripcion = $tipo->postString("descripcion");
        $tipo->inventario = $tipo->postIntenger("inventario");
        return json_encode($tipo->nuevo());
    }

    function actualizar($id) {
        $tipo = new \Modelos\Tipo();
        $tipo->descripcion = $tipo->postString("descripcion");
        $tipo->inventario = $tipo->postIntenger("inventario");
        return json_encode($tipo->actualizar($id));
    }

    function cancelar($id) {
        $tipo = new \Modelos\Tipo();
        return json_encode($tipo->cancelar($id));
    }

}
