<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modelos;

/**
 * Description of Dolares
 *
 * @author victo
 */
class Dolares extends \conexion {

    var $valor = 0;

    //put your code here
    function grafica() {
        $query = $this->query("SELECT * FROM dolares WHERE  WEEK(NOW(),0)=WEEK(fecha,0)");
        $valor = array();
        while ($row = $query->fetch_array()) {
            $valor[] = array(
                "valor" => $row["valor"],
                "fecha" => $row["fecha"]
            );
        }
        return $this->getResponse($valor);
    }

    function valor() {
        $query = $this->query("select * from dolares order by id desc limit 1");
        $valor = $query->fetch_array();
        return $this->getResponse((float) $valor['valor']);
    }

    function set() {
        $this->query("INSERT INTO `dolares`(`id`, `valor`, `fecha`) VALUES (null,$this->valor,NOW())");
        $this->getResponse(array("st" => 1, "msn" => "Nueva tasa Guardada"));
    }

}
