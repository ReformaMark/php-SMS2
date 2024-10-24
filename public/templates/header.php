<?php 
   
?>

<nav class="z-50 absolute flex justify-between px-5 md:px-40 items-center w-full bg-white py-5 shadow-sm">
    <div class="flex items-center gap-x-2">
        <div class="size-10">
            <a href="#">
                <img src="<?php echo $imageSrc; ?>" alt="BCP logo" class="object-cover size-full" >
            </a>
        </div>
        <h1 class="text-blue-500 font-serif font-semibold text-lg ">Bestlink College</h1>
    </div>
  
    <?php 
        if(isset($_SESSION['user_username'])){
            include($_SERVER['DOCUMENT_ROOT'] . '/php-SMS2/public/templates/userAvatar.php');
        } else{
            echo '<ul class="hidden md:flex justify-center gap-10">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">Home</a></li>
                </ul>' ;
        }
    ?>
    
</nav>