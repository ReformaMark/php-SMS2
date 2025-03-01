<?php
declare(strict_types=1);

function createNotification(object $pdo, array $data): bool {
    try {
        $query = "INSERT INTO notifications (user_id, title, message, type) 
                  VALUES (:user_id, :title, :message, :type)";
        $stmt = $pdo->prepare($query);
        return $stmt->execute([
            'user_id' => $data['user_id'],
            'title' => $data['title'],
            'message' => $data['message'],
            'type' => $data['type']
        ]);
    } catch (PDOException $e) {
        error_log("Database error in createNotification: " . $e->getMessage());
        return false;
    }
}

function getUnreadNotifications(object $pdo, int $userId): array {
    try {
        $query = "SELECT * FROM notifications 
                  WHERE user_id = ? AND is_read = 0 
                  ORDER BY created_at DESC";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Database error in getUnreadNotifications: " . $e->getMessage());
        return [];
    }
}

function markNotificationAsRead(object $pdo, int $notificationId): bool {
    try {
        $query = "UPDATE notifications SET is_read = 1 
                  WHERE notification_id = ?";
        $stmt = $pdo->prepare($query);
        return $stmt->execute([$notificationId]);
    } catch (PDOException $e) {
        error_log("Database error in markNotificationAsRead: " . $e->getMessage());
        return false;
    }
}

function getAllNotifications(object $pdo, int $userId): array {
    try {
        $query = "SELECT * FROM notifications 
                  WHERE user_id = ? 
                  ORDER BY created_at DESC";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Database error in getAllNotifications: " . $e->getMessage());
        return [];
    }
}