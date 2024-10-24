<?php
require_once "../../config_session.php";
require_once "../../Models/student_model.php";
require_once "../../dbh.php";

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Student') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    
    // Validate input
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone_number = trim($_POST['phone_number'] ?? '');
    $date_of_birth = trim($_POST['date_of_birth'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $address = trim($_POST['address'] ?? '');

    // Validate first name and last name
    if (!preg_match('/^[A-Za-z\s]+$/', $first_name) || !preg_match('/^[A-Za-z\s]+$/', $last_name)) {
        echo json_encode(['success' => false, 'message' => 'First name and last name should only contain letters and spaces.']);
        exit();
    }

    // Update the phone number validation
    if (!preg_match('/^\d{11}$/', $phone_number)) {
        echo json_encode(['success' => false, 'message' => 'Phone number should contain exactly 11 digits.']);
        exit();
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email format.']);
        exit();
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

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update profile']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
