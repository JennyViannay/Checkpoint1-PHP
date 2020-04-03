<?php


$dsn = "mysql:host=localhost;dbname=checkpoint1";
$user = "root";
$pwd = "Jimbeck2403*";
$pdo = new PDO($dsn, $user, $pwd);

if ($pdo===false){
    echo "Connection error";
} else 'Success';