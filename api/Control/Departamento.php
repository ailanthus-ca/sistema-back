<?php

namespace Control;

class Departamento {

    function lista() {
        $departamentos = new \Modelos\Departamento();
        return json_encode($departamentos->lista());
    }

    function detalles($id) {
        $departamento = new \Modelos\Departamento();
        return json_encode($departamento->detalles($id));
    }

    function nuevo() {
        $departamento = new \Modelos\Departamento();
        $departamento->codigo = $departamento->postString("codigo");
        $departamento->descripcion = $departamento->postString("descripcion");
        return json_encode($departamento->nuevo());
    }

    function actualizar($id) {
        $departamento = new \Modelos\Departamento();
        $departamento->descripcion = $departamento->postString("descripcion");
        return json_encode($departamento->actualizar($id));
    }

    function cancelar($id){
        $departamento = new \Modelos\Departamento();
        return json_encode($departamento->cancelar($id));     
    }

}
