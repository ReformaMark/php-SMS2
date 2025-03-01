<?php
    require_once "../config_session.php";
    require_once "../Models/enrollments_model.php";
    require_once "../../data/mock_transactions.php";

    if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Admin'){
        header("Location: ../../index.php");
        die();
    }

    $outstandingAccounts = array_filter($mockTransactions, function($transaction) {
        return in_array($transaction['status'], ['Pending', 'Partially Paid', 'Overdue']);
    });
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIS Dashboard</title>
    <link href="../../output.css" rel="stylesheet" >
    <link rel="stylesheet" href="../../public/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    MIS Dashboard
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
                        <?php
                            // Count transactions with Pending, Partially Paid, or Overdue status
                            $outstandingAccounts = array_filter($mockTransactions, function($transaction) {
                                return in_array($transaction['status'], ['Pending', 'Partially Paid', 'Overdue']);
                            });
                            echo count($outstandingAccounts);
                        ?>
                    </p>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-semibold text-blue-800 mb-4">
                        Total Outstanding Balance
                    </h3>
                    <p class="text-4xl font-bold text-red-600">
                        <?php
                            // Sum amounts from transactions with outstanding balances
                            $totalOutstanding = array_reduce($outstandingAccounts, function($carry, $transaction) {
                                return $carry + floatval($transaction['amount']);
                            }, 0);
                            echo '₱' . number_format($totalOutstanding, 2);
                        ?>
                    </p>
                </div>
            </div>

            <!-- Recent Transactions and Data Entry Queue usually tables -->
            <div class="grid grid-cols-1 gap-6 mb-6">
                
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-semibold text-blue-800 mb-4">
                        Recent Transactions
                    </h3>

                    <table class="w-full">
                        <thead>
                            <tr class="bg-blue-100">
                                <th class="py-2 px-4 text-left">Date</th>
                                <th class="py-2 px-4 text-left">Transaction ID</th>
                                <th class="py-2 px-4 text-left">Student Name</th>
                                <th class="py-2 px-4 text-left">Amount</th>
                                <th class="py-2 px-4 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        // Get the mock transactions array from transactions.php
                        $mockTransactions = [
                            ['transaction_id' => 'T015', 'student_id' => 's21013225', 'student_name' => 'Mia', 'student_lastname' => 'Nelson', 'amount' => '7500', 'transaction_type' => 'Debit', 'status' => 'Partially Paid', 'date' => '2023-01-15'],
                            ['transaction_id' => 'T014', 'student_id' => 's21013224', 'student_name' => 'Leo', 'student_lastname' => 'Miller', 'amount' => '7000', 'transaction_type' => 'Cash', 'status' => 'Paid', 'date' => '2023-01-14'],
                            ['transaction_id' => 'T013', 'student_id' => 's21013223', 'student_name' => 'Karen', 'student_lastname' => 'Lewis', 'amount' => '6500', 'transaction_type' => 'Debit', 'status' => 'Overdue', 'date' => '2023-01-13'],
                            ['transaction_id' => 'T012', 'student_id' => 's21013222', 'student_name' => 'Jack', 'student_lastname' => 'King', 'amount' => '6000', 'transaction_type' => 'Cash', 'status' => 'Partially Paid', 'date' => '2023-01-12'],
                            ['transaction_id' => 'T011', 'student_id' => 's21013221', 'student_name' => 'Ivy', 'student_lastname' => 'Jones', 'amount' => '5500', 'transaction_type' => 'Debit', 'status' => 'Paid', 'date' => '2023-01-11']
                        ];

                        foreach ($mockTransactions as $index => $transaction):
                            // Determine status color
                            $statusClass = '';
                            switch ($transaction['status']) {
                                case 'Paid':
                                    $statusClass = 'bg-green-200 text-green-600';
                                    break;
                                case 'Partially Paid':
                                    $statusClass = 'bg-yellow-200 text-yellow-600';
                                    break;
                                case 'Overdue':
                                    $statusClass = 'bg-red-200 text-red-600';
                                    break;
                                default:
                                    $statusClass = 'bg-gray-200 text-gray-600';
                            }
                        ?>
                        <tr class="<?php echo $index % 2 == 0 ? 'bg-gray-50' : 'bg-white'; ?> hover:bg-gray-100">
                            <td class="py-2 px-4"><?php echo $transaction['date']; ?></td>
                            <td class="py-2 px-4"><?php echo $transaction['transaction_id']; ?></td>
                            <td class="py-2 px-4"><?php echo $transaction['student_name'] . ' ' . $transaction['student_lastname']; ?></td>
                            <td class="py-2 px-4">₱<?php echo number_format($transaction['amount'], 2); ?></td>
                            <td class="py-2 px-4">
                                <span class="px-2 py-1 rounded-full text-xs <?php echo $statusClass; ?>">
                                    <?php echo $transaction['status']; ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    </table>
                </div>

                <!-- <div class="bg-white rounded-lg shadow p-6">
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
                </div> -->
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Monthly Financial Trend Chart -->
                <!-- <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-semibold text-blue-800 mb-4">Monthly Financial Trend</h3>
                    <canvas id="financialTrendChart"></canvas>
                </div> -->

                <!-- Student Account Status Pie Chart -->
                <!-- <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-semibold text-blue-800 mb-4">Student Account Status</h3>
                    <canvas id="accountStatusChart"></canvas>
                </div> -->
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-xl font-semibold text-blue-800 mb-4">Student Status Distribution</h3>
                <?php 
                    $studentDistribution = getStudentStatusDistribution($pdo);
                ?>
                <div class="flex justify-between mb-4">
                    <div class="text-center">
                        <span class="block text-2xl font-bold text-green-600">
                            <?php echo $studentDistribution['active_count']; ?>
                        </span>
                        <span class="text-sm text-gray-600">Active Students</span>
                    </div>
                    <div class="text-center">
                        <span class="block text-2xl font-bold text-red-600">
                            <?php echo $studentDistribution['inactive_count']; ?>
                        </span>
                        <span class="text-sm text-gray-600">Dropped Students</span>
                    </div>
                </div>
                <div style="width: 100%; max-width: 28rem; margin-left: auto; margin-right: auto; height: 300px;">
                    <canvas id="studentDistributionChart"></canvas>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Monthly Financial Trend Chart
        // const financialTrendCtx = document.getElementById('financialTrendChart').getContext('2d');
        // new Chart(financialTrendCtx, {
        //     type: 'bar',
        //     data: {
        //         labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        //         datasets: [
        //             {
        //                 label: 'Payments Received',
        //                 data: [3250000, 2950000, 4000000, 4050000, 2800000, 2750000],
        //                 backgroundColor: 'rgba(54, 162, 235, 0.6)',
        //             },
        //             {
        //                 label: 'Charges Applied',
        //                 data: [3500000, 3100000, 3750000, 4250000, 2900000, 3000000],
        //                 backgroundColor: 'rgba(255, 99, 132, 0.6)',
        //             }
        //         ]
        //     },
        //     options: {
        //         responsive: true,
        //         scales: {
        //             y: {
        //                 beginAtZero: true,
        //                 ticks: {
        //                     callback: function(value, index, values) {
        //                         return '₱' + (value / 1000000).toFixed(1) + 'M';
        //                     }
        //                 }
        //             }
        //         }
        //     }
        // });

        // Student Account Status Pie Chart
        // const accountStatusCtx = document.getElementById('accountStatusChart').getContext('2d');
        // new Chart(accountStatusCtx, {
        //     type: 'pie',
        //     data: {
        //         labels: ['Paid', 'Partially Paid', 'Overdue'],
        //         datasets: [{
        //             data: [3000, 1500, 734],
        //             backgroundColor: [
        //                 'rgba(75, 192, 192, 0.6)',
        //                 'rgba(255, 206, 86, 0.6)',
        //                 'rgba(255, 99, 132, 0.6)'
        //             ]
        //         }]
        //     },
        //     options: {
        //         responsive: true,
        //         plugins: {
        //             legend: {
        //                 position: 'bottom',
        //             }
        //         }
        //     }
        // });

        const studentDistributionCtx = document.getElementById('studentDistributionChart').getContext('2d');
            new Chart(studentDistributionCtx, {
                type: 'pie',
                data: {
                    labels: ['Active Students', 'Dropped Students'],
                    datasets: [{
                        data: [
                            <?php echo $studentDistribution['active_count']; ?>,
                            <?php echo $studentDistribution['inactive_count']; ?>
                        ],
                        backgroundColor: [
                            'rgba(34, 197, 94, 0.6)', // green for active
                            'rgba(239, 68, 68, 0.6)'  // red for inactive
                        ],
                        borderColor: [
                            'rgba(34, 197, 94, 1)',
                            'rgba(239, 68, 68, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((context.raw / total) * 100).toFixed(1);
                                    return `${context.label}: ${context.raw} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
    </script>
</body>
</html>
