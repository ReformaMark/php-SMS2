<?php

declare(strict_types=1);

function getUsername(object $pdo, string $username) {
    try {
        $query = "SELECT * FROM users WHERE username = :username;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        error_log("Database error in getUsername: " . $e->getMessage());
        return null;
    }
}

function getEmail(object $pdo, string $email) {
    try {
        $query = "SELECT * FROM users WHERE email = :email;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        error_log("Database error in getEmail: " . $e->getMessage());
        return null;
    }
}

function setUser(object $pdo, string $firstname, string $lastname, string $email, string $username, string $password_hash, string $role) {
    try {
        $query = "INSERT INTO users (first_name, last_name, email, username, password_hash, role) VALUES (:firstname, :lastname, :email, :username, :password_hash, :role);";
        
        $stmt = $pdo->prepare($query);

        $options = [
            'cost' => 12
        ];
     
        $hashed_password = password_hash($password_hash, PASSWORD_BCRYPT, $options);
        
        $stmt->bindParam(":firstname", $firstname);
        $stmt->bindParam(":lastname", $lastname);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password_hash", $hashed_password);
        $stmt->bindParam(":role", $role);
        
        $stmt->execute();
    } catch (PDOException $e) {
        error_log("Database error in setUser: " . $e->getMessage());
        throw $e;
    }
}
