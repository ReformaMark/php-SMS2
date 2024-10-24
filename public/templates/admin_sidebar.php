<section class="flex flex-col justify-between pb-5 shadow-md bg-white w-1/5 h-custom max-h-screen overflow-hidden">
    <div class="w-full pt-3">
        <?php include('../Views/admin_sidebar_view.php') ?>
        <!-- Admin-specific links -->
        <a href="../layouts/admin_dashboard.php" class="w-full flex items-center gap-x-3 pl-3 hover:bg-blue-500 hover:translate-x-5 hover:pl-5 hover:rounded-l-full hover:text-white transition-all duration-500 ease-linear font-normal text-lg border-b p-1">
            Admin Dashboard
        </a>
    </div>
    <a href="../logout.php" class="flex items-center w-full px-3 gap-x-3 mt-20">
        Logout
    </a>
</section>
