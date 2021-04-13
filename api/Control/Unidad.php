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

}