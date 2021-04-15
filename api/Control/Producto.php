<?php

namespace Control;

class Producto {

    function lista() {
        $Producto = new \Modelos\Producto();
        return json_encode($Producto->lista());
    }

    function tipo() {
        $Producto = new \Modelos\Producto();
        return json_encode($Producto->tipo());
    }

    function unidad() {
        $Producto = new \Modelos\Producto();
        return json_encode($Producto->unidad());
    }

    function departamentos() {
        $Producto = new \Modelos\Producto();
        return json_encode($Producto->departamentos());
    }

    function detalles($cod) {
        $Producto = new \Modelos\Producto();
        return json_encode($Producto->ver($cod));
    }

    function nuevo() {
        $Producto = new \Modelos\Producto();
        //datos de tipo post
        $Producto->departamento = $Producto->postString('departamento');
        $Producto->descripcion = $Producto->postString('descripcion');
        $Producto->costo = $Producto->postFloat('costo');
        $Producto->precio1 = $Producto->postFloat('precio1');
        $Producto->precio2 = $Producto->postFloat('precio2');
        $Producto->precio3 = $Producto->postFloat('precio3');
        $Producto->tipo = $Producto->postIntenger('tipo');
        $Producto->unidad = $Producto->postIntenger('unidad');
        $Producto->enser = $Producto->postIntenger('enser');
        //validaciones
        
        //cantidad de productos por categoria
        $dep = new \Modelos\Departamento();
        $num = $dep->count($Producto->departamento);
        //comprobar si el codigo es valido
        while ($Producto->checkCodigo($Producto->departamento + $num)) {
            $num++;
        }
        //asignar codigo
        $Producto->codigo = $Producto->departamento + $num;
        //crear y responder
        return json_encode($Producto->nuevo());
    }

    function actualizar($id) {
        $Producto = new \Modelos\Producto();
        //datos de tipo post
        $Producto->descripcion = $Producto->postString('descripcion');       
        $Producto->unidad = $Producto->postIntenger('unidad');
        // Validar que exista codigo
        if (!$Producto->checkCodigo($id)) {
            $Producto->setError('Producto no existe');
        }
        //Validar si hubo errores
        if ($Producto->response > 300) {
            return json_encode($Producto->getResponse());
        }
        //crear y responder
        return json_encode($Producto->actualizar($id));
    }

    function cancelar($id) {
        $Producto = new \Modelos\Producto();
        return json_encode($Producto->cancelar($id));
    }

}
