<?php

namespace Modelos;

class Tipo extends \conexion{

	public function lista(){
		$tipos = array();
		$sql = $this->con->query('SELECT * FROM tipo_producto');
		while($row = $sql->fetch_array()){
			$tipos[] = array(
				'codigo' => $row['codigo'] ,
				'descripcion' => $row['descripcion'],
				'estatus' => (int) $row['estatus']
			);
		}
		return $this->getResponse($tipos);
	}

	public function detalles($id){
		$sql = $this->con->query("SELECT * FROM tipo_producto WHERE codigo = '$id' ");
		if ($row = $sql->fetch_array()) {
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