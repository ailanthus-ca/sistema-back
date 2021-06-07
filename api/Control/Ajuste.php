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

}