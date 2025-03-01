<?php

function fetchTransactions (object $pdo, string $student_id){
    try{
        $transactions = getAllTransactions($pdo, $student_id); 
        return $transactions;
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
        return null;
    };
};


function fetchPayments (object $pdo, string $student_id): array { 
    try{
        $payments = getPayments($pdo, $student_id); 
        return $payments;
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
        return [];
    };
};

function calculateTotalBalance($transactions) {
    $totalBalance = 0;

    foreach ($transactions as $transaction) {
        $amount = isset($transaction['balance']) ? (float)$transaction['balance'] : 0;
        $totalBalance += $amount;
    }

    return $totalBalance;
};


function getLatestDueDate($transactions) {
    $latestDate = null;

    foreach ($transactions as $transaction) {
        if (isset($transaction['due_date']) && !empty($transaction['due_date'])) {
            $dueDate = strtotime($transaction['due_date']);

            if ($latestDate === null || $dueDate > $latestDate) {
                $latestDate = $dueDate;
            }
        }
    }

    return $latestDate ? date('Y-m-d', $latestDate) : null;
};

function getLatestPaymentAmount($payments) {
    $latestDate = null;
    $latestAmount = 0;

    foreach ($payments as $payment) {
        if (isset($payment['date']) && !empty($payment['date']) && isset($payment['amount'])) {
            $paymentDate = strtotime($payment['date']);

            if ($latestDate === null || $paymentDate > $latestDate) {
                $latestDate = $paymentDate;
                $latestAmount = $payment['amount'];
            }
        }
    }

    return $latestDate ? $latestAmount : 0;
};





