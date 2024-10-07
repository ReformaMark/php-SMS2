<?php

    require_once "../config_session.php";
    if(!isset($_SESSION['user_id'])){
        header("Location: ../../index.php");
        die();
    }

    require_once "../Models/transactions_model.php";
    require_once "../Views/transactions_view.php";
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
      <div class="flex pt-20"> 
         <!-- sidebar -->
        <?php include('../../public/templates/sidebar.php');?>

        <!-- Student page -->
        <div class="bg-white m-5 w-full p-3">
          
            <form action="" method="get" class="grid grid-cols-12 items-center mb-5">
                <h1 class="text-lg font-semibold col-span-9">Transaction history</h1>
                <div class="flex justify-end items-center gap-x-5 col-span-3">
                    <input type="text" placeholder="Transaction Id, student Id" id="search" name="search" value="<?php if(isset($_GET['search'])){echo $_GET['search'];} ?>" required class="mt-1 block  h-10 py-1 px-2 border bg-gray-50 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500 p-2" />
                    <button type="submit" class='px-2 py-1 bg-blue-700 rounded-lg text-white hover:bg-blue-500'>Search</button>
                </div>
            </form>
           
            <table class="w-full shadow-lg border-collapse m-h-[50vh]">
                <tr class="w-full border border-gray-400 bg-gray-100 even:bg-gray-100 text-xs">
                    <th class="border text-xs border-gray-400">Transaction Id</th>
                    <th class="border text-xs border-gray-400">Student Id</th>
                    <th class="border text-xs border-gray-400">Amount</th>
                    <th class="border text-xs border-gray-400">Transaction Type</th>
                    <th class="border text-xs border-gray-400">Description</th>
                    <th class="border text-xs border-gray-400">Date</th>
                    <th class="border text-xs border-gray-400">actions</th>
                </tr>

                <?php  
                    require_once '../dbh.php';
                    require_once '../Controllers/transaction_controller.php';
                    if(isset($_GET['search'])){
                        $filter = $_GET['search'];
                        $transactions = fetchTransactions($pdo, $filter);
                        displayTransactions($transactions);
                    } else {
                        $filter = null;
                        $transactions = fetchTransactions($pdo, $filter);
                        displayTransactions($transactions);
                    }
                   
                 
                ?>
            </table>
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