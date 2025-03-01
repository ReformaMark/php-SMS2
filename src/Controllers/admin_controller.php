<?php
declare(strict_types=1);

require_once "../Models/admin_model.php";
require_once "../Models/notification_model.php";

function createAdminNotification(object $pdo, string $actionType, array $adminData): void {
    try {
        $title = '';
        $message = '';
        $type = 'success';
        
        switch ($actionType) {
            case 'create':
                $title = 'New Administrator Added';
                $message = "Successfully added {$adminData['first_name']} {$adminData['last_name']} as administrator";
                break;
            case 'update':
                $title = 'Administrator Updated';
                $message = "Successfully updated administrator {$adminData['first_name']} {$adminData['last_name']}";
                break;
            case 'archive':
                $title = 'Administrator Archived';
                $message = "Administrator {$adminData['first_name']} {$adminData['last_name']} has been archived";
                break;
            case 'unarchive':
                $title = 'Administrator Activated';
                $message = "Administrator {$adminData['first_name']} {$adminData['last_name']} has been activated";
                break;
        }
        
        createNotification($pdo, [
            'user_id' => $_SESSION['user_id'],
            'title' => $title,
            'message' => $message,
            'type' => $type
        ]);
    } catch (Exception $e) {
        error_log("Error creating notification: " . $e->getMessage());
    }
}

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
    $errors = isValidAdminData($pdo, $data);
    if (!empty($errors)) {
        return ['success' => false, 'errors' => $errors];
    }
    
    $result = createAdmin($pdo, $data);
    
    if ($result) {
        createAdminNotification($pdo, 'create', $data);
        return ['success' => true];
    }
    
    return ['success' => false, 'message' => 'Failed to create administrator'];
}

function handleAdminUpdate(object $pdo, int $adminId, array $data) {
    $errors = isValidAdminData($pdo, $data, $adminId);
    if (!empty($errors)) {
        return ['success' => false, 'errors' => $errors];
    }
    
    $result = updateAdmin($pdo, $adminId, $data);
    
    if ($result) {
        createAdminNotification($pdo, 'update', $data);
        return ['success' => true];
    }
    
    return ['success' => false, 'message' => 'Failed to update administrator'];
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
                    $admin = getAdminById($pdo, (int)$input['admin_id']);
                    if ($admin) {
                        $success = toggleAdminStatus($pdo, (int)$input['admin_id']);
                        if ($success) {
                            createAdminNotification($pdo, $admin['is_archived'] ? 'unarchive' : 'archive', $admin);
                        }
                        $result = ['success' => $success];
                    } else {
                        $result = ['success' => false, 'message' => 'Admin not found'];
                    }
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