<?php
namespace Control;

class Usuario{

    function lista() {
        $Usuario = new \Modelos\Usuario();
        echo json_encode($Usuario->lista());
    }

    function actual() {
        echo session_cache_expire();
    }

}
