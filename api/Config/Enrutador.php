<?php

class Enrutador {

    public static function run(Request $request) {
        $obj = '\\Control\\' . $request->getmodulo();
        $operacion = $request->getoperacion();
        $parametro = $request->getparametro();
        $clase = new $obj();
        echo $clase->$operacion($parametro);
    }

}
