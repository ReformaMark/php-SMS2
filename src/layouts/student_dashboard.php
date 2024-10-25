<?php
require_once "../config_session.php";
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Student') {
    header("Location: ../../index.php");
    die();
}

// Fetch the student's name from the session
$studentName = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Student';

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
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-5">
                    <div class="bg-white shadow-sm rounded-lg p-5">
                        <h2 class="text-xl font-semibold text-blue-800 mb-4">Outstanding Balance</h2>
                        <p>₱ 0.00</p>
                    </div>
                    <div class="bg-white shadow-sm rounded-lg p-5">
                        <h2 class="text-xl font-semibold text-blue-800 mb-4">Next Payment Due </h2>
                        <p>- </p>
                    </div>
                    <div class="bg-white shadow-sm rounded-lg p-5">
                        <h2 class="text-xl font-semibold text-blue-800 mb-4">Recent Payment</h2>
                        <p>₱ 0.00</p>
                    </div>
                    <div class="bg-white shadow-sm rounded-lg p-5">
                        <h2 class="text-xl font-semibold text-blue-800 mb-4">Recent Charge</h2>
                        <p>₱ 0.00</p>
                    </div>
               
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-semibold text-blue-800 mb-4">
                        Your Recent Transactions
                    </h3>

                    <div class="mb-4">
                    <select class="bg-gray-100 border border-gray-300 rounded px-3 py-1">
                            <option value="all">All Transactions</option>
                            <option value="payments">Payments</option>
                            <option value="charges">Charges</option>
                    </select>
                    </div>

                    <table class="w-full">
                        <thead>
                            <tr class="bg-blue-100">
                                <th class="py-2 px-4 text-left">Date</th>
                                <th class="py-2 px-4 text-left">Type</th>
                                <th class="py-2 px-4 text-left">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Sample data
                            $transactions = [
                                ['date' => '2023-05-01', 'type' => 'Payment', 'amount' => 25000],
                                ['date' => '2023-05-02', 'type' => 'Charge', 'amount' => 50000],
                                ['date' => '2023-05-03', 'type' => 'Payment', 'amount' => 37500],
                                ['date' => '2023-05-04', 'type' => 'Charge', 'amount' => 12500],
                                ['date' => '2023-05-05', 'type' => 'Payment', 'amount' => 50000],
                            ];

                            foreach ($transactions as $index => $transaction):
                            ?>
                            <tr class="<?php echo $index % 2 == 0 ? 'bg-gray-50' : 'bg-white'; ?>">
                                <td class="py-2 px-4"><?php echo $transaction['date']; ?></td>
                                <td class="py-2 px-4"><?php echo $transaction['type']; ?></td>
                                <td class="py-2 px-4">₱<?php echo number_format($transaction['amount']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </main>
    </div>
</body>
</html>
