<?php

    require_once "../config_session.php";
    if(!isset($_SESSION['user_id'])){
        header("Location: ../../index.php");
        die();
    }

    require_once "../Models/transactions_model.php";
    require_once "../Views/transactions_view.php";
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
                        <th class="py-3 px-6 text-left">Transaction ID</th>
                        <th class="py-3 px-6 text-center">Student ID</th>
                        <th class="py-3 px-6 text-center">Student Name</th>
                        <th class="py-3 px-6 text-center">Amount</th>
                        <th class="py-3 px-6 text-center">Type</th>
                        <th class="py-3 px-6 text-center">Status</th>
                        <th class="py-3 px-6 text-center">Date</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                    </thead>

                    <?php  
                        // Mock data for transactions
                        $mockTransactions = [
                            ['transaction_id' => 'T001', 'student_id' => 'S001', 'student_name' => 'John', 'student_lastname' => 'Doe', 'amount' => '1000', 'transaction_type' => 'Cash', 'status' => 'Paid', 'date' => '2023-01-01'],
                            ['transaction_id' => 'T002', 'student_id' => 'S002', 'student_name' => 'Jane', 'student_lastname' => 'Smith', 'amount' => '500', 'transaction_type' => 'Debit', 'status' => 'Partially Paid', 'date' => '2023-01-02'],
                            ['transaction_id' => 'T003', 'student_id' => 'S003', 'student_name' => 'Alice', 'student_lastname' => 'Johnson', 'amount' => '1500', 'transaction_type' => 'Cash', 'status' => 'Overdue', 'date' => '2023-01-03'],
                            ['transaction_id' => 'T004', 'student_id' => 'S004', 'student_name' => 'Bob', 'student_lastname' => 'Brown', 'amount' => '2000', 'transaction_type' => 'Debit', 'status' => 'Paid', 'date' => '2023-01-04'],
                            ['transaction_id' => 'T005', 'student_id' => 'S005', 'student_name' => 'Charlie', 'student_lastname' => 'Davis', 'amount' => '2500', 'transaction_type' => 'Cash', 'status' => 'Partially Paid', 'date' => '2023-01-05'],
                        ];

                        if(isset($_GET['search'])){
                            $filter = $_GET['search'];
                            $transactions = array_filter($mockTransactions, function($transaction) use ($filter) {
                                return strpos($transaction['transaction_id'], $filter) !== false || strpos($transaction['student_id'], $filter) !== false;
                            });
                        } else {
                            $transactions = $mockTransactions;
                        }

                        foreach ($transactions as $transaction) {
                            echo "<tr class='border-b border-gray-200 hover:bg-gray-100'>";
                            echo "<td class='py-3 px-6 text-center whitespace-nowrap'>{$transaction['transaction_id']}</td>";
                            echo "<td class='py-3 px-6 text-center'>{$transaction['student_id']}</td>";
                            echo "<td class='py-3 px-6 text-center'>{$transaction['student_name']} {$transaction['student_lastname']}</td>";
                            echo "<td class='py-3 px-6 text-center'>PHP" . number_format($transaction['amount'], 2) . "</td>";
                            echo "<td class='py-3 px-6 text-center'><span class='bg-" . ($transaction['transaction_type'] == 'Cash' ? 'green' : 'red') . "-200 text-" . ($transaction['transaction_type'] == 'Cash' ? 'green' : 'red') . "-600 py-1 px-3 rounded-full text-xs'>{$transaction['transaction_type']}</span></td>";
                            echo "<td class='py-3 px-6 text-center'>{$transaction['status']}</td>";
                            echo "<td class='py-3 px-6 text-center'>{$transaction['date']}</td>";
                            echo "<td class='py-3 px-6 text-center'>
                                                <div class='flex item-center justify-center'>
                                                    <div class='w-4 mr-2 transform hover:text-sky-500 hover:scale-110 cursor-pointer'>
                                                        <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                                                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 12a3 3 0 11-6 0 3 3 0 016 0z' />
                                                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z' />
                                                        </svg>
                                                    </div>
                                                    <div class='w-4 mr-2 transform hover:text-sky-500 hover:scale-110 cursor-pointer'>
                                                        <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                                                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z' />
                                                        </svg>
                                                    </div>
                                                    <div class='w-4 mr-2 transform hover:text-sky-500 hover:scale-110 cursor-pointer'>
                                                        <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                                                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16' />
                                                        </svg>
                                                    </div>
                                                </div>
                                              </td>";
                            echo "</tr>";
                        }
                    ?>
                </table>
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