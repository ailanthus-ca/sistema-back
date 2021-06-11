<?php
// header('Access-Control-Allow-Origin: *');
// header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
// header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
define('DR', __DIR__);
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)) . DS);

require_once DR . '/vendor/autoload.php';
include DR . "/Config/autoload.php";
autoload::run();
$auth = new Auth();
Enrutador::run(new Request());

