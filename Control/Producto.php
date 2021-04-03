<?php

namespace Control;

class Producto {

    function lista() {
        $Producto = new \Modelos\Producto();
        echo json_encode($Producto->lista());
    }

    function tipo() {
        $Producto = new \Modelos\Producto();
        echo json_encode($Producto->tipo());
    }

    function unidad() {
        $Producto = new \Modelos\Producto();
        echo json_encode($Producto->unidad());
    }

    function departamentos() {
        $Producto = new \Modelos\Producto();
        echo json_encode($Producto->departamentos());
    }

    function detalles($cod) {
        $Producto = new \Modelos\Producto();
        echo json_encode($Producto->ver($cod));
    }

    function nuevo() {
        $Producto = new \Modelos\Producto();
        echo json_encode($Producto->nuevo());
    }

}
