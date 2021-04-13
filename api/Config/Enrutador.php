<?php

class Enrutador {

    public static function run(Request $request) {
        $obj = '\\Control\\' . $request->getmodulo();
        $operacion = $request->getoperacion();
        $parametro = $request->getparametro();
        $clase = new $obj();
        $user = new \Auth();
        if ($user->isLog()) {
            echo $clase->$operacion($parametro);
        } else {
            echo json_encode($user->unAutenticacted());
        }
    }

}
