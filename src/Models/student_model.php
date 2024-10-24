<?php

declare(strict_types=1);

function getStudentDetails(object $pdo, int $user_id) {
    try {
        $query = "SELECT * FROM users WHERE user_id = :user_id AND role = 'Student';";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        error_log("Database error in getStudentDetails: " . $e->getMessage());
        return null;
    }
}

function updateStudentProfile(object $pdo, int $user_id, array $data) {
    try {
        $query = "UPDATE users SET 
                  first_name = :first_name, 
                  last_name = :last_name, 
                  email = :email, 
                  phone_number = :phone_number,
                  date_of_birth = :date_of_birth,
                  gender = :gender,
                  address = :address
                  WHERE user_id = :user_id AND role = 'Student';";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->bindParam(":first_name", $data['first_name']);
        $stmt->bindParam(":last_name", $data['last_name']);
        $stmt->bindParam(":email", $data['email']);
        $stmt->bindParam(":phone_number", $data['phone_number']);
        $stmt->bindParam(":date_of_birth", $data['date_of_birth']);
        $stmt->bindParam(":gender", $data['gender']);
        $stmt->bindParam(":address", $data['address']);

        $stmt->execute();
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        error_log("Database error in updateStudentProfile: " . $e->getMessage());
        return false;
    }
}

function getStudentCourses(object $pdo, int $user_id) {
    try {
        $query = "SELECT c.* FROM courses c
                  JOIN enrollments e ON c.course_id = e.course_id
                  WHERE e.student_id = :user_id;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        error_log("Database error in getStudentCourses: " . $e->getMessage());
        return null;
    }
}

function getStudentGrades(object $pdo, int $user_id) {
    try {
        $query = "SELECT c.course_name, e.semester, e.current_year, g.grade_type, g.grade_value
                  FROM grades g
                  JOIN enrollments e ON g.enrollment_id = e.enrollment_id
                  JOIN courses c ON e.course_id = c.course_id
                  WHERE e.student_id = :user_id
                  ORDER BY e.current_year DESC, e.semester DESC;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        error_log("Database error in getStudentGrades: " . $e->getMessage());
        return null;
    }
}

function getStudentFinancialTransactions(object $pdo, int $user_id, int $limit = 10) {
    try {
        $query = "SELECT * FROM financialtransactions
                  WHERE student_id = :user_id
                  ORDER BY date DESC
                  LIMIT :limit;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        error_log("Database error in getStudentFinancialTransactions: " . $e->getMessage());
        return null;
    }
}

// Add more student-related functions as needed
