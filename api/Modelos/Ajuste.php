<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modelos;

/**
 * Description of Ajuste
 *
 * @author victo
 */
class Ajuste extends \conexion {

    //put your code here

    function listaWithProducto($codigo, $where) {
        $pen = array();
        $sql = $this->query("select "
                . "fecha, "
                . "ajusteinv.codigo as codigo, "
                . "tipo_ajuste, "
                . "usuario.nombre as nombre, "
                . "cantidad "
                . "from ajusteinv, detalleajusteinv, usuario WHERE "
                . "usuario.codigo=usuario AND "
                . "ajusteinv.codigo=cod_ajuste AND "
                . "cod_producto = '$codigo' "
                . "$where");
        while ($row = $sql->fetch_array()) {
            $pen[] = array(
                'operacion' => 'AJUSTE',
                'tipo' => $row['tipo_ajuste'],
                'orden' => strtotime($row['fecha']),
                'fecha' => $row['fecha'],
                'codigo' => $row['codigo'],
                'nombre' => $row['nombre'],
                'cantidad' => $row['cantidad']
            );
        }
        return $this->getResponse($pen);
    }

}
