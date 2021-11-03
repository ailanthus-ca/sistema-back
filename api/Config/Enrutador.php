<?php

class Enrutador {

    public static function run(Request $request) {
        $per = strtoupper($request->getmodulo());
        $obj = '\\Control\\' . $request->getmodulo();
        $operacion = $request->getoperacion();
        $parametro = $request->getparametro();
        $parametro2 = $request->getparametro2();
        $parametro3 = $request->getparametro3();
        $parametro4 = $request->getparametro4();
        $parametro5 = $request->getparametro5();
        $parametro6 = $request->getparametro6();
        if ($obj == '\\Control\\Auth') {
            $clase = new $obj();
            if (method_exists($clase, $operacion)) {
                echo $clase->$operacion($parametro);
                return;
            } else {
                header("HTTP/1.0 404 METODO NO ENCONTRADO");
                echo json_encode(array('error' => 'METODO NO ENCONTRADO'));
                return;
            }
        }
        $user = new \Auth();
        if (!$user->isLog()) {
            echo json_encode($user->unAutenticacted());
            return;
        }
        if (!class_exists($obj)) {
            header("HTTP/1.0 404 MODULO NO ENCONTRADO");
            echo json_encode(array('error' => 'MODULO NO ENCONTRADO'));
            return;
        }
        $clase = new $obj();
        if (!method_exists($clase, $operacion)) {
            header("HTTP/1.0 404 METODO NO ENCONTRADO");
            echo json_encode(array('error' => 'METODO NO ENCONTRADO'));
            return;
        }
        $validarPermiso = true;
        $publicos = new \Publicos;
        if (in_array($per, $publicos->Modulos)) {
            if (in_array($operacion, $publicos->$per)) {
                $validarPermiso = false;
            }
        }
        $protegidos = new \Protegidos;
        if ($protegidos->Permitir($user->permisos, $per, $operacion)) {
            $validarPermiso = false;
        }
        if ($validarPermiso) {
            if (!in_array($per, $user->permisos)) {
                header("HTTP/1.0 403 'NO AUTORIZADO");
                echo json_encode(array('error' => 'NO AUTORIZADO'));
                return;
            }
        }
        echo $clase->$operacion($parametro, $parametro2, $parametro3, $parametro4, $parametro5, $parametro6);
        unset($clase);
        $e = (new \Config('estado'))->get();
        $fire = new \Firebase((new \Config('empresa'))->get()['numero_fiscal']);
        foreach (array_keys($e) as $s) {
            $fire->update($s, $e[$s]);
        }
        unset($fire);
    }

}
