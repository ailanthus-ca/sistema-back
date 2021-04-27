<?php

namespace Control;

class Moneda {

	function lista() {
        $monedas = new \Modelos\Moneda();
        return json_encode($monedas->lista());
    }

    function detalles($id) {
        $monedas = new \Modelos\Moneda();
        return json_encode($monedas->detalles($id));
    }

    function nuevo(){
    	$moneda = new \Modelos\Moneda();
        $moneda->descripcion = $moneda->postString("descripcion");     
        return json_encode($moneda->nuevo());
    }

    function actualizar($id){
    	$moneda = new \Modelos\Moneda();
        $moneda->descripcion = $moneda->postString("descripcion");     
        return json_encode($moneda->actualizar($id));
    }

    function cancelar($id) {
        $moneda = new \Modelos\Moneda();
        return json_encode($moneda->cancelar($id));
    }

}