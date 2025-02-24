<?php
declare(strict_types=1);

require_once "../Models/admin_model.php";

function isValidAdminData(object $pdo, array $data, ?int $adminId = null) {
    $errors = [];

    // Username validation
    if (empty($data['username'])) {
        $errors['username'] = "Username is required";
    } elseif (checkUsernameExists($pdo, $data['username'], $adminId)) {
        $errors['username'] = "Username already exists";
    }

    // Email validation
    if (empty($data['email'])) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    } elseif (checkEmailExists($pdo, $data['email'], $adminId)) {
        $errors['email'] = "Email already exists";
    }
    
    // Password validation - only required for new admins
    if (!$adminId && empty($data['password'])) {
        // Password required only for new admins
        $errors['password'] = "Password is required";
    } elseif (!empty($data['password']) && strlen($data['password']) < 8) {
        // If password is provided (even during edit), check length
        $errors['password'] = "Password must be at least 8 characters";
    }
    
    return $errors;
}

function handleAdminCreation(object $pdo, array $data) {
    // Validate the data
    $errors = isValidAdminData($pdo, $data);
    if (!empty($errors)) {
        return ['success' => false, 'errors' => $errors];
    }
    
    // Create the admin
    $adminData = [
        'username' => $data['username'],
        'email' => $data['email'],
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'password' => $data['password']
    ];
    
    $result = createAdmin($pdo, $adminData);
    
    if ($result) {
        return ['success' => true];
    } else {
        return ['success' => false, 'message' => 'Failed to create administrator'];
    }
}

function handleAdminUpdate(object $pdo, int $adminId, array $data) {
    $errors = isValidAdminData($pdo, $data, $adminId);
    if (!empty($errors)) {
        return ['success' => false, 'errors' => $errors];
    }
    
    $adminData = [
        'username' => $data['username'],
        'email' => $data['email'],
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name']
    ];
    
    // Only include password if it's provided
    if (!empty($data['password'])) {
        $adminData['password'] = $data['password'];
    }
    
    $result = updateAdmin($pdo, $adminId, $adminData);
    return ['success' => $result];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once "../dbh.php";
    require_once "../config_session.php";
    
    header('Content-Type: application/json');

    if (ob_get_length()) ob_clean();
    
    if (!isset($_SESSION['user_id']) || !canManageAdmins($pdo, $_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }
    
    $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
    
    try {
        switch ($input['action'] ?? 'create') {
            case 'create':
                $result = handleAdminCreation($pdo, $input);
                break;
                
            case 'update':
                if (!isset($input['admin_id'])) {
                    $result = ['success' => false, 'message' => 'Admin ID is required'];
                    break;
                }
                $result = handleAdminUpdate($pdo, (int)$input['admin_id'], $input);
                break;
                
            case 'toggle_status':
                if (!isset($input['admin_id'])) {
                    $result = ['success' => false, 'message' => 'Admin ID is required'];
                    break;
                }
                $result = ['success' => toggleAdminStatus($pdo, (int)$input['admin_id'])];
                break;
                
            case 'get':
                if (!isset($input['admin_id'])) {
                    $result = ['success' => false, 'message' => 'Admin ID is required'];
                    break;
                }
                $admin = getAdminById($pdo, (int)$input['admin_id']);
                $result = ['success' => (bool)$admin, 'data' => $admin];
                break;
                
            default:
                $result = ['success' => false, 'message' => 'Invalid action'];
        }
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Server error occured',
            'debug' => $e->getMessage()
        ]);
    }
    
    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
}