<?php
require_once "../config_session.php";
require_once "../dbh.php";
require_once "../Models/student_model.php";

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['student_id']) && isset($_POST['action'])) {
    $student_id = $_POST['student_id'];
    $action = $_POST['action'];
    
    try {
        if ($action === 'archive') {
            $result = archiveStudent($pdo, $student_id);
        } elseif ($action === 'recover') {
            $result = recoverStudent($pdo, $student_id);
        } else {
            throw new Exception('Invalid action');
        }
        
        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => "Failed to $action student."]);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
