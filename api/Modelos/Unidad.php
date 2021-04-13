<?php

namespace Modelos;

class Unidad extends \conexion{

	public function lista(){
		$unidades = array();
		$sql = $this->con->query('SELECT * FROM unidad');
		while($row = $sql->fetch_array()){
			$unidades[] = array(
				'codigo' => $row['codigo'] ,
				'descripcion' => $row['descripcion'],
				'estatus' => (int) $row['estatus']
			);
		}
		return $this->getResponse($unidades);
	}

	public function detalles($id){
		$sql = $this->con->query("SELECT * FROM unidad WHERE codigo = '$id' ");
		if($row = $sql->fetch_array()){
			$data = array(
				'codigo' => $row['codigo'],
				'descripcion' => $row['descripcion'],
				'estatus' => $row['estatus'],
			);

			return $this->getResponse($data);

		} else {
			$this->getNotFount();
			return getResponse(array());
		}
	}

}