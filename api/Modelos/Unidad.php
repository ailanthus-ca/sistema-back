<?php

namespace Modelos;

class Unidad extends \conexion{

    var $estado = 'Unidad';
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

	function checkCodigo($cod) {
        $sql = $this->query('SELECT count(*) AS exist FROM unidad WHERE codigo="' . $cod . '"');
        if ($row = $sql->fetch_array()) {
            return boolval($row['exist']);
        }
    }

}