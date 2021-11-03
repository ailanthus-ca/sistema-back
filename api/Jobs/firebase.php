<?php

$data = include __DIR__ . '\..\DataCache\estado.php';
$emp = include __DIR__ . '\..\DataCache\empresa.php';
require_once __DIR__ . '\..\vendor\autoload.php';
require_once __DIR__ . '\..\Config\Firebase.php';
$rif = $emp['numero_fiscal'];

function echoArray($array, $tab = '') {
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

$firabase = new Firebase('');
$fire = $fire = $firabase->get($rif);

foreach (array_keys($data) as $key) {
    if (!$fire || empty($fire[$key]) || !isset($fire[$key]) || ($data[$key] !== $fire[$key])) {
        $fire = $firabase->update("$rif/$key", (int) $data[$key]);
    }
}
