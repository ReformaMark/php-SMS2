<?php
declare(strict_types=1);

function getPayments(object $pdo, string $student_id): array {
    try {
        $query = "SELECT * FROM payments WHERE student_id = :student_id ORDER BY date DESC";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":student_id", $student_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        error_log("Database error in getPayments: " . $e->getMessage());
        return [];
    }
}