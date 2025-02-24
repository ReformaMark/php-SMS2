<?php
require_once "../config_session.php";
require_once "../dbh.php";

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'SuperAdmin'){
    header("Location: ../../index.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Administrators</title>
    <link href="../../output.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body class="bg-gray-100 min-h-[80vh] flex flex-col justify-between">
    <!-- Header -->
    <?php 
        $imageSrc = '../../public/assets/images/bcp_logo.png';
        include('../../public/templates/header.php');
    ?>
    
    <div class="flex h-screen pt-20">
        <!-- Sidebar -->
        <?php include('../../public/templates/sidebar.php');?>
        
        <!-- Main content -->
        <main class="flex-1 p-8">
            <h1 class="text-2xl font-bold mb-6">Manage Administrators</h1>
            
            <!-- Add Admin Button -->
            <button id="addAdminBtn" class="bg-blue-500 text-white px-4 py-2 rounded mb-6">
                Add New Administrator
            </button>
            
            <!-- Admin List -->
            <div class="bg-white rounded-lg shadow p-6">
                <!-- Admin table implementation here -->
            </div>
        </main>
    </div>
</body>
</html>