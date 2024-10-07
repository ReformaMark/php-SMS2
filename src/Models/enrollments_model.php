<?php

declare(strict_types=1);


function getAllStudents(PDO $pdo): ?array {
    try {
        $query = "SELECT * FROM students;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        // Handle the exception, log or return appropriate response
        return null;
    }
}

function setStudent(object $pdo, string $firstName, string $lastName,string $gender, string $birthDate, string $email, string $phoneNumber, string $enrollmentDate, string $status) {
    try {
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