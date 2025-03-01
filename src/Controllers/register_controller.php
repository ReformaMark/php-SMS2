<?php

declare(strict_types=1);

function isUsernameRegistered(object $pdo, string $username) {
    return getUsername($pdo, $username) ? true : false;
}

function isEmailRegistered(object $pdo, string $email) {
    return getEmail($pdo, $email) ? true : false;
}

function createUser(object $pdo, string $firstname, string $middlename, string $lastname, string $email, string $username, string $password, string $role, ?string $course = null): void {
    try {
        setUser($pdo, $firstname, $middlename, $lastname, $email, $username, $password, $role, $course);
    } catch (Exception $e) {
        error_log("Error in createUser: " . $e->getMessage());
        throw $e;
    }
}