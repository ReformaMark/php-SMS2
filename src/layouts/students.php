<?php
    require_once "../config_session.php";
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
    <title>Students</title>
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
            Student page
        </div>
    </div>
</body>
</html>