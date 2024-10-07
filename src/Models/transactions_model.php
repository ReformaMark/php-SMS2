<?php

declare(strict_types=1);

function getAllTransactions(object $pdo, string|null $filter){
    try {
        if($filter === "" || $filter === null){
            $query = "SELECT * FROM financialtransactions;";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
    
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } else {
            $query = "SELECT * FROM financialtransactions WHERE CONCAT(transaction_id,student_id) LIKE '%$filter%';";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
    
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
      
    } catch (PDOException $e) {
        // Handle the exception, log or return appropriate response
        return null;
    }
}