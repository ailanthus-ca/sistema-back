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
        
    }

}
