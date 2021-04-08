<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Modelos;

/**
 * Description of Configuracion
 *
 * @author victo
 */
class Configuracion extends \conexion {

    function getRegion() {
        $region = array();
        $sql = $this->con->query("SELECT *from conf_region");
        if ($row = $sql->fetch_array()) {
            $region['cod_fiscal'] = $row['codigo_fiscal'];
            $region['moneda'] = $row['moneda'];
            $region['impuesto'] = $row['impuesto'];
            $region['impuesto1'] = $row['impuesto1'];
            $region['monto1'] = $row['monto1'];
            $region['impuesto2'] = $row['impuesto2'];
            $region['monto2'] = $row['monto2'];
        }
        return $this->getResponse($region);
    }

    function getFactura() {
        $factura = array();
        $sql = $this->query("SELECT *from conf_factura");
        if ($row = $sql->fetch_array()) {
            $factura['margen_sup'] = $row['margen_sup'];
            $factura['margen_inf'] = $row['margen_inf'];
            $factura['margen_izq'] = $row['margen_izq'];
            $factura['margen_der'] = $row['margen_der'];
            $factura['tipo_papel'] = $row['tipo_papel'];
            $factura['observacion'] = $row['observacion'];
            $factura['num_factura'] = $row['num_factura'];
        }
        return $this->getResponse($factura);
    }

    function getVentas() {
        $envio = array();
        $sql = $this->query("SELECT *from conf_venta");
        if ($row = $sql->fetch_array()) {
            $envio['garantia'] = $row['garantia'];
            $envio['observacion'] = $row['observacion'];
        }
        return $this->getResponse($envio);
    }

    function getEmpresa() {
        $empresa = array();
        $sql = $this->query("SELECT *from conf_empresa");
        if ($row = $sql->fetch_array()) {
            $empresa['nombre'] = $row['nombre'];
            $empresa['numero_fiscal'] = $row['numero_fiscal'];
            $empresa['direccion'] = $row['direccion'];
            $empresa['telefono'] = $row['telefono'];
            $empresa['correo'] = $row['correo'];
            $empresa['web'] = $row['web'];
            $empresa['pago'] = $row['pago'];
            $empresa['logo'] = $row['logo'];
            $empresa['eslogan'] = $row['eslogan'];
        }
        return $this->getResponse($region);
    }

}
