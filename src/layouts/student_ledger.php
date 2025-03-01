<?php

    require_once "../config_session.php";
    if(!isset($_SESSION['user_id'])){
        header("Location: ../../index.php");
        die();
    }
    require_once "../dbh.php";
    require_once "../Controllers/student_controller.php";
    
    require_once '../Models/transactions_model.php';
    require_once '../Models/payment_model.php';
    require_once '../Controllers/transaction_controller.php';
    require_once "../Views/transactions_view.php";
    require_once "../Views/ledger_view.php";
    
    $user_id = $_SESSION['user_id'];
    $student = getStudentInfo($pdo, $user_id);
    $transactions = fetchTransactions($pdo, $student['username']);
    $schoolYears = array_column($transactions, 'school_year');
    $uniqueSchoolYears = array_unique($schoolYears);

    $payments = fetchPayments($pdo, $student['username']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Ledger</title>
    <link href="../../output.css" rel="stylesheet">
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
                    <svg enable-background="new -27 24 100 100" height="100px" id="male3" version="1.1" viewBox="-27 24 100 100" width="100px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" xmlns:xlink="http://www.w3.org/1999/xlink"><g><g><circle cx="23" cy="74" fill="#F5EEE5" r="50"/><g><defs><circle cx="23" cy="74" id="SVGID_1_" r="50"/></defs><clipPath id="SVGID_2_"><use overflow="visible" xlink:href="#SVGID_1_"/></clipPath><path clip-path="url(#SVGID_2_)" d="M38,99.9l27.9,7.7c3.2,1.1,5.7,3.5,7.1,6.6v9.8H-27v-9.8      c1.3-3.1,3.9-5.5,7.1-6.6L8,99.9V85h30V99.9z" fill="#E6C19C"/><g clip-path="url(#SVGID_2_)"><defs><path d="M38,99.9l27.9,7.7c3.2,1.1,5.7,3.5,7.1,6.6v9.8H-27v-9.8c1.3-3.1,3.9-5.5,7.1-6.6L8,99.9V85h30V99.9z" id="SVGID_3_"/></defs><clipPath id="SVGID_4_"><use overflow="visible" xlink:href="#SVGID_3_"/></clipPath><path clip-path="url(#SVGID_4_)" d="M-27,82H73v42H-27V82z M23,112c11,0,20-6.3,20-14s-9-14-20-14S3,90.3,3,98       S12,112,23,112z" fill="#E6A422"/><path clip-path="url(#SVGID_4_)" d="M23,102c-1.7,0-3.9-0.4-5.4-1.1c-1.7-0.9-8-6.1-10.2-8.3       c-2.8-3-4.2-6.8-4.6-13.3c-0.4-6.5-2.1-29.7-2.1-35c0-7.5,5.7-19.2,22.1-19.2l0.1,0l0,0l0,0l0.1,0       c16.5,0.1,22.1,11.7,22.1,19.2c0,5.3-1.7,28.5-2.1,35c-0.4,6.5-1.8,10.2-4.6,13.3c-2.1,2.3-8.4,7.4-10.2,8.3       C26.9,101.6,24.7,102,23,102L23,102z" fill="#D4B08C"/><path clip-path="url(#SVGID_4_)" d="M23,82C10.3,82,0,89.4,0,98.5S10.3,115,23,115s23-7.4,23-16.5       S35.7,82,23,82z M23,111c-10.5,0-19-6-19-13.5S12.5,84,23,84s19,6,19,13.5S33.5,111,23,111z" fill="#D98C21"/></g></g></svg>
                    <div class="w-full">
                        <h3 class="text-xl font-semibold text-blue-800 mb-4">Personal Information</h3>
                        <?php if ($student): ?>
                            <div class="grid grid-cols-1  sm:grid-cols-2 gap-x-4 justify-between  ">
                                <p><strong class="font-medium">Name:</strong> <span class="block sm:inline"><?php echo htmlspecialchars($student['first_name'] ?? '') . ' ' . htmlspecialchars($student['last_name'] ?? ''); ?></span></p>
                                <p><strong class="font-medium">Student ID:</strong> <span class="block sm:inline"><?php echo htmlspecialchars($student['username'] ?? ''); ?></span></p>
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
                           
                        <form method="GET" action="">
                            <select name="schoolYear" onchange="filterTransactions()"
                                class="bg-white border border-gray-300 rounded px-3 py-1">
                                <?php foreach ($uniqueSchoolYears as $schoolYear): ?>
                                <option value="<?php echo $schoolYear; ?>" <?php if(isset($_GET['schoolYear']) && $_GET['schoolYear'] == $schoolYear) echo 'selected'; ?>>
                                    <?php echo 'SY ' . $schoolYear; ?>
                                </option>
                                <?php endforeach; ?>
                                <option value="All" <?php if(isset($_GET['schoolYear']) && $_GET['schoolYear'] == 'All') echo 'selected'; ?>>All S.Y.</option>
                            </select>

                            <label for="semester">Semester :</label>
                            <select name="semester" onchange="filterTransactions()" class="bg-white border border-gray-300 rounded px-3 py-1">
                                <option value="1st" <?php if(isset($_GET['semester']) && $_GET['semester'] == '1st') echo 'selected'; ?>>1st semester</option>
                                <option value="2nd" <?php if(isset($_GET['semester']) && $_GET['semester'] == '2nd') echo 'selected'; ?>>2nd semester</option>
                                <option value="3rd" <?php if(isset($_GET['semester']) && $_GET['semester'] == '3rd') echo 'selected'; ?>>3rd semester</option>
                                <option value="All" <?php if(isset($_GET['semester']) && $_GET['semester'] == 'All') echo 'selected'; ?>>All semester</option>
                            </select>
                        </form>
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
                            $mockTransactions = $transactions;
                            $selectedSchoolYear = isset($_GET['schoolYear']) ? $_GET['schoolYear'] : 'All';
                            $selectedSemester = isset($_GET['semester']) ? $_GET['semester'] : 'All';

                            $filteredTransactions = array_filter($mockTransactions, function($transaction) use ($selectedSchoolYear, $selectedSemester) {
                                return ($selectedSchoolYear == 'All' || $transaction['school_year'] == $selectedSchoolYear) &&
                                       ($selectedSemester == 'All' || $transaction['semester'] == $selectedSemester);
                            });

                            $perPage = 10;
                            $totalTransactions = count($filteredTransactions);
                            $totalPages = ceil($totalTransactions / $perPage);
                            $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                            $start = ($currentPage - 1) * $perPage;
                            $transactions = array_slice($filteredTransactions, $start, $perPage);

                            if (empty($transactions)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4">No transactions to display.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($transactions as $index => $transaction): ?>
                                <tr class="<?php echo $index % 2 == 0 ? 'bg-gray-50' : 'bg-white'; ?>">
                                    <td class="py-2 px-4"><?php echo htmlspecialchars($transaction['date']); ?></td>
                                    <td class="py-2 px-4"><?php echo htmlspecialchars($transaction['due_date']); ?></td>
                                    <td class="py-2 px-4"><?php echo htmlspecialchars($transaction['description']); ?></td>
                                    <td class="py-2 px-4">₱<?php echo number_format((float)$transaction['amount']); ?></td>
                                    <td class="py-2 px-4">₱<?php echo number_format((float)$transaction['paid']); ?></td>
                                    <td class="py-2 px-4">₱<?php echo number_format((float)$transaction['balance']); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
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
              
            </main>
    </div>
    <script>
            function filterTransactions() {
            const schoolYear = document.querySelector('[name="schoolYear"]').value;
            const semester = document.querySelector('[name="semester"]').value;

            // Reload the page with selected filters
            window.location.href = `?schoolYear=${schoolYear}&semester=${semester}`;
        }
    </script>
</body>
</html>