<?php

$dbservername = 'fdb20.awardspace.net';
$dbusername = '3304450_petshop';
$dbpassword = 'bbpetshopdb1';
$dbname = '3304450_petshop';

$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname,'3306');


if(!$conn){
    echo 'Connection Error '.mysqli_connect_error();
}