<?php
require_once "../dbh.php";
require_once "../config_session.php";
require_once '../Models/transactions_model.php';
require_once '../Models/payment_model.php';
require_once '../Controllers/transaction_controller.php';
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Student') {
    header("Location: ../../index.php");
    die();
}

// Fetch the student's name from the session
$studentName = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Student';

// Fetch the student's ID from the session
$student_id = isset($_SESSION['user_username']) ? $_SESSION['user_username'] : null;

// Fetch transactions for the student
$transactions = fetchTransactions($pdo, $student_id);
$payments = fetchPayments($pdo, $student_id);

$recentTransactions = array_slice($transactions, 0, 10); // Get the latest 10 transactions

$balance = calculateTotalBalance($transactions);

$nextDue = getLatestDueDate($transactions);

$recentPayment = getLatestPaymentAmount($payments)

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../output.css" rel="stylesheet" >
    <link rel="stylesheet" href="../../public/css/styles.css">
    <title>Student Dashboard</title>
    <script>
        // Function to update the time every second
        function updateTime() {
            var currentTime = new Date(); // Get the current time
            var hours = currentTime.getHours();
            var minutes = currentTime.getMinutes();
            var seconds = currentTime.getSeconds();

            // Determine AM or PM
            var amPm = hours >= 12 ? "PM" : "AM";

            // Convert to 12-hour format
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'

            // Add leading zero to minutes and seconds if they are less than 10
            minutes = (minutes < 10 ? "0" : "") + minutes;
            seconds = (seconds < 10 ? "0" : "") + seconds;

            // Format the time with AM/PM
            var timeString = hours + ":" + minutes + ":" + seconds + " " + amPm;

            // Display the time on the page
            document.getElementById('clock').innerHTML = timeString;
        }

        // Update the time as soon as the page loads
        window.onload = function() {
            updateTime();
            // Update the time every second
            setInterval(updateTime, 1000);
        };
    </script>
