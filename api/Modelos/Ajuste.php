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

    var $estado = 'Ajuste';
    var $tipo_ajuste = '';
    var $fecha = '';
    var $nota = '';
    var $usuario = 0;

    public function lista()
    {
        $data = array();
        $query = $this->query("SELECT ajusteinv.codigo as codFact, tipo_ajuste, fecha, ajusteinv.estatus, usuario, usuario.nombre as nombre, nota FROM `ajusteinv`, `usuario` WHERE ajusteinv.usuario = usuario.codigo");
        while ($row = $query->fetch_array()) {
            $detalle = array();
            $sql = $this->query("SELECT cod_producto FROM detalleajusteinv WHERE cod_ajuste = " . $row['codFact']);
            while ($row2 = $sql->fetch_array()) {
                $detalle[] = $row2['cod_producto'];
            }
            $data[] = array(
                'codigo' => (int) $row['codFact'],
                'usuario' => (int) $row['usuario'],
                'nombre' => $row['nombre'],
                'tipo' => $row['tipo_ajuste'],
                'fecha' => $row['fecha'],              
                'nota' => $row['nota'],
                'status' => (int) $row['estatus'],             
                'detalles' => $detalle
            );
        }
        return $this->getResponse($data);
    }

    public function detalles($id)
    {
        $sql = "SELECT ajusteinv.codigo as codFact, usuario, usuario.nombre as nombre, tipo_ajuste, fecha, nota, ajusteinv.estatus FROM ajusteinv, usuario WHERE ajusteinv.usuario=usuario.codigo AND ajusteinv.codigo = $id";
        $query = $this->query($sql);
        $data = array();
        if ($row = $query->fetch_array()) {
            $detalle = array();
            $sql = $this->query("SELECT cod_producto FROM detalleajusteinv WHERE cod_ajuste = " . $row['codFact']);
            while ($row2 = $sql->fetch_array()) {
                $detalle[] = $row2['cod_producto'];
            }
            $data[] = array(
                'codigo' => (int) $row['codFact'],
                'usuario' => (int) $row['usuario'],
                'nombre' => $row['nombre'],
                'tipo' => $row['tipo_ajuste'],
                'fecha' => $row['fecha'],
                'nota' => $row['nota'],
                'status' => (int) $row['estatus'],
                'detalles' => $detalle
            );
            return $this->getResponse($data);

        } else {
            $this->getNotFount();
            return $this->getResponse(array());
        }
    }

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

    public function nuevo()
    {
        $id_usuario = $_SESSION['id_usuario'];
        $this->query("INSERT INTO ajusteinv (codigo, tipo_ajuste, fecha, nota, usuario) VALUES (null, UPPER('$this->tipo_ajuste'), NOW(), UPPER('$this->nota'), $id_usuario)");
        $id_ajus = $this->con->insert_id;
        $this->actualizarEstado();
        return $this->getResponse($this->detalles($id_ajus));
    }

}
