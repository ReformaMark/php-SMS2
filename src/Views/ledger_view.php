<?php

declare(strict_types=1);

function displayLedger(): array
{
    $mockTransactions = [
        ['date' => '2023-05-01', 'due_date' => '2023-06-01', 'fee' => 'Tuition Fee', 'amount' => 25000, 'total_amount_paid' => 25000, 'balance' => 0],
        ['date' => '2023-05-02', 'due_date' => '2023-06-02', 'fee' => 'Library Fee', 'amount' => 5000, 'total_amount_paid' => 0, 'balance' => 5000],
        ['date' => '2023-05-10', 'due_date' => '2023-06-10', 'fee' => 'Library Fee', 'amount' => 5000, 'total_amount_paid' => 5000, 'balance' => 0],
        ['date' => '2023-05-15', 'due_date' => '2023-06-15', 'fee' => 'Uniform Fee', 'amount' => 10000, 'total_amount_paid' => 0, 'balance' => 10000],
        ['date' => '2023-05-20', 'due_date' => '2023-06-20', 'fee' => 'Uniform Fee', 'amount' => 10000, 'total_amount_paid' => 10000, 'balance' => 0],
        ['date' => '2023-06-01', 'due_date' => '2023-07-01', 'fee' => 'Tuition Fee', 'amount' => 30000, 'total_amount_paid' => 0, 'balance' => 30000]
    ];

    $perPage = 10;
    $totalTransactions = count($mockTransactions);
    $totalPages = ceil($totalTransactions / $perPage);
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    // Validate current page
    if ($currentPage < 1) {
        $currentPage = 1;
    } elseif ($currentPage > $totalPages) {
        $currentPage = $totalPages;
    }

    $start = ($currentPage - 1) * $perPage;
    $transactions = array_slice($mockTransactions, $start, $perPage);

    foreach ($transactions as $index => $transaction): ?>
        <tr class="<?php echo $index % 2 == 0 ? 'bg-gray-50' : 'bg-white'; ?>">
            <td class="py-2 px-4"><?php echo htmlspecialchars($transaction['date']); ?></td>
            <td class="py-2 px-4"><?php echo htmlspecialchars($transaction['due_date']); ?></td>
            <td class="py-2 px-4"><?php echo htmlspecialchars($transaction['fee']); ?></td>
            <td class="py-2 px-4">₱<?php echo number_format((float)$transaction['amount']); ?></td>
            <td class="py-2 px-4">₱<?php echo number_format((float)$transaction['total_amount_paid']); ?></td>
            <td class="py-2 px-4">₱<?php echo number_format((float)$transaction['balance']); ?></td>
        </tr>
    <?php endforeach;

    // Return pagination data
    return [
        'currentPage' => $currentPage,
        'totalPages' => $totalPages
    ];
}
?>
