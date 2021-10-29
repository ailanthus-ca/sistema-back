<?php

namespace Control;

class Unidad {

	function lista(){
		$unidades = new \Modelos\Unidad();
		return json_encode($unidades->lista());
	}

	function detalles($id){
		$unidad = new \Modelos\Unidad();
		return json_encode($unidad->detalles($id));
	}

	function nuevo() {
		$unidad = new \Modelos\Unidad();		
        $unidad->descripcion = $unidad->postString("descripcion");
        return json_encode($unidad->nuevo());
    }

    function actualizar($id) {
		$unidad = new \Modelos\Unidad();		
        $unidad->descripcion = $unidad->postString("descripcion");
        return json_encode($unidad->actualizar($id));
    }

    function cancelar($id){
		$unidad = new \Modelos\Unidad();
		return json_encode($unidad->cancelar($id));
	}

}