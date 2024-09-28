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