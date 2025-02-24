<?php
declare(strict_types=1);

require_once "../Models/admin_model.php";

function isValidAdminData (array $data) {
    $errors = [];

    if(empty($data['username'])) {
        $errors['username'] = "Username is required";
    }

    if (empty($data['email'])) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }
    
    if (empty($data['password'])) {
        $errors['password'] = "Password is required";
    } elseif (strlen($data['password']) < 8) {
        $errors['password'] = "Password must be at least 8 characters";
    }
    
    return $errors;
}

function handleAdminCreation(object $pdo, array $data) {
    $errors = isValidAdminData($data);
    if (!empty($errors)) {
        return ['success' => false, 'errors' => $errors];
    }
    
    $adminData = [
        'username' => $data['username'],
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'email' => $data['email'],
        'password_hash' => password_hash($data['password'], PASSWORD_DEFAULT)
    ];
    
    $result = createAdmin($pdo, $adminData);
    return ['success' => (bool)$result];
}