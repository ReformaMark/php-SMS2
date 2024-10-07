<?php

declare(strict_types=1);

function displayTransactions(array|null $transactions): void{
 
    if($transactions !== []){
        foreach ($transactions as $transaction) {
        echo '<tr class="text-center even:bg-gray-50">';
                echo '<td class="border border-gray-400">' . htmlspecialchars((string)$transaction['transaction_id']) . '</td>';
                echo '<td class="border border-gray-400">' . htmlspecialchars((string)$transaction['student_id']).'</td>';
                echo '<td class="border border-gray-400">' . htmlspecialchars((string)$transaction['amount']) . '</td>';
                echo '<td class="border border-gray-400">' . htmlspecialchars((string)$transaction['transaction_type']) . '</td>';
                echo '<td class="border border-gray-400">' . htmlspecialchars((string)$transaction['description']) . '</td>';
                echo '<td class="border border-gray-400">' . htmlspecialchars((string)$transaction['date']) . '</td>';
            echo '</tr>';
        }
    } else{
        echo '<tr>
            <td colspan="6" class="text-center py-5">No results found.</td>
            </tr>';
    }
}



