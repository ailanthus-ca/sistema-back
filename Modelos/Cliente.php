<?php

namespace Modelos;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cliente
 *
 * @author Ailanthus
 */
class Cliente extends \conexion
{

    public function lista()
    {
        $cl = array();
        $sql = $this->con->query('SELECT * FROM cliente WHERE estatus = 1');
        while ($row = $sql->fetch_array()) {
            $cl[] = array(
                'codigo' => $row['codigo'],
                'nombre' => $row['nombre'],
                'telefono' => $row['telefono'],
                'correo' => $row['correo'],
                'contacto' => $row['contacto'],
                'direccion' => $row['direccion'],
                'estatus' => $row['estatus']);
        }
        return $cl;
    }

    public function detalles($id)
    {
        $sql = $this->con->query("SELECT *from cliente where codigo = '$id' ");
        if ($row = $sql->fetch_array()) {
            $data = array(
                'codigo' => $row['codigo'],
                'nombre' => $row['nombre'],
                'telefono' => $row['telefono'],
                'correo' => $row['correo'],
                'contacto' => $row['contacto'],
                'direccion' => $row['direccion'],
                'estatus' => $row['estatus'],
                'tipo_contribuyente' => $row['tipo_contribuyente'],
                'retencion' => $row['retencion'],
                'estatus' => $row['estatus'],

            );
        }
        return $data;
    }

    public function nuevo()
    {
        $codigo = mysqli_real_escape_string($this->con, (strip_tags($_POST["codigo"], ENT_QUOTES)));
        $nombre = mysqli_real_escape_string($this->con, (strip_tags($_POST["nombre"], ENT_QUOTES)));
        $telefono = mysqli_real_escape_string($this->con, (strip_tags($_POST["telefono"], ENT_QUOTES)));
        $email = mysqli_real_escape_string($this->con, (strip_tags($_POST["email"], ENT_QUOTES)));
        $tipo_contribuyente = mysqli_real_escape_string($this->con, (strip_tags($_POST["tipo_contribuyente"], ENT_QUOTES)));
        $contacto = mysqli_real_escape_string($this->con, (strip_tags($_POST["contacto"], ENT_QUOTES)));
        $direccion = mysqli_real_escape_string($this->con, (strip_tags($_POST["direccion"], ENT_QUOTES)));
        $estado = intval($_POST['estado']);
        $retencion = intval($_POST['retencion']);
        

        $sql = $this->con->query("SELECT *from cliente WHERE codigo = '$codigo'") or die(json_encode(array('error' => 1, 'msn' => $this->con->error)));
        if ($row = $sql->fetch_array()) {
            return array('error' => 1, 'msn' => "Ya existe un Cliente con el mismo RIF/CI.");
        } else {
            $sql = "INSERT INTO cliente (codigo,nombre,correo,direccion,contacto,telefono,tipo_contribuyente, retencion, estatus) VALUES (UPPER('$codigo'),UPPER('$nombre'), UPPER('$email'),UPPER('$direccion'),UPPER('$contacto'),'$telefono',
					UPPER('$tipo_contribuyente'),$retencion,$estado)";
            $query = $this->con->query($sql) or die(json_encode(array('error' => 1, 'msn' => $this->con->error)));
            if ($query) {
                return array('error' => 0, 'msn' => 'Cliente registrado satisfactoriamente.');
            }
        }
    }

}
