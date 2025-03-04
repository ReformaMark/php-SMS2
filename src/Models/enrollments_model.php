<?php

declare(strict_types=1);

function getAllStudents(PDO $pdo, ?string $filter, int $offset, int $total_records_per_page): ?array {
    try {
        if ($filter === "" || $filter === null) {
            $query = "SELECT * FROM students ORDER BY student_id DESC LIMIT :offset, :total_records_per_page;";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':total_records_per_page', $total_records_per_page, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            $query = "SELECT * FROM students WHERE CONCAT(student_id, first_name, last_name, email) LIKE :filter ORDER BY student_id DESC;";
            $stmt = $pdo->prepare($query);
            $filter = "%$filter%";
            $stmt->bindParam(':filter', $filter, PDO::PARAM_STR);
            $stmt->execute();
        }

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        // Handle the exception, log or return appropriate response
        return null;
    }
}

function getTotalCount(PDO $pdo): ?int {
    try {
        $query = "SELECT COUNT(*) as total_records FROM students;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        // Fetch the result as a single row
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Return the count as an integer
        return $result ? (int)$result['total_records'] : null;
    } catch (PDOException $e) {
        // Handle the exception, log or return appropriate response
        return null;
    }
}

function setStudent(object $pdo, string $firstName, string $lastName,string $birthDate, string $gender, string $email, string $phoneNumber, string $enrollmentDate, string $status) {
    try {

        $date = date('Y-m-d', strtotime($birthDate));
        if($date === false) {
            throw new Exception("Invalid date format. Please use the format YYYY-MM-DD.");
        }

        $query = "INSERT INTO students (first_name, last_name, date_of_birth, gender, email, phone_number, enrollment_date, status) 
                  VALUES (:firstName, :lastName,:birthDate ,:gender ,:email, :phoneNumber, :enrollmentDate, :status)";
        
        $stmt = $pdo->prepare($query);
        
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':birthDate', $birthDate);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phoneNumber', $phoneNumber);
        $stmt->bindParam(':enrollmentDate', $enrollmentDate);
        $stmt->bindParam(':status', $status);
        
        $stmt->execute();
        
        return $pdo->lastInsertId(); // Return the ID of the newly inserted student
    } catch (PDOException $e) {
        // Handle exception (e.g., log the error, rethrow, or return a specific error message)
        throw new Exception("Error inserting student: " . $e->getMessage());
    }
}

function getCountStudents(PDO $pdo) {
    try {
        $query = "SELECT COUNT(*) as total_users FROM users WHERE role = 'Student'";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_users'];
    } catch (PDOException $e) {
        error_log("Error fetching total users: " . $e->getMessage());

        return "N/A";
    }
}

function getStudentStatusDistribution(PDO $pdo): array {
    try {
        $query = "SELECT 
            SUM(CASE WHEN is_archived = 0 THEN 1 ELSE 0 END) as active_count,
            SUM(CASE WHEN is_archived = 1 THEN 1 ELSE 0 END) as inactive_count
            FROM users 
            WHERE role = 'Student'";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error getting student status distribution: " . $e->getMessage());
        return [
            'active_count' => 0,
            'inactive_count' => 0
        ];
    }
}

function getCourseDistribution(PDO $pdo): array {
    try {
        $query = "SELECT 
            course,
            COUNT(*) as count 
            FROM users 
            WHERE role = 'Student' 
            AND course IS NOT NULL 
            AND is_archived = 0
            GROUP BY course 
            ORDER BY count DESC";
            
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Format data for chart
        $courseData = [
            'labels' => [],
            'data' => []
        ];
        
        foreach ($results as $row) {
            $courseData['labels'][] = $row['course'];
            $courseData['data'][] = (int)$row['count'];
        }
        
        return $courseData;
    } catch (PDOException $e) {
        error_log("Error getting course distribution: " . $e->getMessage());
        return [
            'labels' => [],
            'data' => []
        ];
    }
}