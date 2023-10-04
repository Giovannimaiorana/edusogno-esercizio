<?php

$host = "127.0.0.1";
$username = 'root';
$password = 'root';
$db = 'edusogno-db';
$port = '3306';

$connection = new mysqli($host, $username, $password, $db);

if($connection === false) {
    die("Errore durante la connesione: " . $connection->connect_error);
}