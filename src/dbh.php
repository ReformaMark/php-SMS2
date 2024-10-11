<?php

$host = "localhost";
$dbName = "mis_ledger";
$dbUsername = "mis_ledger";
$dbPassword= "v6IA^3kJ3w0N#bC0";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    die("Connection failed: " . $e->getMessage());
}