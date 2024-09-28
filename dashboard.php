<?php
    require_once "src/config_session.php";

    if(!isset($_SESSION['user_id'])){
        header("Location: ./index.php");
        die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="./output.css" rel="stylesheet" >
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
    <?php include('public/templates/header.php') ?>
    <h1>Welcome, <?php echo $_SESSION['user_username'] ?></h1>
</body>
</html>