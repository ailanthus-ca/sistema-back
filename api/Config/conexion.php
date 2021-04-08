<?php

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

class conexion {

    protected $con;
    //trasa de errores para devolucion
    protected $response = 200;
    private $errores = array();

    public function postString($data) {
        $return = (isset($_REQUEST[$data]) && $_REQUEST[$data] != null) ? $_REQUEST[$data] : "";
        return $this->con->real_escape_string(strip_tags($return, ENT_QUOTES));
    }

    public function postFloat($data) {
        $return = (isset($_REQUEST[$data]) && $_REQUEST[$data] != null) ? $_REQUEST[$data] : 0;
        return floatval($return);
    }

    public function postIntenger($data) {
        $return = (isset($_REQUEST[$data]) && $_REQUEST[$data] != null) ? $_REQUEST[$data] : 0;
        return intval($return);
    }

    public function postArray($data) {
        $detalles = (isset($_REQUEST[$data]) && $_REQUEST[$data] != null) ? $_REQUEST[$data] : '';
        return json_decode($detalles);        
    }

    protected function getNotFount($msn = '') {
        $this->response = 400;
    }

    protected function getErrorServer() {
        return array('msn' => $this->errores);
    }

    public function setError($msn) {
        $this->response = 500;
        $this->errores[] = $msn;
    }

    public function query($sql) {
        if ($row = $this->con->query($sql)) {
            return $row;
        } else {
            $this->setError($sql);
            $this->setError($this->con->error);
        }
    }

    public function __construct() {
        $pass = "";
        $server = "localhost";
        $db = "sistema";
        $this->con = mysqli_connect($server, "root", $pass, $db);
        $this->con->set_charset('utf8');
        date_default_timezone_set('America/Caracas');
    }

    public function __destruct() {
        $this->con->close();
    }

    public function getResponse($response) {
        if ($this->response < 300) {
            header("HTTP/1.0 $this->response Success");
            return $response;
        } else if ($this->response < 500) {
            header("HTTP/1.0 $this->response Not Found");
            return array('errores' => "ELEMENTO NO ENCONTRADO");
        } else {
            header("HTTP/1.0 $this->response Server Error");
            return array('errores' => $this->errores);
        }
    }

}
