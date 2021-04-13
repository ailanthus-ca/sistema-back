<?php

namespace Modelos;

class Departamento extends \conexion{

	public function lista(){
		$departamentos = array();
		$sql = $this->con->query('SELECT * FROM departamento');
		while($row = $sql->fetch_array()){
			$departamentos[] = array(
				'codigo' => $row['codigo'] ,
				'descripcion' => $row['descripcion'],
				'estatus' => (int) $row['estatus']
			);
		}
		return $this->getResponse($departamentos);
	}

	public function detalles($id){
		$sql = $this->con->query("SELECT * FROM departamento WHERE codigo = '$id' ");
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