<?php

class Enrutador {

    public static function run(Request $request) {
        $per = strtoupper($request->getmodulo());
        $obj = '\\Control\\' . $request->getmodulo();
        $operacion = $request->getoperacion();
        $parametro = $request->getparametro();
        if ($obj == '\\Control\\Auth') {
            $clase = new $obj();
            if (method_exists($clase, $operacion)) {
                echo $clase->$operacion($parametro);
                return;
            } else {
                header("HTTP/1.0 404 Success");
                return json_encode(array('error' => 'HETODO NO ENCONTRADO'));
            }
        }
        $user = new \Auth();
        if ($user->isLog()) {
            if (class_exists($obj)) {
                if (in_array($per, $user->permisos)) {
                    $clase = new $obj();
                    if (method_exists($clase, $operacion)) {
                        echo $clase->$operacion($parametro);
                    } else {
                        header("HTTP/1.0 404 Success");
                        return json_encode(array('error' => 'HETODO NO ENCONTRADO'));
                    }
                } else {
                    header("HTTP/1.0 403 Success");
                    return json_encode(array('error' => 'NO AUTORIZADO'));
                }
            } else {
                header("HTTP/1.0 404 Success");
                return json_encode(array('error' => 'MODULO NO ENCONTRADO'));
            }
        } else {
            echo json_encode($user->unAutenticacted());
        }
    }

}
