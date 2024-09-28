<?php
    require_once "src/config_session.php";

    if(isset($_SESSION['user_id'])){
        header("Location: ./dashboard.php");
        die();
    }
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" 
            content="width=device-width, initial-scale=1.0">
    <link href="./output.css" rel="stylesheet" >
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body class="bg-gray-100 min-h-[80vh] flex flex-col justify-between">
    
    <?php include('public/templates/header.php') ?>
    <div class="flex px-5 pb-10 pt-24 justify-center min-h-[100vh]">
        <?php include('public/templates/login_form.php') ?>
    </div>

    <?php include('public/templates/footer.php') ?>
   
</body>
</html>