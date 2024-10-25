<?php

    require_once "../config_session.php";
    if(!isset($_SESSION['user_id'])){
        header("Location: ../../index.php");
        die();
    }
    require_once "../dbh.php";
    require_once "../Controllers/student_controller.php";
    require_once "../Views/transactions_view.php";
    $user_id = $_SESSION['user_id'];
    $student = getStudentInfo($pdo, $user_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Ledger</title>
    <link href="../../output.css" rel="stylesheet" >
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body class="bg-gray-100 min-h-[80vh] flex flex-col justify-between">
    <?php 
        $imageSrc =  '../../public/assets/images/bcp_logo.png';
        include('../../public/templates/header.php');
       
    ?>

    <div class="flex h-screen pt-20">
            <!-- sidebar -->
            <?php include('../../public/templates/student_sidebar.php');?>

            <main class="flex-1 p-8 overflow-y-auto space-y-5">
               
                <!-- Personal Info -->
                <div class="bg-white rounded-lg shadow p-4 sm:p-6 relative w-full flex gap-x-5">
                    <svg enable-background="new -27 24 100 100" height="100px" id="male3" version="1.1" viewBox="-27 24 100 100" width="100px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" xmlns:xlink="http://www.w3.org/1999/xlink"><g><g><circle cx="23" cy="74" fill="#F5EEE5" r="50"/><g><defs><circle cx="23" cy="74" id="SVGID_1_" r="50"/></defs><clipPath id="SVGID_2_"><use overflow="visible" xlink:href="#SVGID_1_"/></clipPath><path clip-path="url(#SVGID_2_)" d="M38,99.9l27.9,7.7c3.2,1.1,5.7,3.5,7.1,6.6v9.8H-27v-9.8      c1.3-3.1,3.9-5.5,7.1-6.6L8,99.9V85h30V99.9z" fill="#E6C19C"/><g clip-path="url(#SVGID_2_)"><defs><path d="M38,99.9l27.9,7.7c3.2,1.1,5.7,3.5,7.1,6.6v9.8H-27v-9.8c1.3-3.1,3.9-5.5,7.1-6.6L8,99.9V85h30V99.9z" id="SVGID_3_"/></defs><clipPath id="SVGID_4_"><use overflow="visible" xlink:href="#SVGID_3_"/></clipPath><path clip-path="url(#SVGID_4_)" d="M-27,82H73v42H-27V82z M23,112c11,0,20-6.3,20-14s-9-14-20-14S3,90.3,3,98       S12,112,23,112z" fill="#E6A422"/><path clip-path="url(#SVGID_4_)" d="M23,102c-1.7,0-3.9-0.4-5.4-1.1c-1.7-0.9-8-6.1-10.2-8.3       c-2.8-3-4.2-6.8-4.6-13.3c-0.4-6.5-2.1-29.7-2.1-35c0-7.5,5.7-19.2,22.1-19.2l0.1,0l0,0l0,0l0.1,0       c16.5,0.1,22.1,11.7,22.1,19.2c0,5.3-1.7,28.5-2.1,35c-0.4,6.5-1.8,10.2-4.6,13.3c-2.1,2.3-8.4,7.4-10.2,8.3       C26.9,101.6,24.7,102,23,102L23,102z" fill="#D4B08C"/><path clip-path="url(#SVGID_4_)" d="M23,82C10.3,82,0,89.4,0,98.5S10.3,115,23,115s23-7.4,23-16.5       S35.7,82,23,82z M23,111c-10.5,0-19-6-19-13.5S12.5,84,23,84s19,6,19,13.5S33.5,111,23,111z" fill="#D98C21"/></g></g><path d="M23,98c-1.5,0-3.5-0.3-4.8-0.9c-1.6-0.7-7.2-4.6-9.1-6.3c-2.5-2.3-3.8-5.1-4.2-10S3,58.5,3,54.5     C3,48.8,8.1,40,23,40l0,0l0,0l0,0l0,0C37.9,40,43,48.8,43,54.5c0,4-1.5,21.5-1.9,26.4s-1.6,7.7-4.2,10c-1.9,1.7-7.6,5.6-9.1,6.3     C26.5,97.7,24.5,98,23,98L23,98z" fill="#F2CEA5"/><path d="M30,85.5c-1.9,2-5.2,3-8.1,2.4c-2.7-0.6-4.7-2-5.7-4.3L30,85.5z" fill="#A3705F"/><path d="M30,85.5c-1.9,2-5.2,3-8.1,2.4     c-2.7-0.6-4.7-2-5.7-4.3L30,85.5z" fill="none" stroke="#A3705F" stroke-linecap="round" stroke-linejoin="round"/><g><defs><rect height="5" id="SVGID_5_" width="31" x="7" y="65"/></defs><clipPath id="SVGID_6_"><use overflow="visible" xlink:href="#SVGID_5_"/></clipPath><circle clip-path="url(#SVGID_6_)" cx="32" cy="69" fill="#291F21" r="2"/><circle clip-path="url(#SVGID_6_)" cx="14" cy="69" fill="#291F21" r="2"/></g><path d="M8,66c0,0,1.1-3,6.1-3c3.4,0,5.4,1.5,6.4,3" fill="none" stroke="#CC9872" stroke-width="2"/><path d="M38.1,66c0,0-1.1-3-6.1-3c-4.8,0-7,3-7,5c0,1.9,0,9,0,9" fill="none" stroke="#BB8660" stroke-width="2"/><path d="M41.8,72.2c0,0,0.8-6.3,3.7-7.2c0.4-1.8,1.5-7,1.5-9.9s-0.3-5.7-1.9-8.1c-1.8-2.6-5.6-4.1-7.6-4.1     c-2.3,1.4-7.7,4.6-9.4,6.5c-0.9,1,0.4,1.8,0.4,1.8s1.2-0.5,1.7-0.6c2.5-0.7,8-1.2,9.7,1.3C42,54.9,42,63.7,42,65     C42,66.2,41.8,72.2,41.8,72.2z" fill="#452228"/><path d="M0.5,65c2.9,1,3.7,7.2,3.7,7.2S4,66.2,4,65c0-1.6,0.2-9.1,3.4-12.7c3.6-4,8.4-5.3,11.1-3.5     c1.4,0.9,6.1,5.5,11.1,1.7c3-2.3,8.5-7.5,8.5-7.5s-2.9-8.9-16.1-7.9c-5.6,0.5-11.8-0.9-11.8-0.9s-0.1,2.5,0.9,3.8     C2.8,40.4,0.1,46.4-0.7,51c-0.2,0.9-0.3,1.8-0.3,2.7c0,0.5,0,1,0,1.4C-1,58,0.1,63.1,0.5,65z" fill="#6B363E"/></g></g></svg>
                    <div class="w-full">
                        <h3 class="text-xl font-semibold text-blue-800 mb-4">Personal Information</h3>
                        <?php if ($student): ?>
                            <div class="grid grid-cols-1  sm:grid-cols-2 gap-x-4 justify-between  ">
                                <p><strong class="font-medium">Name:</strong> <span class="block sm:inline"><?php echo htmlspecialchars($student['first_name'] ?? '') . ' ' . htmlspecialchars($student['last_name'] ?? ''); ?></span></p>
                                <p><strong class="font-medium">Student ID:</strong> <span class="block sm:inline"><?php echo htmlspecialchars($student['user_id'] ?? ''); ?></span></p>
                                <p><strong class="font-medium">Email:</strong> <span class="block sm:inline"><?php echo htmlspecialchars($student['email'] ?? ''); ?></span></p>
                                <p><strong class="font-medium">Phone:</strong> <span class="block sm:inline"><?php echo htmlspecialchars($student['phone_number'] ?? ''); ?></span></p>
                                <p><strong class="font-medium">Date of Birth:</strong> <span class="block sm:inline"><?php echo htmlspecialchars($student['date_of_birth'] ?? ''); ?></span></p>
                                <p><strong class="font-medium">Gender:</strong> <span class="block sm:inline"><?php echo htmlspecialchars($student['gender'] ?? ''); ?></span></p>
                                <p><strong class="font-medium">Address:</strong> <span class="block sm:inline"><?php echo htmlspecialchars($student['address'] ?? ''); ?></span></p>
                                <p><strong class="font-medium">Enrollment Date:</strong> <span class="block sm:inline"><?php echo htmlspecialchars($student['enrollment_date'] ?? ''); ?></span></p>
                                <p><strong class="font-medium">Status:</strong> <span class="block sm:inline"><?php echo htmlspecialchars($student['status'] ?? ''); ?></span></p>
                            </div>
                        <?php else: ?>
                            <p>No student information available.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-blue-800 mb-4">Financial Transactions</h3>
                    <div class="flex justify-end gap-x-5">
                        <div class="mb-4">
                            <select class="bg-white border border-gray-300 rounded px-3 py-1">

                                <option value="Current">Current S.Y.</option>
                                <!-- fetct all SY that the student are enrolled. Display as SY 2023-2024 -->
                                <option value="Current">S.Y. 2024-2025</option>
                                <option value="Current">S.Y. 2023-2024</option>
                                <option value="Current">All S.Y.</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <select class="bg-white  border border-gray-300 rounded px-3 py-1">
                                <option value="Current">1st semester</option>
                                <option value="Current">2nd semester</option>
                                <option value="Current">3rd semester</option>
                                <option value="Current">All semester</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Transactions -->
                <div class="bg-white rounded-lg shadow p-4 sm:p-6 ">
                    <h3 class="text-xl font-semibold text-blue-800 mb-4">Account Ledger</h3>
                    <table class="w-full">
                        <thead>
                            <tr class="bg-blue-100">
                                <th class="py-2 px-4 text-left">Date</th>
                                <th class="py-2 px-4 text-left">Due Date</th>
                                <th class="py-2 px-4 text-left">Fee</th>
                                <th class="py-2 px-4 text-left">Amount</th>
                                <th class="py-2 px-4 text-left">Total Amount Paid</th>
                                <th class="py-2 px-4 text-left">Remaining Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Sample data
                            $mockTransactions = [
                                ['date' => '2023-05-01','due_date' => '2023-06-01','fee' => 'Tuition Fee','amount' => 25000,'total_amount_paid' => 25000,'balance' => 0],
                                ['date' => '2023-05-02','due_date' => '2023-06-02','fee' => 'Library Fee','amount' => 5000,'total_amount_paid' => 0,'balance' => 5000],
                                ['date' => '2023-05-10','due_date' => '2023-06-10','fee' => 'Library Fee','amount' => 5000,'total_amount_paid' => 5000,'balance' => 0],
                                ['date' => '2023-05-15','due_date' => '2023-06-15','fee' => 'Uniform Fee','amount' => 10000,'total_amount_paid' => 0,'balance' => 10000],
                                ['date' => '2023-05-20','due_date' => '2023-06-20','fee' => 'Uniform Fee','amount' => 10000,'total_amount_paid' => 10000,'balance' => 0],
                                ['date' => '2023-06-01','due_date' => '2023-07-01','fee' => 'Tuition Fee','amount' => 30000,'total_amount_paid' => 0,'balance' => 30000]
                            ];
                            
                            $perPage = 10;
                            $totalTransactions = count($mockTransactions);
                            $totalPages = ceil($totalTransactions / $perPage);
                            $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                            $start = ($currentPage - 1) * $perPage;
                            $transactions = array_slice($mockTransactions, $start, $perPage);

                            foreach ($transactions as $index => $transaction):
                            ?>
                            <tr class="<?php echo $index % 2 == 0 ? 'bg-gray-50' : 'bg-white'; ?>">
                                <td class="py-2 px-4"><?php echo $transaction['date']; ?></td>
                                <td class="py-2 px-4"><?php echo $transaction['due_date']; ?></td>
                                <td class="py-2 px-4"><?php echo $transaction['fee']; ?></td>
                                <td class="py-2 px-4">₱<?php echo number_format($transaction['amount']); ?></td>
                                <td class="py-2 px-4">₱<?php echo number_format($transaction['total_amount_paid']); ?></td>
                                <td class="py-2 px-4">₱<?php echo number_format($transaction['balance']); ?></td>
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
                                $mockPayments = [
                                    ['date' => '2023-05-01', 'fee' => 'Tuition Fee', 'amount' => 25000, 'status' => 'On-Time'],
                                    ['date' => '2023-05-02', 'fee' => 'Tuition Fee', 'amount' => 50000, 'status' => 'On-Time'],
                                    ['date' => '2023-05-03', 'fee' => 'Tuition Fee', 'amount' => 37500, 'status' => 'On-Time'],
                                    ['date' => '2023-05-04', 'fee' => 'Tuition Fee', 'amount' => 12500, 'status' => 'Late'], // Example of late payment
                                    ['date' => '2023-05-05', 'fee' => 'Tuition Fee', 'amount' => 50000, 'status' => 'On-Time'],
                                ];

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
                                    <td class="py-2 px-4"><?php echo $payments['fee']; ?></td>
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
                                $mockCharges = [
                                    ['date' => '2023-05-01', 'fee' => 'Tuition Fee', 'amount' => 25000, 'due_date' => '2023-06-01'],
                                    ['date' => '2023-05-02', 'fee' => 'Tuition Fee', 'amount' => 50000, 'due_date' => '2023-06-02'],
                                    ['date' => '2023-05-03', 'fee' => 'Tuition Fee', 'amount' => 37500, 'due_date' => '2023-06-03'],
                                    ['date' => '2023-05-04', 'fee' => 'Tuition Fee', 'amount' => 12500, 'due_date' => '2023-06-04'],
                                    ['date' => '2023-05-05', 'fee' => 'Tuition Fee', 'amount' => 50000, 'due_date' => '2023-06-05'],
                                ];
                                $perPage = 5;
                                $totalCharges = count($mockCharges);
                                $totalPages = ceil($totalCharges / $perPage);
                                $currentPage = isset($_GET['chargesPage']) ? (int)$_GET['chargesPage'] : 1;
                                $start = ($currentPage - 1) * $perPage;
                                $charges = array_slice($mockCharges, $start, $perPage);
                                foreach ($charges as $index => $charges):
                                ?>
                                <tr class="<?php echo $index % 2 == 0 ? 'bg-gray-50' : 'bg-white'; ?>">
                                    <td class="py-2 px-4"><?php echo $charges['date']; ?></td>
                                    <td class="py-2 px-4"><?php echo $charges['fee']; ?></td>
                                    <td class="py-2 px-4"><?php echo $charges['due_date']; ?></td>
                                    <td class="py-2 px-4">₱<?php echo number_format($charges['amount']); ?></td>
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
                </div>
            </main>
    </div>
</body>
</html>