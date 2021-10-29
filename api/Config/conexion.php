<?php

class dataFech
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function fetch_array()
    {
        if ($this->data === 'error') {
            return [];
        }

        return $this->data->fetch_array();
    }
}

class conexion
{
    protected $con;
    //trasa de errores para devolucion
    public $response = 200;
    private $errores = [];
    public $estado = '';

    public function postString($data)
    {
        $return = (isset($_REQUEST[$data]) && $_REQUEST[$data] != null) ? $_REQUEST[$data] : '';

        return $this->con->real_escape_string(strip_tags($return, ENT_QUOTES));
    }

    public function postFloat($data)
    {
        $return = (isset($_REQUEST[$data]) && $_REQUEST[$data] != null) ? $_REQUEST[$data] : 0;

        return floatval($return);
    }

    public function postIntenger($data)
    {
        $return = (isset($_REQUEST[$data]) && $_REQUEST[$data] != null) ? $_REQUEST[$data] : 0;

        return intval($return);
    }

    public function postArray($data)
    {
        $detalles = (isset($_REQUEST[$data]) && $_REQUEST[$data] != null) ? $_REQUEST[$data] : '';

        return json_decode($detalles);
    }

    protected function getNotFount()
    {
        $this->response = 404;
    }

    protected function getErrorServer()
    {
        return ['msn' => $this->errores];
    }

    public function setError($msn)
    {
        $this->response = 500;
        $this->errores[] = $msn;
    }

    public function query($sql)
    {
        if ($row = $this->con->query($sql)) {
            return new dataFech($row);
        } else {
            return new dataFech('error');
            $this->setError(['sql' => [$sql, $this->con->error]]);
        }
    }

    public function insertId()
    {
        return $this->con->insert_id;
    }

    public function __construct()
    {
        $config = new \Config('BD');
        $data = $config->get();
        $this->con = mysqli_connect($data['server'], $data['user'], $data['clave'], $data['DB']);
        $this->con->set_charset('utf8');
        date_default_timezone_set('America/Caracas');
    }

    public function __destruct()
    {
        $this->con->close();
    }

    public function getResponse($response = '')
    {
        if ($this->response < 300) {
            header("HTTP/1.0 $this->response Success");

            return $response;
        } elseif ($this->response < 500) {
            header("HTTP/1.0 $this->response Not Found");

            return ['errores' => 'ELEMENTO NO ENCONTRADO'];
        } else {
            header("HTTP/1.0 $this->response Server Error");

            return ['errores' => $this->errores];
        }
    }

    public function actualizarEstado()
    {
        $s=$this->estado;
        $e = (new \Config('estado'))->get();
        $e[$s] = $e[$s] + 1;
        $e->setMany($e);
        //firebase
        $empresa = (new \Config('empresa'))->get();
        (new \Firebase($empresa['numero_fiscal']))->update($s,$e[$s]);
    }

    public function numberToMes($m)
    {
        switch ($m) {
            case '1':
                return 'ENERO';
            case '2':
                return 'FEBRERO';
            case '3':
                return 'MARZO';
            case '4':
                return 'ABRIL';
            case '5':
                return 'MAYO';
            case '6':
                return 'JUNIO';
            case '7':
                return 'JULIO';
            case '8':
                return 'AGOSTO';
            case '9':
                return 'SEPTIEMBRE';
            case '10':
                return 'OCTUBRE';
            case '11':
                return 'NOVIEMBRE';
            case '12':
                return 'DICIEMBRE';
        }
    }
}
