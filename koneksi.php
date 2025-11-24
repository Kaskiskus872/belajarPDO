<?php
$host = "localhost";
$dbname = "belajarpdo";
$username = 'root';
$password = '';

$dsn = "mysql:host=$host;dbname=$dbname;";
$pdo = new PDO($dsn, $username, $password);

?>