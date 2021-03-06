<?php

namespace Modelos;

class Equilibrio extends \conexion {
	var $pto = 0;
	// Graficas
	public function set(){
		$mes = date("n");
		$ano = date("Y");
			//Nuevo punto de equilibrio
		$this->query("INSERT into equilibrio values(null,$ano, $mes, $this->pto)");
			//calculando el mes anterior
		$mes--;
		if ($mes === 0) {
			$ano--;
			$mes=12;
		} 
			//buscando mes anterior
		$query = $this->query("SELECT * FROM mejor_mes WHERE mes=$mes AND año=$ano");
		if ($row = $query->fetch_array()) {
				//existe
		} else {
				//Calculando ventas del mes 
			$query = $this->query("SELECT SUM(subtotal) AS ventas FROM factura WHERE estatus = 2 AND MONTH(fecha)=$mes AND YEAR(fecha)=$ano");
			if ($row = $query->fetch_array()) {
				//Agregando mes anterior 
				$this->query("INSERT INTO `mejor_mes`(`id`, `ventas`, `mes`, `año`) VALUES (null," . $row['ventas'] . ",$mes,$ano)");
			}
		}
	}

	public function get($ano, $mes){
		$sql_equi = $this->query("SELECT * from equilibrio WHERE ano = $ano AND mes = $mes");
		if ($row = $sql_equi->fetch_array()) {
			$equi = (float) $row['monto'];
		} else
		$equi = 0;
		$sql_ventas = $this->query("SELECT SUM(subtotal) AS ventas FROM factura WHERE estatus = 2 AND MONTH(fecha)=$mes AND YEAR(fecha)='$ano'");
		if ($row2 = $sql_ventas->fetch_array()) {
			$ventas = (float) $row2['ventas'];
		}
		$data = array(0 =>(float)  $equi, 1 =>(float)  $ventas);
		return $this->getResponse($data);
	}

}