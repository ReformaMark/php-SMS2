<?php
declare(strict_types=1);

function getPayments(object $pdo, string $student_id): array {
    try {
        $query = "SELECT payments.*, financialtransactions.* FROM payments LEFT JOIN financialtransactions ON payments.transaction_id = financialtransactions.id WHERE payments.student_id = :student_id ORDER BY payments.date DESC";
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