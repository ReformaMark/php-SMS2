<?php

    require_once "../config_session.php";
    if(!isset($_SESSION['user_id'])){
        header("Location: ../../index.php");
        die();
    }

    require_once "../Models/enrollments_model.php";
    require_once "../Models/enrollments_model.php";
    require_once "../Views/enrollments_view.php";

    require_once "../enrollments.php";


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollments</title>
    <link href="../../output.css" rel="stylesheet" >
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body class="bg-gray-100 min-h-[80vh] flex flex-col justify-between">
     <!-- Navigation bar -->
    <?php 
        $imageSrc =  '../../public/assets/images/bcp_logo.png';
        include('../../public/templates/header.php');
       
    ?>
      <div class="flex pt-20"> 
         <!-- sidebar -->
        <?php include('../../public/templates/sidebar.php');?>

        <!-- Student page -->
        <div class="bg-white m-5 w-full p-3">
            <div class="">
                <button id="showBtn" class="bg-green-500 px-3 py-1 rounded-md hover:bg-green-200 text-white">+ New Student</button>
            </div>
            <dialog id='modal' class="p-5 bg-white w-full">
                <div class="flex justify-end">
                    <button id="closeBtn" class="">
                        X
                    </button>
                </div>
                <h1 class="text-lg font-semibold">Add New Students</h1>
                <form id="studentForm" action="../students.php" onsubmit="" method="post" class="grid grid-cols-2 gap-5">
                    <div class="mb-4">
                        <label for="firstName" class="block text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" id="firstName" name="firstName" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500 p-2" />
                    </div>
                    <div class="mb-4">
                        <label for="lastName" class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" id="lastName" name="lastName" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500 p-2" />
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500 p-2" />
                    </div>
                    <div class="mb-4">
                        <label for="phoneNumber" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="tel" id="phoneNumber" name="phoneNumber" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500 p-2" />
                    </div>
                    <div class="mb-4">
                        <label for="dob" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                        <input type="date" id="birthDate" name="birthDate" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500 p-2" />
                    </div>
                    <div class="mb-4">
                        <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                        <input type="gender" id="gender" name="gender" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500 p-2" />
                    </div>
                    <div class="mb-4">
                        <label for="enrollmentDate" class="block text-sm font-medium text-gray-700">Enrollment Date</label>
                        <input type="date" id="enrollmentDate" name="enrollmentDate" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500 p-2" />
                    </div>
                    <div class="flex justify-end mt-6">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                            Add Student
                        </button>
                    </div>
                </form>

            </dialog>

            <h1 class="text-lg font-semibold">Student lists</h1>
            <table class="w-full shadow-lg border-collapse">
                <thead>
                    <tr class="w-full border border-gray-400 bg-gray-100 even:bg-gray-100">
                        <th class="border border-gray-400">Id</th>
                        <th class="border border-gray-400">Full Name</th>
                        <th class="border border-gray-400">Email</th>
                        <th class="border border-gray-400">Phone No.</th>
                        <th class="border border-gray-400">Enrollment Date</th>
                        <th class="border border-gray-400">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  
                        require_once '../dbh.php';
                        $students = fetchAllStudents($pdo);
                        displayStudents($students);
                    
                    ?>
                </tbody>
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