</head>
<body class="bg-gray-100 min-h-[80vh] flex flex-col justify-between">
    <!-- Navigation bar -->
    <?php 
        $imageSrc =  '../../public/assets/images/bcp_logo.png';
        include('../../public/templates/header.php');
       
    ?>

    <div class="flex h-screen pt-20">
        <!-- sidebar -->
        <?php include('../../public/templates/student_sidebar.php');?>
        
        <main class="flex-1 p-8 overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-semibold text-blue-800">
                    Welcome, <?php echo $studentName; ?>!
                </h2>
                <div class="flex items-center">
                    <div class="relative mr-4">
                    <p id="clock"><?php echo date("h:i:s A"); ?></p>
                    </div>
                </div>
            </div>

            <!-- Student Ledger Overview -->
            

            <!-- Recent Transactions and Data Entry Queue usually tables -->
            <div class="flex flex-col gap-6 mb-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                    <div class="bg-white shadow-sm rounded-lg p-5">
                        <h2 class="text-xl font-semibold text-blue-800 mb-4">Outstanding Balance</h2>
                        <p>₱ <?php echo number_format($balance, 2); ?></p>
                    </div>
                    <div class="bg-white shadow-sm rounded-lg p-5">
                        <h2 class="text-xl font-semibold text-blue-800 mb-4">Next Payment Due </h2>
                        <p><?php echo date("F j, Y", strtotime($nextDue)); ?></p>
                       
                    </div>
                    <div class="bg-white shadow-sm rounded-lg p-5">
                        <h2 class="text-xl font-semibold text-blue-800 mb-4">Recent Payment</h2>
                       
                        <p>₱ <?php echo number_format($recentPayment, 2); ?></p>
                    </div>
                    <div class="bg-white shadow-sm rounded-lg p-5">
                        <h2 class="text-xl font-semibold text-blue-800 mb-4">Recent Charge</h2>
                        <?php
                            $latestChargeAmount = 0;
                            foreach ($recentTransactions as $transaction):
                                if (strtolower($transaction['transaction_type']) === 'charge' && $latestChargeAmount === 0) {
                                    $latestChargeAmount = $transaction['amount'];
                                    break; // Exit the loop after finding the first charge
                                }
                            endforeach;

                            // Debugging output
                            if ($latestChargeAmount === 0) {
                                echo "No recent charges found.";
                            } else {
                                echo '₱ ' . number_format($latestChargeAmount, 2);
                            }
                        ?>
                    </div>
               
                </div>
                <div class="grid grid-cols-2 gap-x-5">
                    <div class="bg-white rounded-lg shadow p-4 sm:p-6 ">
                        <h3 class="text-xl font-semibold text-blue-800 mb-4">Payment Transactions Made</h3>
                        <table class="w-full">
                            <thead>
                                <tr class="bg-blue-100">
                                    <th class="py-2 px-4 text-left">Date</th>
                                    <th class="py-2 px-4 text-left">Fee</th>
                                    <th class="py-2 px-4 text-left">Status</th>
                                    <th class="py-2 px-4 text-left">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Sample data
                                $mockPayments = $payments;

                                $perPage = 5;
                                $totalPayments = count($mockPayments);
                                $totalPages = ceil($totalPayments / $perPage);
                                $currentPage = isset($_GET['paymentPage']) ? (int)$_GET['paymentPage'] : 1;
                                $start = ($currentPage - 1) * $perPage;
                                $payments = array_slice($mockPayments, $start, $perPage);
                                foreach ($payments as $index => $payments):
                                ?>
                                <tr class="<?php echo $index % 2 == 0 ? 'bg-gray-50' : 'bg-white'; ?>">
                                    <td class="py-2 px-4"><?php echo $payments['date']; ?></td>
                                    <td class="py-2 px-4"><?php echo $payments['description']; ?></td>
                                    <td class="py-2 px-4"><?php echo $payments['status']; ?></td>
                                    <td class="py-2 px-4">₱<?php echo number_format($payments['amount']); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <!-- Pagination -->
                        <div class="flex justify-center mt-4 space-x-1">
                            <?php if ($currentPage > 1): ?>
                                <a href="?page=<?php echo $currentPage - 1; ?>" class="px-3 py-1 bg-gray-200 text-gray-700 rounded-lg hover:bg-blue-500 hover:text-white">Prev</a>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <a href="?page=<?php echo $i; ?>" class="px-3 py-1 <?php echo $i == $currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700'; ?> rounded-lg hover:bg-blue-500 hover:text-white"><?php echo $i; ?></a>
                            <?php endfor; ?>

                            <?php if ($currentPage < $totalPages): ?>
                                <a href="?page=<?php echo $currentPage + 1; ?>" class="px-3 py-1 bg-gray-200 text-gray-700 rounded-lg hover:bg-blue-500 hover:text-white">Next</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4 sm:p-6 ">
                        <h3 class="text-xl font-semibold text-blue-800 mb-4">Charges & Fees</h3>
                        <table class="w-full">
                            <thead>
                                <tr class="bg-blue-100">
                                    <th class="py-2 px-4 text-left">Date</th>
                                    <th class="py-2 px-4 text-left">Fee</th>
                                    <th class="py-2 px-4 text-left">Due Date</th>
                                    <th class="py-2 px-4 text-left">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Sample data
                                $mockCharges = $transactions;
                                $perPage = 5;
                                $totalCharges = count($mockCharges);
                                $totalPages = ceil($totalCharges / $perPage);
                                $currentPage = isset($_GET['chargesPage']) ? (int)$_GET['chargesPage'] : 1;
                                $start = ($currentPage - 1) * $perPage;
                                $charges = array_slice($mockCharges, $start, $perPage);

                                if (empty($charges)) {
                                    echo "<tr><td colspan='4' class='text-center py-2 px-4'>No charges found.</td></tr>";
                                } else {
                                    foreach ($charges as $index => $charge):
                                        ?>
                                        <tr class="<?php echo $index % 2 == 0 ? 'bg-gray-50' : 'bg-white'; ?>">
                                            <td class="py-2 px-4"><?php echo $charge['date']; ?></td>
                                            <td class="py-2 px-4"><?php echo $charge['description']; ?></td>
                                            <td class="py-2 px-4"><?php echo $charge['due_date']; ?></td>
                                            <td class="py-2 px-4">₱<?php echo number_format($charge['amount']); ?></td>
                                        </tr>
                                        <?php
                                    endforeach;
                                }
                                ?>
                            </tbody>
                        </table>
                           <!-- Pagination -->
                           <div class="flex justify-center mt-4 space-x-1">
                                <?php if ($currentPage > 1): ?>
                                    <a href="?page=<?php echo $currentPage - 1; ?>" class="px-3 py-1 bg-gray-200 text-gray-700 rounded-lg hover:bg-blue-500 hover:text-white">Prev</a>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <a href="?page=<?php echo $i; ?>" class="px-3 py-1 <?php echo $i == $currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700'; ?> rounded-lg hover:bg-blue-500 hover:text-white"><?php echo $i; ?></a>
                                <?php endfor; ?>

                                <?php if ($currentPage < $totalPages): ?>
                                    <a href="?page=<?php echo $currentPage + 1; ?>" class="px-3 py-1 bg-gray-200 text-gray-700 rounded-lg hover:bg-blue-500 hover:text-white">Next</a>
                                <?php endif; ?>
                            </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    function filterTransactions(filterType) {
        const rows = document.querySelectorAll('#transactionTableBody tr');
        let hasVisibleRows = false; // Flag to check if any rows are visible
        const noTransactionsMessage = document.getElementById('noTransactionsMessage');

        rows.forEach(row => {
            const transactionType = row.querySelector('td:nth-child(2)').textContent;

            if (filterType === 'all') {
                row.style.display = '';
                hasVisibleRows = true; // At least one row is visible
            } else if (filterType === 'payments' && transactionType === 'Payment') {
                row.style.display = '';
                hasVisibleRows = true; // At least one row is visible
            } else if (filterType === 'charges' && transactionType === 'Charge') {
                row.style.display = '';
                hasVisibleRows = true; // At least one row is visible
            } else {
                row.style.display = 'none';
            }
        });

        // Show or hide the no transactions message based on visibility
        if (!hasVisibleRows) {
            noTransactionsMessage.textContent = `No transactions that are equal to the selected filter: ${filterType}.`;
            noTransactionsMessage.style.display = 'block'; // Show the message
        } else {
            noTransactionsMessage.style.display = 'none'; // Hide the message
        }
    }
    </script>


</body>
</html>
