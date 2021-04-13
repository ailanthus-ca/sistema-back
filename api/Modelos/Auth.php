<?php

namespace Modelos;

class Auth extends \conexion{

	public function listar_roles(){
		$roles = array();
		$sql = $this->con->query("SELECT * FROM roles");
		while($row = $sql->fetch_array()){
			$roles[] = array(
				'id' => $row['id'],
				'nombre' => $row['nombre']
			);
		}

		return $this->getResponse($roles);
	}

	public function detalles_rol($id){
		$sql = $this->query("SELECT *from roles where id = '$id' ");
        if ($row = $sql->fetch_array()) {
        	$data[] = array(
				'id' => $row['id'],
				'nombre' => $row['nombre']
			);
            return $this->getResponse($data);		
        } else {
            $this->getNotFount();
            return $this->getResponse(array());
        }
	}

	public function listar_permisos(){
		$permisos = array();
		$sql = $this->con->query("SELECT * FROM permisos");
		while($row = $sql->fetch_array()){
			$permisos[] = array(
				'id' => $row['id'],
				'nombre' => $row['nombre']
			);
		}

		return $this->getResponse($permisos);
	}

	public function nuevo_rol(){
		$sql = $this->con->query("SELECT * from roles WHERE id = '$this->id'");
        if ($row = $sql->fetch_array()) {
            return $this->getResponse($this->detalles($this->id));
        } else {
        	$this->query("INSERT INTO roles(nombre) VALUES("
        		."nombre = UPPER('$this->nombre')".
        		") ");
            return $this->getResponse($this->detalles_rol($this->id));
        }
	}

}