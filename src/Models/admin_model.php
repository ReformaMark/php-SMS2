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

function createAdmin(object $pdo, array $adminData): bool {
    try {
        $query = "INSERT INTO users (username, first_name, last_name, email, password_hash, role) 
                  VALUES (:username, :first_name, :last_name, :email, :password_hash, 'Admin')";
        
        // Hash the password
        $password_hash = password_hash($adminData['password'], PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare($query);
        return $stmt->execute([
            'username' => $adminData['username'],
            'first_name' => $adminData['first_name'],
            'last_name' => $adminData['last_name'],
            'email' => $adminData['email'],
            'password_hash' => $password_hash
        ]);
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

function updateAdmin(object $pdo, int $adminId, array $adminData): bool {
    try {
        $fields = [
            'username' => $adminData['username'],
            'first_name' => $adminData['first_name'],
            'last_name' => $adminData['last_name'],
            'email' => $adminData['email'],
            'admin_id' => $adminId
        ];

        $query = "UPDATE users 
                  SET username = :username,
                      first_name = :first_name,
                      last_name = :last_name,
                      email = :email";

        // Only update password if provided
        if (!empty($adminData['password'])) {
            $query .= ", password_hash = :password_hash";
            $fields['password_hash'] = password_hash($adminData['password'], PASSWORD_DEFAULT);
        }

        $query .= " WHERE user_id = :admin_id AND role = 'Admin'";
        
        $stmt = $pdo->prepare($query);
        return $stmt->execute($fields);
    } catch (PDOException $e) {
        error_log("Database error in updateAdmin: " . $e->getMessage());
        return false;
    }
}

function toggleAdminStatus(object $pdo, int $adminId): bool {
    try {
        $query = "UPDATE users 
                  SET is_archived = NOT is_archived 
                  WHERE user_id = ? AND role = 'Admin'";
        $stmt = $pdo->prepare($query);
        return $stmt->execute([$adminId]);
    } catch (PDOException $e) {
        error_log("Database error in toggleAdminStatus: " . $e->getMessage());
        return false;
    }
}

function getAdminById(object $pdo, int $adminId): ?array {
    try {
        $query = "SELECT user_id, username, first_name, last_name, email, is_archived 
                  FROM users 
                  WHERE user_id = ? AND role = 'Admin'";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$adminId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    } catch (PDOException $e) {
        error_log("Database error in getAdminById: " . $e->getMessage());
        return null;
    }
}

function checkUsernameExists(object $pdo, string $username, ?int $excludeId = null): bool {
    try {
        $query = "SELECT COUNT(*) FROM users WHERE username = ?";
        $params = [$username];
        
        if ($excludeId) {
            $query .= " AND user_id != ?";
            $params[] = $excludeId;
        }
        
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        return (bool)$stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log("Database error in checkUsernameExists: " . $e->getMessage());
        return false;
    }
}

function checkEmailExists(object $pdo, string $email, ?int $excludeId = null): bool {
    try {
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        $params = ['email' => $email];
        
        if ($excludeId !== null) {
            $sql .= " AND user_id != :excludeId";
            $params['excludeId'] = $excludeId;
        }
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        
        return (int)$stmt->fetchColumn() > 0;
    } catch (PDOException $e) {
        error_log("Database error in checkEmailExists: " . $e->getMessage());
        return false;
    }
}