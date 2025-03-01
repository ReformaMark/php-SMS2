<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

try {
    require_once '../src/dbh.php';
    
    // Add debug logging
    error_log("Database connection established");
    
    // Specify only the columns we want to return, excluding password_hash
    $stmt = $pdo->prepare("
        SELECT 
            user_id,
            username,
            first_name,
            last_name,
            email,
            role,
            phone_number,
            date_of_birth,
            gender,
            address,
            course,
            created_at,
            is_archived
        FROM users 
        WHERE role = 'Student'
    ");
    
    // Add query debug logging
    error_log("Query prepared");
    
    $stmt->execute();
    error_log("Query executed. Row count: " . $stmt->rowCount());
    
    if ($stmt->rowCount() > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode([
            'success' => true,
            'data' => $results
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No records found'
        ]);
    }
} catch (PDOException $e) {
    error_log("Database error details: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Database error occurred: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    error_log("General error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred: ' . $e->getMessage()
    ]);
}