<?php

declare(strict_types=1);

function isUsernameRegistered(object $pdo, string $username) {
    return getUsername($pdo, $username) ? true : false;
}

function isEmailRegistered(object $pdo, string $email) {
    return getEmail($pdo, $email) ? true : false;
}

function createUser(object $pdo, string $firstname, string $lastname, string $email, string $username, string $password, string $role) {
    setUser($pdo, $firstname, $lastname, $email, $username, $password, $role);
}
