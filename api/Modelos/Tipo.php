<?php

namespace Modelos;

class Tipo extends \conexion{

    var $estado = 'Tipo';
    var $descripcion = '';
    var $inventario = 0;

	public function lista(){
		$tipos = array();
		$sql = $this->con->query('SELECT * FROM tipo_producto');
		while($row = $sql->fetch_array()){
			$tipos[] = array(
				'codigo' => $row['codigo'] ,
                'descripcion' => $row['descripcion'],
				'inventario' => $row['inventario'],
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
				'inventario' => $row['inventario'],
				'estatus' => $row['estatus'],
			);
			return $this->getResponse($data);
		} else {
			$this->getNotFount();
			return $this->getResponse(array());
		}
	}

	function checkCodigo($cod) {
        $sql = $this->query('SELECT count(*) AS exist FROM tipo_producto WHERE codigo="' . $cod . '"');
        if ($row = $sql->fetch_array()) {
            return boolval($row['exist']);
        }
    }

    function nuevo() {
        $this->query("INSERT INTO `tipo_producto` (codigo, descripcion, estatus, inventario) VALUES (null, UPPER('$this->descripcion'), 1, '$this->inventario')");          
        $id_tipo = $this->con->insert_id;
        $this->actualizarEstado();
        return $this->getResponse($this->detalles($id_tipo));
    }

    function actualizar($id) {
        $this->query("UPDATE tipo_producto SET "
            ."descripcion = UPPER('$this->descripcion'),"
            ."inventario = UPPER('$this->inventario') "
            ."WHERE codigo = $id ");
        $this->actualizarEstado();
        return $this->getResponse($this->detalles($id));
    }

    public function cancelar($id) {
        $sql = $this->query("SELECT * from tipo_producto WHERE codigo = $id ");
        if ($row = $sql->fetch_array()) {
            if ($row['estatus'] === '1') {
                $this->query("UPDATE tipo_producto SET "
                        . "estatus = 0 "
                        . "WHERE codigo = $id ");
            } else {
                $this->query("UPDATE tipo_producto SET "
                        . "estatus = 1 "
                        . "WHERE codigo = $id ");
            }
            $this->actualizarEstado();
            return $this->getResponse(true);
        }
    }

}