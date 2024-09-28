<?php 
   
?>

<nav class="absolute flex justify-between items-center w-full bg-white px-10 py-5">
    <div class="">
        <h1>Logo</h1>
    </div>
    <?php 
        if(isset($_SESSION['user_username'])){
            echo '<p class=""> Welcome '. $_SESSION['user_username'] . '!</p>';
        } else{
            echo '<ul class="flex justify-center gap-3">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Home</a></li>
                </ul>' ;
        }
    ?>
    
</nav>