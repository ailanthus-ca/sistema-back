<?php
$pass = "";
$server = "localhost";
$db = "sistema";  
$con = mysqli_connect($server, "root", $pass,$db);
$con->set_charset('utf8');
return $con;
?>