<?php

namespace Control;

class Ajuste {

	public function lista()
	{
		$ajuste = new \Modelos\Ajuste;
		return json_encode($ajuste->lista());
	}

	public function detalles($id)
	{
		$ajuste = new \Modelos\Ajuste;
		return json_encode($ajuste->detalles($id));
	}

	public function nuevo()
	{
		$ajuste = new \Modelos\Ajuste;
		$ajuste->tipo_ajuste = $ajuste->postString("tipo_ajuste");
		$ajuste->nota = $ajuste->postString("nota");
		
		// Validar si existe tipo de ajuste
		if ($ajuste->tipo_ajuste == '') {
			$ajuste->setError('Se debe agregar un tipo de ajuste');
		}		
		// Validar si existe nota
		 if ($ajuste->nota == '') {
			$ajuste->setError('Se debe agregar una nota para la descripción del ajuste');
		}
		//Validar si hubo errores
        if ($ajuste->response > 300) {
            return json_encode($ajuste->getResponse());
        }

        return json_encode($ajuste->nuevo());
	}

}