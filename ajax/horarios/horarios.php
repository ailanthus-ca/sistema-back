<?php

$horarios = (Object) json_decode(file_get_contents("../horarios/horarios.json"));

$array_dias['Sunday'] = "Domingo";
$array_dias['Monday'] = "Lunes";
$array_dias['Tuesday'] = "Martes";
$array_dias['Wednesday'] = "Miercoles";
$array_dias['Thursday'] = "Jueves";
$array_dias['Friday'] = "Viernes";
$array_dias['Saturday'] = "Sabado";
$dia_actual = $array_dias[date('l')];
$dia = $horarios->$dia_actual;

