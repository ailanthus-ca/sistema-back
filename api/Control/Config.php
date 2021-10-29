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
        $confi=strtolower($data);
        $config = new \Config($confi);
        return json_encode($config->get());
    }

    function set($data) {
        $confi=strtolower($data);
        $logo = (isset($_POST['logo']) && $_POST['logo'] != null) ? $_POST['logo'] : "";
        if (strlen($logo) > 1000) {
            $_POST['logo'] = $this->base64_to_img($logo);
        }
        $config = new \Config($confi);
        $config->setMany($_POST);
        return json_encode($config->cargar());
    }

    function contadores(){
        $Cliente = new \Modelos\Cliente();
        $clientes = $Cliente->totalClientes();
        $proveedor = new \Modelos\Proveedor;
        $proveedores = $proveedor->totalProveedores();
        $compra = new \Modelos\Compra;
        $compras = $compra->totalCompras();
        $orden = new \Modelos\Orden;
        $ordenes = $orden->totalOrdenes();
        $nota = new \Modelos\Nota;
        $notas = $nota->totalNotas();
        $cotizacion = new \Modelos\Cotizacion();
        $cotizaciones = $cotizacion->totalCotizaciones();
        $factura = new \Modelos\Factura();
        $facturas = $factura->totalFacturas();
        $producto = new \Modelos\Producto;
        $productos = $producto->totalProductos();

        $contadores = array(
            'clientes' => $clientes,
            'proveedores' => $proveedores,
            'compras' => $compras,
            'ordenes' => $ordenes,
            'notas' => $notas,
            'cotizaciones' => $cotizaciones,
            'facturas' => $facturas,
            'inventario' => $productos
        );
        return json_encode($contadores);
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
