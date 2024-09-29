<?php
    require_once "../config_session.php";

    if(isset($_SESSION['user_id'])){
        header("Location: ./dashboard.php");
        die();
    }

    unset($_SESSION['register_data']);
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" 
            content="width=device-width, initial-scale=1.0">
    <link href="../../output.css" rel="stylesheet" >
    <link rel="stylesheet" href="../../public/css/styles.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Bestlink College</title>
    <style>
        .tooltip {
            visibility: hidden;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .tooltip-trigger:hover + .tooltip {
            visibility: visible;
            opacity: 1.0;
        }
    </style>
</head>
<body class="bg-gray-100/50 min-h-[80vh] flex flex-col justify-between">
    
    <?php 
        $imageSrc = '../../public/assets/images/bcp_logo.png';
        include('../../public/templates/header.php') 
    ?>
    <div class="flex px-5 md:px-40 pb-10 pt-24 gap-x-10 justify-between min-h-[100vh]">
        <div class="hidden sm:flex flex-col gap-y-2 justify-center">
            <h1 class="lg:text-3xl md:text-2xl sm:text-2xl font-semibold font-serif">Welcome to <span class="text-blue-500">B</span>estlink <span class="text-blue-500">C</span>ollege</h1>
            <h1 class="md:text-3xl sm:text-2xl  font-semibold font-serif">of the <span class="text-blue-500">P</span>hilippines</h1>
            <h1 class="md:text-2xl sm:text-lg  font-medium font-serif">Student Management System 2</h1>
           
        </div>
        <?php include('../../public/templates/register_form.php') ?>
    </div>
    <?php include('../../public/templates/footer.php') ?>
   
    <script src="../../public/js/script.js"></script>
</body>
</html>

