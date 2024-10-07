<?php

declare(strict_types=1);

function fetchTransactions (object $pdo, string|null $filter){
    try{
        $transactions = getAllTransactions($pdo, $filter); 
        return $transactions;
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
        return null;
    };
}