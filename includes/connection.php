<?php
session_start();
$connection = new mysqli('localhost:3306','root','','login_sample'); // change this also

if($connection->connect_error){
    die ("Database Connection Failed" . $connection->connect_error);
} else {
    // echo "Connection OK";
}

$currentdir =  dirname(__DIR__);

define('BASE_URL', 'http://localhost/lawyerMGT/'); // change location
define('LOCAL_PATH', 'file://'.$currentdir.'\\');

require('classes.php');
?>
