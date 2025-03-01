<section 
    style="background-color: #212529;"
    class="hidden md:flex flex-col justify-between pb-5 text-white shadow-md w-1/5 h-custom max-h-screen overflow-hidden"
>
    <div class="w-full pt-6">
        <?php include($_SERVER['DOCUMENT_ROOT'] . BASE_URL . '/src/Views/student_sidebar_view.php') ?>
    </div>
    <a href="<?php echo BASE_URL; ?>/src/logout.php" class="flex items-center w-full px-3 gap-x-3 mt-auto hover:bg-blue-500 hover:text-white transition-all duration-300 ease-linear font-normal text-lg p-2">
        <svg class="size-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M17 16L21 12M21 12L17 8M21 12H9M9 21H5C3.89543 21 3 20.1046 3 19V5C3 3.89543 3.89543 3 5 3H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Logout
    </a>
</section>
