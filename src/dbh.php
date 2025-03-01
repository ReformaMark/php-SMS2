<?php

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    // Development environment (localhost)
    $host = "localhost";
    $dbName = "sms-mis";
    $dbUsername = "root";
    $dbPassword = "";              
} else {
    // Production environment
    $host = "localhost";
    $dbName = "mis_ledger";
    $dbUsername = "mis_ledger";
    $dbPassword= "v6IA^3kJ3w0N#bC0";
}
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e){
    die("Connection failed: " . $e->getMessage());
}