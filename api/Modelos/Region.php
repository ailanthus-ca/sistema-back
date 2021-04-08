<?php

namespace Modelos;

class Region extends \conexion {

    function get() {
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
        return $region;
    }

}
