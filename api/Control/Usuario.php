<?php

namespace Control;

class Usuario {

    function lista() {
        $Usuario = new \Modelos\Usuario();
        return json_encode($Usuario->lista());
    }

    function actual() {
        return json_encode($_SESSION);
    }

}
