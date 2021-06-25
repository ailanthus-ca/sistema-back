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
        // validaciones
        if ($tipo->descripcion == '') {
            $tipo->setError('SE DEBE INGRESAR UNA DESCRIPCIÓN');
        }
        if ($tipo->inventario == '') {
            $tipo->setError('SE DEBE INGRESAR UN TIPO DE INVENTARIO');
        }
        if ($tipo->response > 300) {
            return json_encode($tipo->getResponse());
        }
        return json_encode($tipo->nuevo());
    }

    function actualizar($id) {
        $tipo = new \Modelos\Tipo();
        $tipo->descripcion = $tipo->postString("descripcion");
        // validaciones
        if ($tipo->descripcion == '') {
            $tipo->setError('SE DEBE INGRESAR UNA DESCRIPCIÓN');
        }
        if ($tipo->response > 300) {
            return json_encode($tipo->getResponse());
        }
        return json_encode($tipo->actualizar($id));
    }

    function cancelar($id) {
        $tipo = new \Modelos\Tipo();
        return json_encode($tipo->cancelar($id));
    }

}
