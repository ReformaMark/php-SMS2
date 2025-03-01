<?php
    require_once "src/config_session.php";
    require_once "src/Views/login_view.php";
?>

<section class="w-full sm:w-1/3 md:w-1/2 text-gray-600 bg-white p-10 rounded-lg outline-1 outline-gray-100 shadow-xl">
    <div class="block sm:hidden text-center">
        <h1 class="md:text-4xl sm:text-3xl text-black text-2xl font-semibold font-serif">Welcome to Bestlink College</h1>
        <h1 class="md:text-4xl sm:text-3xl text-black text-2xl font-semibold font-serif">of the Philippines</h1>
        <h1 class="md:text-xl sm:text-lg text-black text-sm font-medium font-serif">Student Management System 2</h1>
    </div>
    

    <form action="src/login.php" onsubmit="" method="post">
        <h1 class="md:text-3xl sm:text-2xl text-xl font-semibold text-center pt-3 sm:pt-0 mt-10 mb-5 sm:mt-0 sm:mb-10 border-t text-blue-500 border-t-gray-300 sm:border-none ">Login</h1>
        <div class="relative mb-5 shadow-sm">
            <label for="username" class="absolute left-1 top-[50%] translate-y-[-50%] transition-all ease-in duration-300 text-gray-500 focus:text-blue-500 border-r pr-1 border-gray-300">
                <svg class="feather feather-user" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </label>
            <input 
                type="text" 
                name="username" 
                placeholder="Enter Student ID"
                autocomplete="off"
                class=" w-full px-2 pl-10 py-2 rounded-lg outline-none transition-all ease-in duration-300 bg-gray-100/50 focus:outline-none border-b-2 border-gray-200 focus:border-b-blue-500"
            />
        </div>

        <div class="relative mb-2">
            <label for="username" class="absolute left-1 top-[50%] translate-y-[-50%] transition-all ease-in duration-300 text-gray-500 focus:text-blue-500 border-r pr-1 border-gray-300">
                <svg enable-background="new 0 0 32 32" height="24" id="Layer_1" version="1.1" viewBox="0 0 32 32" width="24" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="lock"><path d="M25,13V9c0-4.971-4.029-9-9-9c-4.971,0-9,4.029-9,9v4c-1.657,0-3,1.343-3,3v3v1v2v1c0,4.971,4.029,9,9,9h6   c4.971,0,9-4.029,9-9v-1v-2v-1v-3C28,14.342,26.656,13,25,13z M9,9c0-3.866,3.134-7,7-7c3.866,0,7,3.134,7,7v4h-2V9.002   c0-2.762-2.238-5-5-5c-2.762,0-5,2.238-5,5V13H9V9z M20,9v0.003V13h-8V9.002V9c0-2.209,1.791-4,4-4C18.209,5,20,6.791,20,9z M26,19   v1v2v1c0,3.859-3.141,7-7,7h-6c-3.859,0-7-3.141-7-7v-1v-2v-1v-3c0-0.552,0.448-1,1-1c0.667,0,1.333,0,2,0h14c0.666,0,1.332,0,2,0   c0.551,0,1,0.448,1,1V19z" fill="#333333"/><path d="M16,19c-1.104,0-2,0.895-2,2c0,0.607,0.333,1.76,0.667,2.672c0.272,0.742,0.614,1.326,1.333,1.326   c0.782,0,1.061-0.578,1.334-1.316C17.672,22.768,18,21.609,18,21C18,19.895,17.104,19,16,19z" fill="#333333"/></g></svg>
            </label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                placeholder="Enter your password" 
                class=" w-full px-2 pl-10 py-2 rounded-lg outline-none transition-all ease-in duration-300 bg-gray-100/50 focus:outline-none border-b-2 border-gray-200 focus:border-b-blue-500"
                autocomplete="new-password"
            />
        </div>
        <!-- <div class="w-full text-right">
            <a href="#" class="text-right text-gray-400 text-sm">Forgot your password?</a>
        </div> -->

        <?php
            checkLoginErrors();
        ?>

        <input disabled type="submit" id="loginSubmit" value="Login" name="submit" class="w-full mt-5 bg-blue-500 text-white hover:cursor-pointer py-2 hover:bg-blue-500/50 transition-colors duration-75 ease-linear rounded-md">
    </form>

    <h1 class="text-center text-sm text-gray-500">Don't have an account? <a href="./src/layouts/register.php" class="text-blue-500">Register!</a></h1>
</section>