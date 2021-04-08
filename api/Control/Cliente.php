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
        return json_encode($Cliente->nuevo());
    }

}
