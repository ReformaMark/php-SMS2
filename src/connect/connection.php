<?php

$host = "157.173.111.118";
$dbname = "mis_ledger";
$dbusername = "mis_ledger";
$dbpass = "v6IA^3kJ3w0N#bC0";

try {

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $con = $pdo;

} catch (PDOException $e) {

    echo "Error: " . $e->getMessage();
    exit();
}

?>