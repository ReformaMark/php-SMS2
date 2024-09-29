<?php

declare(strict_types=1);

function getUsername (object $pdo, string $username) {
    try {
        $query = "SELECT * FROM users WHERE username = :username;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        // Handle the exception, log or return appropriate response
        return null;
    }
}

function setUser (object $pdo, string $username, string $password_hash) {

    $query = "INSERT INTO users (username, password_hash) VALUES (:username, :password_hash);";
    
    $stmt = $pdo->prepare($query);

    $options = [
        'cost' => 12
    ];

    $hashed_password = password_hash($password_hash, PASSWORD_BCRYPT, $options);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":password_hash", $hashed_password);
    $stmt->execute();

   
}