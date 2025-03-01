<?php
declare(strict_types=1);

require_once "../config_session.php";
require_once "../dbh.php";
require_once "../Models/notification_model.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }

    header('Content-Type: application/json');

    switch ($input['action']) {
        case 'mark_read':
            if (!isset($input['notification_id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Notification ID required']);
                exit;
            }
            $success = markNotificationAsRead($pdo, (int)$input['notification_id']);
            echo json_encode(['success' => $success]);
            break;

        case 'mark_all_read':
            $success = markAllNotificationsAsRead($pdo, $_SESSION['user_id']);
            echo json_encode(['success' => $success]);
            break;

        default:
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
            break;
    }
    exit;
}