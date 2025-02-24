<?php
declare(strict_types=1);

function isSuperAdmin(object $pdo, int $userId): bool {
    try {
        $query = "SELECT role FROM users WHERE user_id = ? AND role = 'SuperAdmin'";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        error_log("Database error in isSuperAdmin: " . $e->getMessage());
        return false;
    }
}

function canManageAdmins(object $pdo, int $userId): bool {
    return isSuperAdmin($pdo, $userId);
}

function getAllAdmins(object $pdo) {
    try {
        $query = "SELECT * FROM users WHERE role = 'Admin' ORDER BY created_at DESC";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Database error in getAllAdmins: " . $e->getMessage());
        return null;
    }
}

function createAdmin(object $pdo, array $adminData) {
    try {
        $query = "INSERT INTO users (username, first_name, last_name, email, password_hash, role, status) 
                  VALUES (:username, :first_name, :last_name, :email, :password_hash, 'Admin', 'Active')";
        $stmt = $pdo->prepare($query);
        $stmt->execute($adminData);
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        error_log("Database error in createAdmin: " . $e->getMessage());
        return false;
    }
}

function getDashboardStats(object $pdo): array {
    try {
        // Get total users count
        $userCountQuery = "SELECT 
            COUNT(*) as total_users,
            SUM(CASE WHEN role = 'Admin' THEN 1 ELSE 0 END) as admin_count,
            SUM(CASE WHEN role = 'Student' THEN 1 ELSE 0 END) as student_count,
            SUM(CASE WHEN role = 'Faculty' THEN 1 ELSE 0 END) as faculty_count,
            SUM(CASE WHEN is_archived = 1 THEN 1 ELSE 0 END) as archived_users
            FROM users";
        
        $stmt = $pdo->prepare($userCountQuery);
        $stmt->execute();
        $stats = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Get recent activities
        $recentActivitiesQuery = "SELECT 
            username,
            first_name,
            last_name,
            role, 
            created_at,
            is_archived 
            FROM users 
            ORDER BY created_at DESC 
            LIMIT 5";
            
            $stmt = $pdo->prepare($recentActivitiesQuery);
            $stmt->execute();
            $recentActivities = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
            return [
                'stats' => $stats,
                'recent_activities' => $recentActivities
            ];
        } catch (PDOException $e) {
            error_log("Error in getDashboardStats: " . $e->getMessage());
            return [];
        }
}