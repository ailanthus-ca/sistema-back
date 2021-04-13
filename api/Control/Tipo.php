<?php

namespace Control;

class Tipo {

	function lista(){
		$tipos = new \Modelos\Tipo();
		return json_encode($tipos->lista());
	}

	function detalles($id){
		$tipo = new \Modelos\Tipo();
		return json_encode($tipo->detalles($id));
	}

}