<?php
    require_once "src/config_session.php";

    if (isset($_SESSION['user_id'])) {
        if ($_SESSION['user_role'] === 'Admin') {
            header("Location: ./src/layouts/dashboard.php");
        } elseif ($_SESSION['user_role'] === 'Student') {
            header("Location: ./src/layouts/student_dashboard.php");
        }
        die();
    }
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" 
        content="width=device-width, initial-scale=1.0">
    <link href="./output.css" rel="stylesheet" >
    <link rel="stylesheet" href="./public/css/styles.css">
    <title>Bestlink College</title> 
</head>
<body class="homeBg bg-gray-100/50 min-h-[80vh] flex flex-col justify-between">
    
    <?php 
        $imageSrc = 'public/assets/images/bcp_logo.png';
        include('public/templates/header.php') 
    ?>
    <div class="flex px-5 md:px-40 text-white pb-10 pt-24 gap-x-10 justify-between min-h-[100vh]">
        <div class="hidden sm:flex flex-col text-black gap-y-2 justify-center">
            <h1 class="lg:text-3xl md:text-4xl sm:text-2xl font-bold font-serif">Welcome to <span class="bg-blue-500">B</span>estlink <span class="bg-blue-500">C</span>ollege</h1>
            <h1 class="md:text-4xl sm:text-2xl  font-bold font-serif">of the <span class="bg-blue-500">P</span>hilippines</h1>
            <h1 class="md:text-3xl sm:text-lg  font-medium font-serif">Student Management System 2</h1>
           
        </div>
        <?php include('public/templates/login_form.php') ?>
    </div>
    <?php include('public/templates/footer.php') ?>
   
    <script src="./public/js/script.js"></script>
</body>
</html>