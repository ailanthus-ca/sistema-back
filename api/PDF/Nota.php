<?php

namespace PDF;

class Nota extends \PDFClass {

    var $config = 'nota';

    function ver($data, $precios = true, $aux = '') {
        $config = new \Config('region');
        $region = $config->get();
        $config = new \Config('empresa');
        $company = $config->get();
        $config = new \Config('ventas');
        $ventas = $config->get();
        $this->style();
        $encabezado = '';
        $piepagina = '';
        if ($this->encabezado)
            $encabezado = ' backtop="70px"';
        if ($this->piepagina)
            $piepagina = ' backbottom="50px"';
        ?><page<?php echo $encabezado . $piepagina; ?>><?php
            if ($this->encabezado)
                $this->encabezado();
            if ($this->piepagina)
                $this->footer();
            if (isset($data['fecha']))
                $fecha = new \DateTime($data['fecha']);
            include DR . '/Reportes/' . $this->config . '/' . $this->version . '.php';
            ?></page><?php
    }

}
