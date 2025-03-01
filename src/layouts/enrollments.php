<?php

    require_once "../config_session.php";
    require_once "../dbh.php";
    if(!isset($_SESSION['user_id'])){
        header("Location: ../../index.php");
        die();
    }

    require_once "../Models/enrollments_model.php";
    require_once "../Models/enrollments_model.php";
    require_once "../Views/enrollments_view.php";

    require_once "../enrollments.php";
    require_once "../Models/student_model.php"; // Ensure this is included
    require_once "../Controllers/student_controller.php";

    // Initialize variables
    $filter = isset($_GET['search']) ? $_GET['search'] : null;
    $page_no = isset($_GET['page_no']) ? (int)$_GET['page_no'] : 1;
    $total_records_per_page = 10;
    $offset = ($page_no - 1) * $total_records_per_page;
    $isArchived = false; // Initialize $isArchived variable

    // Calculate total number of pages
    $total_count = getTotalCount($pdo, $filter, $isArchived);
    $total_number_of_pages = ceil($total_count / $total_records_per_page);

    $prev_page = $page_no > 1 ? $page_no - 1 : 1;
    $next_page = $page_no < $total_number_of_pages ? $page_no + 1 : $total_number_of_pages;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollments</title>
    <link href="../../output.css" rel="stylesheet" >
    <link rel="stylesheet" href="../../public/css/styles.css">
    <script src="../../public/js/tabs.js" defer></script>
