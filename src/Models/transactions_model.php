<?php

declare(strict_types=1);

function getAllTransactions(object $pdo, string $student_id): ?array { 
    try {
        $query = "SELECT * FROM financialtransactions WHERE student_id = :student_id ORDER BY date DESC;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':student_id', $student_id);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        // Log the error for debugging purposes
        error_log("Failed to fetch transactions: " . $e->getMessage());
        return null;
    }
}