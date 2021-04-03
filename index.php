<?php

header('Access-Control-Allow-Origin: *');
define('DR', __DIR__);
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)) . DS);
session_start();
require_once DR.'/vendor/autoload.php';
include DR."/Config/autoload.php";
autoload::run();
Enrutador::run(new Request());