</head>
<body class="bg-gray-100 min-h-[80vh] flex flex-col justify-between">
     <!-- Navigation bar -->
    <?php 
        $imageSrc =  '../../public/assets/images/bcp_logo.png';
        include('../../public/templates/header.php');
       
    ?>
    <div 
        style="display: flex; height: 100vh; padding-top: 70px;"
    >
         <!-- sidebar -->
        <?php include('../../public/templates/sidebar.php');?>

        <!-- Student page -->
        <div class="bg-white m-2 lg:m-5 w-full p-3">
            <!-- Tabs -->
            <div class="flex mb-5">
                <button class="tab active px-2 py-1 lg:px-4 lg:py-2 bg-blue-500 text-white rounded-t-lg text-sm lg:text-base">Active Students</button>
                <button class="tab px-2 py-1 lg:px-4 lg:py-2 bg-gray-200 text-gray-700 rounded-t-lg text-sm lg:text-base">Archived Students</button>
            </div>

            <form action="" method="get" class="grid grid-cols-1 lg:grid-cols-12 items-center mb-5">
                <h1 class="text-lg font-semibold col-span-1 lg:col-span-9 mb-2 lg:mb-0">Student lists</h1>
                <div class="flex flex-col lg:flex-row justify-end items-center gap-y-2 lg:gap-x-5 col-span-1 lg:col-span-3">
                    <!-- Course Filter -->
                    <select name="course" class="w-full lg:w-auto mt-1 block h-10 py-1 px-2 border bg-gray-50 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500">
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
                    <input type="text" placeholder="Search name, id, email" id="search" name="search" value="<?php if(isset($_GET['search'])){echo $_GET['search'];} ?>" class="w-full lg:w-auto mt-1 block h-10 py-1 px-2 border bg-gray-50 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500 p-2" />
                    <button type="submit" class='w-full lg:w-auto px-2 py-1 bg-blue-700 rounded-lg text-white hover:bg-blue-500'>Search</button>
                </div>
            </form>

            <!-- Active Students -->
            <div class="tab-content overflow-x-auto">
                <?php
                    $students = getStudents($pdo, false, $filter, $offset, $total_records_per_page);
                    if ($students) {
                        echo '<table class="w-full shadow-lg border-collapse m-h-[50vh]">';
                        echo '<thead><tr class="bg-gray-200 text-gray-600 uppercase text-xs lg:text-sm leading-normal">';
                        echo '<th class="py-2 px-3 lg:py-3 lg:px-6 text-center">Student ID</th>';
                        echo '<th class="py-2 px-3 lg:py-3 lg:px-6 text-center">Full Name</th>';
                        echo '<th class="py-2 px-3 lg:py-3 lg:px-6 text-center hidden lg:table-cell">Email</th>';
                        echo '<th class="py-2 px-3 lg:py-3 lg:px-6 text-center hidden lg:table-cell">Course</th>';
                        // echo '<th class="py-2 px-3 lg:py-3 lg:px-6 text-center hidden lg:table-cell">Phone No.</th>';
                        // echo '<th class="py-2 px-3 lg:py-3 lg:px-6 text-center hidden lg:table-cell">Enrollment Date</th>';
                        echo '<th class="py-2 px-3 lg:py-3 lg:px-6 text-center">Status</th>';
                        echo '<th class="py-2 px-3 lg:py-3 lg:px-6 text-center">Actions</th>';
                        echo '</tr></thead><tbody>';
                        displayStudents($students);
                        echo '</tbody></table>';
                    } else {
                        echo 'No active students found!';
                    }
                ?>
                <!-- Pagination -->
                <div class="flex justify-center mt-4 space-x-1">
                    <?php if ($page_no > 1): ?>
                        <a href="?page_no=<?php echo $prev_page; ?>&course=<?php echo isset($_GET['course']) ? $_GET['course'] : ''; ?>&search=<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" class="px-2 py-1 lg:px-3 lg:py-1 bg-gray-200 text-gray-700 rounded-lg hover:bg-blue-500 hover:text-white text-sm lg:text-base">Prev</a>
                    <?php endif; ?>

                    <?php for ($counter = 1; $counter <= $total_number_of_pages; $counter++): ?>
                        <a href="?page_no=<?php echo $counter; ?>&course=<?php echo isset($_GET['course']) ? $_GET['course'] : ''; ?>&search=<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" class="px-2 py-1 lg:px-3 lg:py-1 <?php echo $counter == $page_no ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700'; ?> rounded-lg hover:bg-blue-500 hover:text-white text-sm lg:text-base"><?php echo $counter; ?></a>
                    <?php endfor; ?>

                    <?php if ($page_no < $total_number_of_pages): ?>
                        <a href="?page_no=<?php echo $next_page; ?>&course=<?php echo isset($_GET['course']) ? $_GET['course'] : ''; ?>&search=<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" class="px-2 py-1 lg:px-3 lg:py-1 bg-gray-200 text-gray-700 rounded-lg hover:bg-blue-500 hover:text-white text-sm lg:text-base">Next</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Archived Students -->
            <div class="tab-content hidden overflow-x-auto">
                <?php
                    $students = getStudents($pdo, true, $filter, $offset, $total_records_per_page);
                    if ($students) {
                        echo '<table class="w-full shadow-lg border-collapse m-h-[50vh]">';
                        echo '<thead><tr class="bg-gray-200 text-gray-600 uppercase text-xs lg:text-sm leading-normal">';
                        echo '<th class="py-2 px-3 lg:py-3 lg:px-6 text-center">Student ID</th>';
                        echo '<th class="py-2 px-3 lg:py-3 lg:px-6 text-center">Full Name</th>';
                        echo '<th class="py-2 px-3 lg:py-3 lg:px-6 text-center hidden lg:table-cell">Email</th>';
                        echo '<th class="py-2 px-3 lg:py-3 lg:px-6 text-center hidden lg:table-cell">Course</th>';
                        // echo '<th class="py-2 px-3 lg:py-3 lg:px-6 text-center hidden lg:table-cell">Phone No.</th>';
                        // echo '<th class="py-2 px-3 lg:py-3 lg:px-6 text-center hidden lg:table-cell">Enrollment Date</th>';
                        echo '<th class="py-2 px-3 lg:py-3 lg:px-6 text-center">Status</th>';
                        echo '<th class="py-2 px-3 lg:py-3 lg:px-6 text-center">Actions</th>';
                        echo '</tr></thead><tbody>';
                        displayStudents($students);
                        echo '</tbody></table>';
                    } else {
                        echo 'No archived students found!';
                    }
                ?>
                <!-- Pagination -->
                <div class="flex justify-center mt-4 space-x-1">
                    <?php if ($page_no > 1): ?>
                        <a href="?page_no=<?php echo $prev_page; ?>" class="px-2 py-1 lg:px-3 lg:py-1 bg-gray-200 text-gray-700 rounded-lg hover:bg-blue-500 hover:text-white text-sm lg:text-base">Prev</a>
                    <?php endif; ?>

                    <?php for ($counter = 1; $counter <= $total_number_of_pages; $counter++): ?>
                        <a href="?page_no=<?php echo $counter; ?>" class="px-2 py-1 lg:px-3 lg:py-1 <?php echo $counter == $page_no ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700'; ?> rounded-lg hover:bg-blue-500 hover:text-white text-sm lg:text-base"><?php echo $counter; ?></a>
                    <?php endfor; ?>

                    <?php if ($page_no < $total_number_of_pages): ?>
                        <a href="?page_no=<?php echo $next_page; ?>" class="px-2 py-1 lg:px-3 lg:py-1 bg-gray-200 text-gray-700 rounded-lg hover:bg-blue-500 hover:text-white text-sm lg:text-base">Next</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Confirmation Dialog -->
    <div id="actionDialog" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Archive Student
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500" id="action-description">
                                    Are you sure you want to archive this student? This action can be undone later.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="confirmAction" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Confirm
                    </button>
                    <button type="button" id="cancelAction" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const actionDialog = document.getElementById('actionDialog');
        const confirmActionBtn = document.getElementById('confirmAction');
        const cancelActionBtn = document.getElementById('cancelAction');
        const modalTitle = document.getElementById('modal-title');
        const actionDescription = document.getElementById('action-description');
        const modalIcon = document.querySelector('#actionDialog svg');
        let currentStudentId = null;
        let currentAction = null;

        // Use event delegation for archive and recover buttons
        document.body.addEventListener('click', function(e) {
            const target = e.target.closest('.archive-btn, .recover-btn');
            if (target) {
                e.preventDefault();
                currentStudentId = target.getAttribute('data-student-id');
                currentAction = target.classList.contains('archive-btn') ? 'archive' : 'recover';
                
                if (currentAction === 'archive') {
                    modalTitle.textContent = 'Archive Student';
                    actionDescription.textContent = 'Are you sure you want to archive this student? This action can be undone later.';
                    modalIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />';
                    modalIcon.classList.remove('text-green-600');
                    modalIcon.classList.add('text-red-600');
                    confirmActionBtn.textContent = 'Archive';
                    confirmActionBtn.classList.remove('bg-green-600', 'hover:bg-green-700', 'focus:ring-green-500');
                    confirmActionBtn.classList.add('bg-red-600', 'hover:bg-red-700', 'focus:ring-red-500');
                } else {
                    modalTitle.textContent = 'Recover Student';
                    actionDescription.textContent = 'Great news! You\'re about to recover this student\'s account. They\'ll be able to access the system again.';
                    modalIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />';
                    modalIcon.classList.remove('text-red-600');
                    modalIcon.classList.add('text-green-600');
                    confirmActionBtn.textContent = 'Recover';
                    confirmActionBtn.classList.remove('bg-red-600', 'hover:bg-red-700', 'focus:ring-red-500');
                    confirmActionBtn.classList.add('bg-green-600', 'hover:bg-green-700', 'focus:ring-green-500');
                }
                
                actionDialog.classList.remove('hidden');
            }
        });

        cancelActionBtn.addEventListener('click', function() {
            actionDialog.classList.add('hidden');
        });

        confirmActionBtn.addEventListener('click', function() {
            if (currentStudentId && currentAction) {
                const formData = new FormData();
                formData.append('student_id', currentStudentId);
                formData.append('action', currentAction);

                fetch('../../src/Controllers/manage_student_archive.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => Promise.reject(err));
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        actionDialog.classList.add('hidden');
                        // Add small delay to ensure notification is created
                        setTimeout(() => {
                            location.reload();
                        }, 500);
                    } else {
                        throw new Error(data.message || `Failed to ${currentAction} student`);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // alert(error.message || `An error occurred while ${currentAction}ing the student`);
                })
                .finally(() => {
                    actionDialog.classList.add('hidden');
                });
            }
        });
    });
    </script>
</body>
</html>
