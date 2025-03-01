<?php

    require_once "../config_session.php";
    require_once "../dbh.php";
    require_once "../Models/transactions_model.php";
    require_once "../Views/transactions_view.php";
    
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
    <title>Transactions</title>
    <link href="../../output.css" rel="stylesheet" >
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body class="bg-gray-100 min-h-[80vh] flex flex-col justify-between">
     <!-- Navigation bar -->
    <?php 
        $imageSrc =  '../../public/assets/images/bcp_logo.png';
        include('../../public/templates/header.php');
    ?>
    <div class="flex flex-col lg:flex-row pt-20"> 
        <!-- sidebar -->
        <?php include('../../public/templates/sidebar.php');?>

        <!-- Student page -->
        <div class="bg-white m-5 w-full p-3">
          
            <form action="" method="get" class="grid grid-cols-1 lg:grid-cols-12 items-center mb-5">
                <h1 class="text-lg font-semibold col-span-1 lg:col-span-9">Transaction history</h1>
                <div class="flex justify-end items-center gap-x-5 col-span-1 lg:col-span-3 mt-3 lg:mt-0">
                    <input type="text" placeholder="Transaction Id, student Id" id="search" name="search" value="<?php if(isset($_GET['search'])){echo $_GET['search'];} ?>" required class="mt-1 block w-full lg:w-auto h-10 py-1 px-2 border bg-gray-50 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500 p-2" />
                    <button type="submit" class='px-2 py-1 bg-blue-700 rounded-lg text-white hover:bg-blue-500'>Search</button>
                </div>
            </form>
           
            <div class="overflow-x-auto">
                <table class="w-full shadow-lg border-collapse m-h-[50vh]">
                    <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-center">Transaction ID</th>
                        <th class="py-3 px-6 text-center">Student ID</th>
                        <th class="py-3 px-6 text-center">Student Name</th>
                        <th class="py-3 px-6 text-center">Amount</th>
                        <th class="py-3 px-6 text-center">Date</th>
                        <th class="py-3 px-6 text-center">Type</th>
                        <th class="py-3 px-6 text-center">Status</th>
                        <!-- <th class="py-3 px-6 text-center">Actions</th> -->
                    </tr>
                    </thead>

                    <?php  
                        // Mock data for transactions
                        $mockTransactions = [
                            ['transaction_id' => 'T001', 'student_id' => 's21013211', 'student_name' => 'John', 'student_lastname' => 'Doe', 'amount' => '1000', 'transaction_type' => 'Cash', 'status' => 'Paid', 'date' => '2023-01-01'],
                            ['transaction_id' => 'T002', 'student_id' => 's21013212', 'student_name' => 'Jane', 'student_lastname' => 'Smith', 'amount' => '500', 'transaction_type' => 'Debit', 'status' => 'Partially Paid', 'date' => '2023-01-02'],
                            ['transaction_id' => 'T003', 'student_id' => 's21013213', 'student_name' => 'Alice', 'student_lastname' => 'Johnson', 'amount' => '1500', 'transaction_type' => 'Cash', 'status' => 'Overdue', 'date' => '2023-01-03'],
                            ['transaction_id' => 'T004', 'student_id' => 's21013214', 'student_name' => 'Bob', 'student_lastname' => 'Brown', 'amount' => '2000', 'transaction_type' => 'Debit', 'status' => 'Paid', 'date' => '2023-01-04'],
                            ['transaction_id' => 'T005', 'student_id' => 's21013215', 'student_name' => 'Charlie', 'student_lastname' => 'Davis', 'amount' => '2500', 'transaction_type' => 'Cash', 'status' => 'Partially Paid', 'date' => '2023-01-05'],
                            ['transaction_id' => 'T006', 'student_id' => 's21013216', 'student_name' => 'David', 'student_lastname' => 'Evans', 'amount' => '3000', 'transaction_type' => 'Cash', 'status' => 'Paid', 'date' => '2023-01-06'],
                            ['transaction_id' => 'T007', 'student_id' => 's21013217', 'student_name' => 'Eve', 'student_lastname' => 'Foster', 'amount' => '3500', 'transaction_type' => 'Debit', 'status' => 'Overdue', 'date' => '2023-01-07'],
                            ['transaction_id' => 'T008', 'student_id' => 's21013218', 'student_name' => 'Frank', 'student_lastname' => 'Green', 'amount' => '4000', 'transaction_type' => 'Cash', 'status' => 'Partially Paid', 'date' => '2023-01-08'],
                            ['transaction_id' => 'T009', 'student_id' => 's21013219', 'student_name' => 'Grace', 'student_lastname' => 'Harris', 'amount' => '4500', 'transaction_type' => 'Debit', 'status' => 'Paid', 'date' => '2023-01-09'],
                            ['transaction_id' => 'T010', 'student_id' => 's21013220', 'student_name' => 'Hank', 'student_lastname' => 'Ivy', 'amount' => '5000', 'transaction_type' => 'Cash', 'status' => 'Overdue', 'date' => '2023-01-10'],
                            ['transaction_id' => 'T011', 'student_id' => 's21013221', 'student_name' => 'Ivy', 'student_lastname' => 'Jones', 'amount' => '5500', 'transaction_type' => 'Debit', 'status' => 'Paid', 'date' => '2023-01-11'],
                            ['transaction_id' => 'T012', 'student_id' => 's21013222', 'student_name' => 'Jack', 'student_lastname' => 'King', 'amount' => '6000', 'transaction_type' => 'Cash', 'status' => 'Partially Paid', 'date' => '2023-01-12'],
                            ['transaction_id' => 'T013', 'student_id' => 's21013223', 'student_name' => 'Karen', 'student_lastname' => 'Lewis', 'amount' => '6500', 'transaction_type' => 'Debit', 'status' => 'Overdue', 'date' => '2023-01-13'],
                            ['transaction_id' => 'T014', 'student_id' => 's21013224', 'student_name' => 'Leo', 'student_lastname' => 'Miller', 'amount' => '7000', 'transaction_type' => 'Cash', 'status' => 'Paid', 'date' => '2023-01-14'],
                            ['transaction_id' => 'T015', 'student_id' => 's21013225', 'student_name' => 'Mia', 'student_lastname' => 'Nelson', 'amount' => '7500', 'transaction_type' => 'Debit', 'status' => 'Partially Paid', 'date' => '2023-01-15']
                        ];

                        // Pagination logic
                        $perPage = 10;
                        $totalTransactions = count($mockTransactions);
                        $totalPages = ceil($totalTransactions / $perPage);
                        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $start = ($currentPage - 1) * $perPage;
                        $transactions = array_slice($mockTransactions, $start, $perPage);

                        if(isset($_GET['search'])){
                            $filter = $_GET['search'];
                            $transactions = array_filter($mockTransactions, function($transaction) use ($filter) {
                                return strpos($transaction['transaction_id'], $filter) !== false || strpos($transaction['student_id'], $filter) !== false;
                            });
                        } else {
                            $transactions = array_slice($mockTransactions, $start, $perPage);
                        }

                        foreach ($transactions as $transaction) {
                            echo "<tr class='border-b border-gray-200 hover:bg-gray-100'>";
                            echo "<td class='py-3 px-6 text-center whitespace-nowrap'>{$transaction['transaction_id']}</td>";
                            echo "<td class='py-3 px-6 text-center'>{$transaction['student_id']}</td>";
                            echo "<td class='py-3 px-6 text-center'>{$transaction['student_name']} {$transaction['student_lastname']}</td>";
                            echo "<td class='py-3 px-6 text-center'>PHP" . number_format($transaction['amount'], 2) . "</td>";
                            echo "<td class='py-3 px-6 text-center'>{$transaction['date']}</td>";
                            echo "<td class='py-3 px-6 text-center'><span class='bg-" . ($transaction['transaction_type'] == 'Cash' ? 'green' : 'red') . "-200 text-" . ($transaction['transaction_type'] == 'Cash' ? 'green' : 'red') . "-600 py-1 px-3 rounded-full text-xs'>{$transaction['transaction_type']}</span></td>";
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
                                    break;
                            }
                            echo "<td class='py-3 px-6 text-center'><span class='py-1 px-3 rounded-full text-xs {$statusClass}'>{$transaction['status']}</span></td>";
                            
                            // echo "<td class='py-3 px-6 text-center'>
                            //                     <div class='flex item-center justify-center'>
                            //                         <div class='w-4 mr-2 transform hover:text-sky-500 hover:scale-110 cursor-pointer'>
                            //                             <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                            //                                 <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 12a3 3 0 11-6 0 3 3 0 016 0z' />
                            //                                 <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z' />
                            //                             </svg>
                            //                         </div>
                            //                     </div>
                            //                   </td>";
                            // echo "</tr>";
                        }
                    ?>
                </table>
            </div>

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

    <script>
       document.addEventListener("DOMContentLoaded", function() {
            const showButton = document.getElementById("showBtn");
            const closeButton = document.getElementById("closeBtn");
            const modal = document.getElementById("modal");

            showButton.addEventListener("click", () => {
                modal.showModal();
                console.log("clicked");
            });
            closeButton.addEventListener("click", () => {
                modal.close();
            });
        });
    </script>
</body>
</html>