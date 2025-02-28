<?php
require_once "../config_session.php";
require_once "../dbh.php";
require_once "../Models/student_model.php";
require_once "../Models/notification_model.php";

// Prevent any output before headers
ob_start(); // Add this line to buffer any unexpected output

// Set proper JSON header BEFORE any output
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Verify admin/superadmin access
        if (!isset($_SESSION['user_id']) || !in_array($_SESSION['user_role'], ['Admin', 'SuperAdmin'])) {
            throw new Exception('Unauthorized access');
        }

        $student_id = $_POST['student_id'] ?? '';
        $action = $_POST['action'] ?? '';

        if (empty($student_id) || empty($action)) {
            throw new Exception('Missing required parameters');
        }

        // Get student data before performing action
        $studentData = getStudentById($pdo, (int)$student_id);
        if (!$studentData) {
            throw new Exception('Student not found');
        }

        $success = false;
        if ($action === 'archive') {
            $success = archiveStudent($pdo, (int)$student_id);
        } else if ($action === 'recover') {
            $success = recoverStudent($pdo, (int)$student_id);
        }

        if ($success) {
            // Create notification after successful action
            $title = $action === 'archive' ? 'Student Archived' : 'Student Activated';
            $message = sprintf(
                "Student %s %s has been %s",
                $studentData['first_name'],
                $studentData['last_name'],
                $action === 'archive' ? 'archived' : 'activated'
            );
            
            createNotification($pdo, [
                'user_id' => $_SESSION['user_id'],
                'title' => $title,
                'message' => $message,
                'type' => 'success'
            ]);

            ob_clean(); // Clear any output before sending JSON
            echo json_encode(['success' => true]);
        } else {
            throw new Exception("Failed to {$action} student");
        }

    } catch (Exception $e) {
        ob_clean(); // Clear any output before sending JSON
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
    exit;
}

ob_end_flush();