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
          
        <form action="" method="get" style="display: grid; grid-template-columns: 1fr; margin-bottom: 1.25rem;">
            <h1 style="font-size: 1.125rem; font-weight: 600;">Transaction history</h1>
            <div style="display: flex; flex-wrap: wrap; justify-content: flex-end; align-items: center; gap: 0.75rem;">
                <!-- Course Filter -->
                <select name="course" style="margin-top: 0.25rem; height: 2.5rem; padding: 0.25rem 0.5rem; border: 1px solid rgb(209, 213, 219); background-color: rgb(249, 250, 251); border-radius: 0.375rem; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">
                    <option value="">All Courses</option>
                    <option value="BSP" <?php echo isset($_GET['course']) && $_GET['course'] === 'BSP' ? 'selected' : ''; ?>>BSP - BS Psychology</option>
                    <option value="BSIT" <?php echo isset($_GET['course']) && $_GET['course'] === 'BSIT' ? 'selected' : ''; ?>>BSIT - BS Information Technology</option>
                    <option value="BSTM" <?php echo isset($_GET['course']) && $_GET['course'] === 'BSTM' ? 'selected' : ''; ?>>BSTM - BS Tourism Management</option>
                    <option value="BSHM" <?php echo isset($_GET['course']) && $_GET['course'] === 'BSHM' ? 'selected' : ''; ?>>BSHM - BS Hospitality Management</option>
                    <option value="BSOA" <?php echo isset($_GET['course']) && $_GET['course'] === 'BSOA' ? 'selected' : ''; ?>>BSOA - BS Office Administration</option>
                    <option value="BSBA Major in Human Resource Management" <?php echo isset($_GET['course']) && $_GET['course'] === 'BSBA Major in Human Resource Management' ? 'selected' : ''; ?>>BSBA - Major in Human Resource Management</option>
                    <option value="BSBA Major in Marketing" <?php echo isset($_GET['course']) && $_GET['course'] === 'BSBA Major in Marketing' ? 'selected' : ''; ?>>BSBA - Major in Marketing</option>
                    <option value="BSCrim" <?php echo isset($_GET['course']) && $_GET['course'] === 'BSCrim' ? 'selected' : ''; ?>>BSCrim - BS Criminology</option>
                    <option value="BLIS" <?php echo isset($_GET['course']) && $_GET['course'] === 'BLIS' ? 'selected' : ''; ?>>BLIS - Bachelor in Library and Information Science</option>
                    <option value="BEEd" <?php echo isset($_GET['course']) && $_GET['course'] === 'BEEd' ? 'selected' : ''; ?>>BEEd - Bachelor of Elementary Education</option>
                    <option value="BPEd" <?php echo isset($_GET['course']) && $_GET['course'] === 'BPEd' ? 'selected' : ''; ?>>BPEd - Bachelor of Physical Education</option>
                    <option value="BTTE" <?php echo isset($_GET['course']) && $_GET['course'] === 'BTTE' ? 'selected' : ''; ?>>BTTE - Bachelor of Technical Teacher Education</option>
                    <option value="BTLED" <?php echo isset($_GET['course']) && $_GET['course'] === 'BTLED' ? 'selected' : ''; ?>>BTLED - Bachelor of Technology and Livelihood Education</option>
                    <option value="BSEd Major in English" <?php echo isset($_GET['course']) && $_GET['course'] === 'BSEd Major in English' ? 'selected' : ''; ?>>BSEd - Major in English</option>
                    <option value="BSEd Major in Filipino" <?php echo isset($_GET['course']) && $_GET['course'] === 'BSEd Major in Filipino' ? 'selected' : ''; ?>>BSEd - Major in Filipino</option>
                    <option value="BSEd Major in Mathematics" <?php echo isset($_GET['course']) && $_GET['course'] === 'BSEd Major in Mathematics' ? 'selected' : ''; ?>>BSEd - Major in Mathematics</option>
                    <option value="BSEd Major in Social Science" <?php echo isset($_GET['course']) && $_GET['course'] === 'BSEd Major in Social Science' ? 'selected' : ''; ?>>BSEd - Major in Social Science</option>
                    <option value="BSEd Major in Values Education" <?php echo isset($_GET['course']) && $_GET['course'] === 'BSEd Major in Values Education' ? 'selected' : ''; ?>>BSEd - Major in Values Education</option>
                    <option value="BSEd Major in Biological Science" <?php echo isset($_GET['course']) && $_GET['course'] === 'BSEd Major in Biological Science' ? 'selected' : ''; ?>>BSEd - Major in Biological Science</option>
                    <option value="BSCpE" <?php echo isset($_GET['course']) && $_GET['course'] === 'BSCpE' ? 'selected' : ''; ?>>BSCpE - BS Computer Engineering</option>
                    <option value="BSENTREP" <?php echo isset($_GET['course']) && $_GET['course'] === 'BSENTREP' ? 'selected' : ''; ?>>BSENTREP - BS Entrepreneurship</option>
                    <option value="BSAIS" <?php echo isset($_GET['course']) && $_GET['course'] === 'BSAIS' ? 'selected' : ''; ?>>BSAIS - BS Accounting Information Systems</option>
                    <option value="BSAcT" <?php echo isset($_GET['course']) && $_GET['course'] === 'BSAcT' ? 'selected' : ''; ?>>BSAcT - BS Accounting Technology</option>
                </select>

                <!-- Year Level Filter -->
                <select name="year" style="margin-top: 0.25rem; height: 2.5rem; padding: 0.25rem 0.5rem; border: 1px solid rgb(209, 213, 219); background-color: rgb(249, 250, 251); border-radius: 0.375rem; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">
                    <option value="">All Years</option>
                    <option value="1" <?php echo isset($_GET['year']) && $_GET['year'] === '1st Year' ? 'selected' : ''; ?>>1st Year</option>
                    <option value="2" <?php echo isset($_GET['year']) && $_GET['year'] === '2nd Year' ? 'selected' : ''; ?>>2nd Year</option>
                    <option value="3" <?php echo isset($_GET['year']) && $_GET['year'] === '3rd Year' ? 'selected' : ''; ?>>3rd Year</option>
                    <option value="4" <?php echo isset($_GET['year']) && $_GET['year'] === '4th Year' ? 'selected' : ''; ?>>4th Year</option>
                </select>

                <!-- Section Filter -->
                <!-- <select name="section" style="margin-top: 0.25rem; height: 2.5rem; padding: 0.25rem 0.5rem; border: 1px solid rgb(209, 213, 219); background-color: rgb(249, 250, 251); border-radius: 0.375rem; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);">
                    <option value="">All Sections</option>
                    <option value="A" <?php echo isset($_GET['section']) && $_GET['section'] === 'A' ? 'selected' : ''; ?>>Section A</option>
                    <option value="B" <?php echo isset($_GET['section']) && $_GET['section'] === 'B' ? 'selected' : ''; ?>>Section B</option>
                    <option value="C" <?php echo isset($_GET['section']) && $_GET['section'] === 'C' ? 'selected' : ''; ?>>Section C</option>
                </select> -->

                <!-- Search Input -->
                <input 
                    type="text" 
                    placeholder="Search Transaction ID, Student ID, or Section..." 
                    id="search" 
                    name="search" 
                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" 
                    style="margin-top: 0.25rem; height: 2.5rem; padding: 0.25rem 0.5rem; border: 1px solid rgb(209, 213, 219); background-color: rgb(249, 250, 251); border-radius: 0.375rem; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); min-width: 300px;" 
                />
                
                <button type="submit" style="padding: 0.5rem 1rem; background-color: rgb(29, 78, 216); color: white; border-radius: 0.5rem;">
                    Filter
                </button>
            </div>
        </form>
           
            <div class="overflow-x-auto">
                <table class="w-full shadow-lg border-collapse m-h-[50vh]">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-center">Transaction ID</th>
                        <th class="py-3 px-6 text-center">Student ID</th>
                        <th class="py-3 px-6 text-center">Student Name</th>
                        <th class="py-3 px-6 text-center">Course</th>
                        <th class="py-3 px-6 text-center">Year & Section</th>
                        <th class="py-3 px-6 text-center">Amount</th>
                        <th class="py-3 px-6 text-center">Date</th>
                        <th class="py-3 px-6 text-center">Type</th>
                        <th class="py-3 px-6 text-center">Status</th>
                    </tr>
                </thead>

                    <?php  
                        // Mock data for transactions
                        $mockTransactions = [
                            [
                                'transaction_id' => 'T001', 
                                'student_id' => 's21013211', 
                                'student_name' => 'John', 
                                'student_lastname' => 'Doe', 
                                'amount' => '1000',
                                'course' => 'BSIT',
                                'year' => '1st Year',
                                'section' => 'BSIT-1A', 
                                'transaction_type' => 'Cash', 
                                'status' => 'Paid', 
                                'date' => '2023-01-01'
                            ],
                            [
                                'transaction_id' => 'T002', 
                                'student_id' => 's21023145', 
                                'student_name' => 'Maria', 
                                'student_lastname' => 'Santos', 
                                'amount' => '1200',
                                'course' => 'BSP',
                                'year' => '2nd Year',
                                'section' => 'BSP-2A', 
                                'transaction_type' => 'E-Cash', 
                                'status' => 'Paid', 
                                'date' => '2023-01-05'
                            ],
                            [
                                'transaction_id' => 'T003', 
                                'student_id' => 's21045678', 
                                'student_name' => 'Carlos', 
                                'student_lastname' => 'Garcia', 
                                'amount' => '950',
                                'course' => 'BSTM',
                                'year' => '1st Year',
                                'section' => 'BSTM-1B', 
                                'transaction_type' => 'E-Cash', 
                                'status' => 'Paid', 
                                'date' => '2023-01-10'
                            ],
                            [
                                'transaction_id' => 'T004', 
                                'student_id' => 's22012456', 
                                'student_name' => 'Anna', 
                                'student_lastname' => 'Rodriguez', 
                                'amount' => '1500',
                                'course' => 'BSHM',
                                'year' => '3rd Year',
                                'section' => 'BSHM-3A', 
                                'transaction_type' => 'Cash', 
                                'status' => 'Paid', 
                                'date' => '2023-01-12'
                            ],
                            [
                                'transaction_id' => 'T005', 
                                'student_id' => 's21056789', 
                                'student_name' => 'Miguel', 
                                'student_lastname' => 'Reyes', 
                                'amount' => '1100',
                                'course' => 'BSOA',
                                'year' => '1st Year',
                                'section' => 'BSOA-1C', 
                                'transaction_type' => 'Cash', 
                                'status' => 'Pending', 
                                'date' => '2023-01-15'
                            ],
                            [
                                'transaction_id' => 'T006', 
                                'student_id' => 's22034567', 
                                'student_name' => 'Sofia', 
                                'student_lastname' => 'Mendoza', 
                                'amount' => '2000',
                                'course' => 'BSBA Major in Human Resource Management',
                                'year' => '2nd Year',
                                'section' => 'BSBA-2B', 
                                'transaction_type' => 'Cash', 
                                'status' => 'Paid', 
                                'date' => '2023-01-18'
                            ],
                            [
                                'transaction_id' => 'T007', 
                                'student_id' => 's20015623', 
                                'student_name' => 'Rafael', 
                                'student_lastname' => 'Torres', 
                                'amount' => '1300',
                                'course' => 'BSIT',
                                'year' => '4th Year',
                                'section' => 'BSIT-4A', 
                                'transaction_type' => 'E-Cash', 
                                'status' => 'Paid', 
                                'date' => '2023-01-20'
                            ],
                            [
                                'transaction_id' => 'T008', 
                                'student_id' => 's22078912', 
                                'student_name' => 'Elena', 
                                'student_lastname' => 'Cruz', 
                                'amount' => '1800',
                                'course' => 'BSCrim',
                                'year' => '2nd Year',
                                'section' => 'BSCrim-2B', 
                                'transaction_type' => 'Cash', 
                                'status' => 'Paid', 
                                'date' => '2023-01-22'
                            ],
                            [
                                'transaction_id' => 'T009', 
                                'student_id' => 's21098765', 
                                'student_name' => 'Luis', 
                                'student_lastname' => 'Fernandez', 
                                'amount' => '1750',
                                'course' => 'BLIS',
                                'year' => '3rd Year',
                                'section' => 'BLIS-3A', 
                                'transaction_type' => 'Cash', 
                                'status' => 'Paid', 
                                'date' => '2023-01-25'
                            ],
                            [
                                'transaction_id' => 'T010', 
                                'student_id' => 's22056123', 
                                'student_name' => 'Isabella', 
                                'student_lastname' => 'Gonzales', 
                                'amount' => '900',
                                'course' => 'BEEd',
                                'year' => '1st Year',
                                'section' => 'BEEd-1B', 
                                'transaction_type' => 'Cash', 
                                'status' => 'Pending', 
                                'date' => '2023-01-28'
                            ],
                            [
                                'transaction_id' => 'T011', 
                                'student_id' => 's21067890', 
                                'student_name' => 'Antonio', 
                                'student_lastname' => 'Castro', 
                                'amount' => '1400',
                                'course' => 'BPEd',
                                'year' => '2nd Year',
                                'section' => 'BPEd-2A', 
                                'transaction_type' => 'E-Cash', 
                                'status' => 'Paid', 
                                'date' => '2023-02-01'
                            ],
                            [
                                'transaction_id' => 'T012', 
                                'student_id' => 's22023456', 
                                'student_name' => 'Diana', 
                                'student_lastname' => 'Ramos', 
                                'amount' => '1650',
                                'course' => 'BTLED',
                                'year' => '3rd Year',
                                'section' => 'BTLED-3C', 
                                'transaction_type' => 'Cash', 
                                'status' => 'Overdue', 
                                'date' => '2023-02-05'
                            ],
                            [
                                'transaction_id' => 'T013', 
                                'student_id' => 's21045612', 
                                'student_name' => 'Gabriel', 
                                'student_lastname' => 'Aquino', 
                                'amount' => '1250',
                                'course' => 'BSEd Major in Mathematics',
                                'year' => '4th Year',
                                'section' => 'BSEd-4B', 
                                'transaction_type' => 'Cash', 
                                'status' => 'Paid', 
                                'date' => '2023-02-08'
                            ],
                            [
                                'transaction_id' => 'T014', 
                                'student_id' => 's22078945', 
                                'student_name' => 'Patricia', 
                                'student_lastname' => 'Bautista', 
                                'amount' => '2100',
                                'course' => 'BSCpE',
                                'year' => '2nd Year',
                                'section' => 'BSCpE-2A', 
                                'transaction_type' => 'E-Cash', 
                                'status' => 'Paid', 
                                'date' => '2023-02-10'
                            ],
                            [
                                'transaction_id' => 'T015', 
                                'student_id' => 's21013456', 
                                'student_name' => 'Marco', 
                                'student_lastname' => 'Santos', 
                                'amount' => '1050',
                                'course' => 'BSENTREP',
                                'year' => '1st Year',
                                'section' => 'BSENTREP-1A', 
                                'transaction_type' => 'Cash', 
                                'status' => 'Pending', 
                                'date' => '2023-02-15'
                            ]
                        ];

                        // Pagination logic
                        $perPage = 10;
                        $totalTransactions = count($mockTransactions);
                        $totalPages = ceil($totalTransactions / $perPage);
                        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $start = ($currentPage - 1) * $perPage;
                        $transactions = array_slice($mockTransactions, $start, $perPage);

                        if(isset($_GET['search']) || isset($_GET['course']) || isset($_GET['year'])) {
                            $filter = $_GET['search'] ?? '';
                            $courseFilter = $_GET['course'] ?? '';
                            $yearFilter = $_GET['year'] ?? '';
                        
                            $transactions = array_filter($mockTransactions, function($transaction) use ($filter, $courseFilter, $yearFilter) {
                                // Combined search filter for transaction_id, student_id, and section
                                $matchesSearch = empty($filter) || 
                                    stripos($transaction['transaction_id'], $filter) !== false || 
                                    stripos($transaction['student_id'], $filter) !== false ||
                                    stripos($transaction['section'], $filter) !== false;
                                
                                // Course filter    
                                $matchesCourse = empty($courseFilter) || $transaction['course'] === $courseFilter;
                                
                                // Year filter
                                $matchesYear = empty($yearFilter) || strpos($transaction['year'], $yearFilter) === 0;
                                
                                return $matchesSearch && $matchesCourse && $matchesYear;
                            });
                        } else {
                            $transactions = array_slice($mockTransactions, $start, $perPage);
                        }

                        foreach ($transactions as $transaction) {
                            echo "<tr class='border-b border-gray-200 hover:bg-gray-100'>";
                            echo "<td class='py-3 px-6 text-center whitespace-nowrap'>{$transaction['transaction_id']}</td>";
                            echo "<td class='py-3 px-6 text-center'>{$transaction['student_id']}</td>";
                            echo "<td class='py-3 px-6 text-center'>{$transaction['student_name']} {$transaction['student_lastname']}</td>";
                            echo "<td class='py-3 px-6 text-center'>{$transaction['course']}</td>";
                            echo "<td class='py-3 px-6 text-center'>{$transaction['section']}</td>";
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