<?php

namespace Modelos;

class Unidad extends \conexion{

    var $estado = 'Unidad';
    var $descripcion = '';

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

    function nuevo() {
        $this->query("INSERT INTO unidad (codigo, descripcion, estatus) VALUES("
            ."null,"
            ."UPPER('$this->descripcion'), "
            . "1)");
        $id_uni = $this->con->insert_id;
        $this->actualizarEstado();
        return $this->getResponse($this->detalles($id_uni));
    }

    function actualizar($id) {
        $this->query("UPDATE unidad SET "
            ."descripcion = UPPER('$this->descripcion') "
            ."WHERE codigo = $id ");
        $this->actualizarEstado();
        return $this->getResponse($this->detalles($id));
    }

    public function cancelar($id) {
        $sql = $this->query("SELECT * from unidad WHERE codigo = $id ");
        if ($row = $sql->fetch_array()) {
            if ($row['estatus'] === '1') {
                $this->query("UPDATE unidad SET "
                        . "estatus = 0 "
                        . "WHERE codigo = $id ");
            } else {
                $this->query("UPDATE unidad SET "
                        . "estatus = 1 "
                        . "WHERE codigo = $id ");
            }
            $this->actualizarEstado();
            return $this->getResponse(true);
        }
    }

}