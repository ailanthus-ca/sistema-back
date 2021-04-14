<?php

class Enrutador {

    public static function run(Request $request) {
        $per = strtoupper($request->getmodulo());
        $obj = '\\Control\\' . $request->getmodulo();
        $operacion = $request->getoperacion();
        $parametro = $request->getparametro();
        $clase = new $obj();
        if ($obj == '\\Control\\Auth') {
            $clase = new $obj();
            echo $clase->$operacion($parametro);
            return;
        }
        $user = new \Auth();
        if ($user->isLog()) {
            if (in_array($per, $user->permisos)) {
                $clase = new $obj();
                echo $clase->$operacion($parametro);
            } else {
                header("HTTP/1.0 403 Success");
                return json_encode(array('error' => 'NO AUTORIZADO'));
            }
        } else {
            echo json_encode($user->unAutenticacted());
        }
    }

}
