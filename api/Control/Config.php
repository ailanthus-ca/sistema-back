<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Control;

/**
 * Description of Config
 *
 * @author victo
 */
class Config {

    function getRegion() {
        $config = new \Modelos\Configuracion();
        return json_encode($config->getRegion());
    }

    function getFactura() {
        $config = new \Modelos\Configuracion();
        return json_encode($config->getFactura());
    }

    function getVentas() {
        $config = new \Modelos\Configuracion();
        return json_encode($config->getVentas());
    }

    function getEmpresa() {
        $config = new \Modelos\Configuracion();
        return json_encode($config->getEmpresa());
    }

    function get($data) {
        $config = new \Config($data);
        return json_encode($config->get());
    }

    function set($data) {
        $logo = (isset($_POST['logo']) && $_POST['logo'] != null) ? $_POST['logo'] : "";
        if (strlen($logo) > 1000) {
            $_POST['logo'] = $this->base64_to_img($logo);
        }
        $config = new \Config($data);
        $config->setMany($_POST);
        return json_encode($config->cargar());
    }

    function base64_to_img($base64_string) {
        $imageInfo = explode(";base64,", $base64_string);
        $imgExt = str_replace('data:image/', '', $imageInfo[0]);
        $image = str_replace(' ', '+', $imageInfo[1]);
        $imageName = "post-" . time() . "." . $imgExt;
        $ifp = fopen(DR . '/../public/imagenes/' . $imageName, 'wb');
        //$data = explode(',', $base64_string);
        fwrite($ifp, base64_decode($image));
        fclose($ifp);
        return $imageName;
    }

}
