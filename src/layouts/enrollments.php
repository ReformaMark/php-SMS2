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
            <form action="" method="get" class="grid grid-cols-12 items-center mb-5">
                <h1 class="text-lg font-semibold col-span-9">Student lists</h1>
                <div class="flex justify-end items-center gap-x-5 col-span-3">
                    <input type="text" placeholder="Search name, id, email" id="search" name="search" value="<?php if(isset($_GET['search'])){echo $_GET['search'];} ?>"  class="mt-1 block  h-10 py-1 px-2 border bg-gray-50 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500 p-2" />
                    <button type="submit" class='px-2 py-1 bg-blue-700 rounded-lg text-white hover:bg-blue-500'>Search</button>
                </div>
            </form>
           

           
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
                        if(isset($_GET['page_no']) && $_GET['page_no'] !== ""){
                            $page_no = $_GET['page_no'];
                        } else {
                            $page_no = 1;
                        }
                        $total_records_per_page = 10;
                        $offset = ($page_no - 1) * $total_records_per_page;
                        $prev_page = $page_no - 1;
                        $next_page = $page_no + 1;
                        $total_count = getTotalCount($pdo);
                        $totol_number_of_pages = ceil($total_count / $total_records_per_page);

                        if(isset($_GET['search'])){
                            $filter = $_GET['search'];
                            $students = fetchAllStudents($pdo, $filter, $offset, $total_records_per_page);
                            displayStudents($students);
                        } else {
                            $filter = null;
                            $students = fetchAllStudents($pdo, $filter, $offset, $total_records_per_page);
                            displayStudents($students);
                        }
                    
                    ?>
                </tbody>
                <div class="">
            <div class="flex space-x-1 mt-5">
                <button  <?= ($page_no <= 1)? 'disabled' :"" ?>  class="rounded-md disabled: border border-slate-300 py-2 px-3 text-center text-sm transition-all shadow-sm hover:shadow-lg text-slate-600 hover:text-white hover:bg-slate-800 hover:border-slate-800 focus:text-white focus:bg-green-600 focus:border-slate-800 active:border-slate-800 active:text-white active:bg-green-600 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2">
                    <a <?= ($page_no > 1)? 'href=?page_no='.$prev_page :"";?>>Prev</a>
                </button>

                <?php for ($counter = 1; $counter <= $totol_number_of_pages; $counter++) {?>
                    <button class="min-w-9 rounded-md bg-green-500 py-2 px-3 border border-transparent text-center text-sm text-white transition-all shadow-md hover:shadow-lg focus:bg-slate-700 focus:shadow-none active:bg-slate-700 hover:bg-slate-700 active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2">
                        <a href="?page_no=<?=$counter; ?>"><?= $counter ?></a>
                    </button>
                <?php  }  ?>
            
                
                
                <button  <?= ($page_no == $totol_number_of_pages)? 'disabled' :"" ?>  class="rounded-md disabled: border border-slate-300 py-2 px-3 text-center text-sm transition-all shadow-sm hover:shadow-lg text-slate-600 hover:text-white hover:bg-slate-800 hover:border-slate-800 focus:text-white focus:bg-slate-800 focus:border-slate-800 active:border-slate-800 active:text-white active:bg-slate-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2">
                    <a <?= ($page_no < $totol_number_of_pages)? 'href=?page_no='.$prev_page :"";?>>Next</a>
                </button>
            </div>
            <div class="">
                <h3 class="text-gray-300 text-sm">Page <?= $page_no?> of <?= $totol_number_of_pages?></h3>
            </div>
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