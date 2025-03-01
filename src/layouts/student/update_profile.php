<?php
    require_once "../../config_session.php";
    require_once "../../dbh.php";
    require_once "../../Models/student_model.php";
    
    // Prevent any output before headers
    header('Content-Type: application/json; charset=utf-8');
    ob_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_id = $_SESSION['user_id'];
        $first_name = $_POST['first_name'] ?? '';
        $last_name = $_POST['last_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone_number = $_POST['phone_number'] ?? '';
        $date_of_birth = $_POST['date_of_birth'] ?? '';
        $gender = $_POST['gender'] ?? '';
        $address = $_POST['address'] ?? '';

        // Validate first name and last name
        if (!preg_match('/^[A-Za-z\s]+$/', $first_name) || !preg_match('/^[A-Za-z\s]+$/', $last_name)) {
            ob_clean();
            echo json_encode(['success' => false, 'message' => 'First name and last name should only contain letters and spaces.']);
            exit;
        }

        // Update the phone number validation
        if (!preg_match('/^\d{11}$/', $phone_number)) {
            ob_clean();
            echo json_encode(['success' => false, 'message' => 'Phone number should contain exactly 11 digits.']);
            exit;
        }

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            ob_clean();
            echo json_encode(['success' => false, 'message' => 'Invalid email format.']);
            exit;
        }

        $data = [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'phone_number' => $phone_number,
            'date_of_birth' => $date_of_birth,
            'gender' => $gender,
            'address' => $address,
        ];

        $result = updateStudentProfile($pdo, $user_id, $data);

        ob_clean();
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update profile']);
        }
        exit;
    }

    ob_clean();
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;