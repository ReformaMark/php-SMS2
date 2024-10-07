<?php
    require_once "../config_session.php";
    require_once "../Models/students_model.php";
    if(!isset($_SESSION['user_id'])){
        header("Location: ../../index.php");
        die();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIS Staff Dashboard</title>
    <link href="../../output.css" rel="stylesheet" >
    <link rel="stylesheet" href="../../public/css/styles.css">
    <script src="../../node_modules/chart.js/dist/chart.umd.js"></script>
</head>
<body class="bg-gray-100 min-h-[80vh] flex flex-col justify-between">
    <!-- Navigation bar -->
    <?php 
        $imageSrc =  '../../public/assets/images/bcp_logo.png';
        include('../../public/templates/header.php');
       
    ?>
    <div class="flex h-screen pt-20"> 
        <!-- sidebar -->
        <?php include('../../public/templates/sidebar.php');?>
        
        <!--  Dashboard page -->
        <main class="flex-1 p-8 overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-semibold text-blue-800">
                    MIS Staff Dashboard
                </h2>
                <div class="flex items-center">
                    <div class="relative mr-4">

                    </div>
                </div>
            </div>

            <!-- Student Ledger Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-semibold text-blue-800 mb-4">
                        Total Student Accounts
                    </h3>

                    <p class="text-4xl font-bold text-blue-600">
                        <?php 
                            require_once "../dbh.php";
                            $totalUsers = getCountStudents($pdo);
                            echo $totalUsers;
                        ?>
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-semibold text-blue-800 mb-4">
                        Accounts with Outstanding Balance
                    </h3>
                    <p class="text-4xl font-bold text-yellow-600">
                        1,287
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-semibold text-blue-800 mb-4">
                        Total Outstanding Balance
                    </h3>
                    <p class="text-4xl font-bold text-red-600">
                        ₱26,172,500
                    </p>
                </div>
            </div>

            <!-- Recent Transactions and Data Entry Queue usually tables -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-semibold text-blue-800 mb-4">
                        Recent Transactions
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

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-semibold text-blue-800 mb-4">Data Entry Queue</h3>
                    <div class="mb-4">
                        <div class="flex justify-between items-center">
                            <span>Pending Tasks</span>
                            <span class="font-bold">15</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: 60%"></div>
                        </div>
                    </div>
                    <ul class="space-y-2">
                        <li class="flex justify-between items-center">
                            <span>New Student Records</span>
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded">5</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span>Payment Updates</span>
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded">8</span>
                        </li>
                        <li class="flex justify-between items-center">
                            <span>Course Changes</span>
                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded">2</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Monthly Financial Trend Chart -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-semibold text-blue-800 mb-4">Monthly Financial Trend</h3>
                    <canvas id="financialTrendChart"></canvas>
                </div>

                <!-- Student Account Status Pie Chart -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-semibold text-blue-800 mb-4">Student Account Status</h3>
                    <canvas id="accountStatusChart"></canvas>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Monthly Financial Trend Chart
        const financialTrendCtx = document.getElementById('financialTrendChart').getContext('2d');
        new Chart(financialTrendCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [
                    {
                        label: 'Payments Received',
                        data: [3250000, 2950000, 4000000, 4050000, 2800000, 2750000],
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    },
                    {
                        label: 'Charges Applied',
                        data: [3500000, 3100000, 3750000, 4250000, 2900000, 3000000],
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value, index, values) {
                                return '₱' + (value / 1000000).toFixed(1) + 'M';
                            }
                        }
                    }
                }
            }
        });

        // Student Account Status Pie Chart
        const accountStatusCtx = document.getElementById('accountStatusChart').getContext('2d');
        new Chart(accountStatusCtx, {
            type: 'pie',
            data: {
                labels: ['Paid', 'Partially Paid', 'Overdue'],
                datasets: [{
                    data: [3000, 1500, 734],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(255, 99, 132, 0.6)'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    </script>
</body>
</html>