<?php

namespace Prototipo;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Controller extends \conexion {

    function getRango($rango, $p1, $p2) {
        $get = [];
        switch ($rango) {
            case 'ano':
                $get['w'] = " AND YEAR(fecha) = $p1 ";
                $get['t'] = "AÑO $p1";
                break;
            case 'mes':
                $get['w'] = " AND YEAR(fecha)= $p1 AND month(fecha) = $p2 ";
                $m = $this->numberToMes($p2);
                $get['t'] = "$m DEl $p1";
                break;
            case 'rango':
                $date1 = new \DateTime($p1);
                $date2 = new \DateTime($p2);
                $get['w'] = " AND fecha between '$p1' AND '$p2' ";
                $get['t'] = "DESDE " . $date1->format("d/m/Y") . " HASTA " . $date2->format("d/m/Y");
                break;
            default :
                $get['w'] = "";
                $get['t'] = "TODO";
                break;
        }
        return $get;
    }

}
