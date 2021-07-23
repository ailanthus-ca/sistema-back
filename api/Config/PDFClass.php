<?php

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

class PDFClass {

    var $config = 'reporte';
    private $tipo = 'LETTER';
    private $encabezado = true;
    private $piepagina = true;
    var $version = 1;
    private $margenes = array(15, 15, 15, 15);

    public function __construct() {
        $config = new \Config($this->config);
        $data = $config->get();
        $this->tipo = $data['tipo_papel'];
        $this->encabezado = $data['encabezado'];
        $this->piepagina = $data['piepagina'];
        $this->version = $data['version'];
        $this->margenes = array(
            $data['margen_izq'],
            $data['margen_sup'],
            $data['margen_der'],
            $data['margen_inf']
        );
    }

    function ouput($name, $content) {
        try {
            $html2pdf = new HTML2PDF('P', $this->tipo, 'es', true, 'UTF-8', $this->margenes);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            if (file_exists(DR . '/output/' . $name))
                unlink(DR . '/output/' . $name);
            $html2pdf->output(DR . '/output/' . $name);
        } catch (Html2PdfException $e) {
            $html2pdf->clean();
            $formatter = new ExceptionFormatter($e);
            echo $formatter->getHtmlMessage();
        }
    }

    function style() {
        return include DR . '/Reportes/style.php';
    }

    function encabezado() {
        $config = new \Config('empresa');
        $company = $config->get();
        $config = new \Config('region');
        $region = $config->get();
        return include DR . '/Reportes/Encabezado.php';
    }

    function footer() {
        $config = new \Config('empresa');
        $company = $config->get();
        return include DR . '/Reportes/Footer.php';
    }

    function condiciones($iten) {
        return include DR . '/Reportes/Condiciones.php';
    }

    function ver($data) {
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
