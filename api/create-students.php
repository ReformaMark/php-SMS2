<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../src/dbh.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Only POST method is allowed');
    }

    $data = json_decode(file_get_contents('php://input'), true);

    // Validate required fields
    $requiredFields = ['username', 'password', 'first_name', 'last_name', 'email'];
    foreach ($requiredFields as $field) {
        if (empty($data[$field])) {
            throw new Exception("$field is required");
        }
    }

    // Hash the password
    $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);

    // Prepare the SQL statement
    $sql = "INSERT INTO users (
        username, 
        password_hash,
        first_name, 
        last_name, 
        email,
        role,
        phone_number,
        date_of_birth,
        gender,
        address,
        course,
        created_at
    ) VALUES (
        :username,
        :password_hash,
        :first_name,
        :last_name,
        :email,
        'Student',
        :phone_number,
        :date_of_birth,
        :gender,
        :address,
        :course,
        NOW()
    )";

    $stmt = $pdo->prepare($sql);
    
    // Bind parameters
    $params = [
        ':username' => $data['username'],
        ':password_hash' => $passwordHash,
        ':first_name' => $data['first_name'],
        ':last_name' => $data['last_name'],
        ':email' => $data['email'],
        ':phone_number' => $data['phone_number'] ?? null,
        ':date_of_birth' => $data['date_of_birth'] ?? null,
        ':gender' => $data['gender'] ?? null,
        ':address' => $data['address'] ?? null,
        ':course' => $data['course'] ?? null
    ];

    $stmt->execute($params);
    
    echo json_encode([
        'success' => true,
        'message' => 'Student created successfully',
        'user_id' => $pdo->lastInsertId()
    ]);

} catch (Exception $e) {
    error_log("Error creating student: " . $e->getMessage());
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}