<?php

/* 
 * Database connections
 */
function acmeConnect(){
    $server = "localhost";
    $database = "acme";
    $user = "IClient";
    $password = "HSNoiCs9IrVYJQEv";
    $dsn = "mysql:host=$server;dbname=$database";
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

try {
    $acmeLink = new PDO($dsn, $user, $password, $options);
    //echo 'Connection worked';
    return $acmeLink;
} catch (PDOException $ex) {
    //echo $ex->getMessage();
    header('location: ../view/500.php');
}
}

//acmeConnect();