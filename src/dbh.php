<?php

$host = "localhost";
$dbName = "mis_sms";
$dbUsername = "misschoo@localhost";
$dbPassword= "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    die("Connection failed: " . $e->getMessage());
}