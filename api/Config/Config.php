<?php

class Config {

    private $name;
    private $array;

    public function __construct($file) {
        $this->name = $file;
        $dir = DR . '/DataCache/' . $file . '.php';
        if (!file_exists($dir)) {
            $this->array = array();
        } else {
            $this->array = $this->cargar();
        }
    }

    public function cargar() {
        return include DR . '/DataCache/' . $this->name . '.php';
    }

    public function get() {
        return $this->array;
    }

    public function getMany() {
        return $this->array;
    }

    public function setMany($array) {
        foreach (array_keys($array) as $key) {
            if (is_numeric($array[$key])) {
                $this->array[$key] = (float) $array[$key];
            } else {
                $this->array[$key] = $array[$key];
            }
        }
        $this->save();
    }

    public function set($key, $value) {
        $this->array[$key] = $value;
    }

    private function save() {
        $conten = "<?php \n return array(\n";
        $conten .= $this->toSave($this->array);
        $conten .= ");";
        $dir = DR . '/DataCache/' . $this->name . '.php';
        if (file_exists($dir))
            unlink($dir);
        $file = fopen($dir, 'w');
        fwrite($file, $conten);
        fclose($file);
    }

    private function toSave($array, $tab = '') {
        $conten = "";
        $tab .= '    ';
        foreach (array_keys($array) as $key) {
            if (is_array($array[$key])) {
                $conten .= $tab . "'$key' => array(\n";
                $conten .= $tab . $this->toSave($array[$key], $tab);
                $conten .= $tab . "),\n";
            } else if (is_numeric($array[$key])) {
                $conten .= $tab . "'$key' => " . $array[$key] . ",\n";
            } else if ($array[$key] === 'true') {
                $conten .= $tab . "'$key' => true,\n";
            } else if ($array[$key] === 'false') {
                $conten .= $tab . "'$key' => false,\n";
            } else {
                $conten .= $tab . "'$key' => '" . $array[$key] . "',\n";
            }
        }
        return $conten;
    }

}
