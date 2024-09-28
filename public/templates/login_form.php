<?php
    require_once "src/config_session.php";
    require_once "src/Views/login_view.php";
?>

<section class="w-1/3 bg-white p-10 rounded-lg outline-1 outline-gray-100">
    <form action="src/login.php" method="post">
        <h1 class="text-3xl font-semibold text-center mb-20">Login</h1>

        <div class="relative mb-5">
            <label for="username" class="absolute left-1 top-[50%] translate-y-[-50%] transition-all ease-in duration-300 text-gray-500 focus:text-blue-500">
                <svg class="feather feather-user" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </label>
            <input type="text" name="username" placeholder="Enter your username" class="w-full px-2 pl-8 py-2 rounded-lg outline-none transition-all ease-in duration-300 bg-gray-100/50 focus:outline-none border-b-2 border-gray-200 focus:border-b-blue-500"/>
        </div>

        <div class="relative mb-2">
            <label for="username" class="absolute left-1 top-[50%] translate-y-[-50%] transition-all ease-in duration-300 text-gray-500 focus:text-blue-500">
                <svg enable-background="new 0 0 32 32" height="24" id="Layer_1" version="1.1" viewBox="0 0 32 32" width="24" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="lock"><path d="M25,13V9c0-4.971-4.029-9-9-9c-4.971,0-9,4.029-9,9v4c-1.657,0-3,1.343-3,3v3v1v2v1c0,4.971,4.029,9,9,9h6   c4.971,0,9-4.029,9-9v-1v-2v-1v-3C28,14.342,26.656,13,25,13z M9,9c0-3.866,3.134-7,7-7c3.866,0,7,3.134,7,7v4h-2V9.002   c0-2.762-2.238-5-5-5c-2.762,0-5,2.238-5,5V13H9V9z M20,9v0.003V13h-8V9.002V9c0-2.209,1.791-4,4-4C18.209,5,20,6.791,20,9z M26,19   v1v2v1c0,3.859-3.141,7-7,7h-6c-3.859,0-7-3.141-7-7v-1v-2v-1v-3c0-0.552,0.448-1,1-1c0.667,0,1.333,0,2,0h14c0.666,0,1.332,0,2,0   c0.551,0,1,0.448,1,1V19z" fill="#333333"/><path d="M16,19c-1.104,0-2,0.895-2,2c0,0.607,0.333,1.76,0.667,2.672c0.272,0.742,0.614,1.326,1.333,1.326   c0.782,0,1.061-0.578,1.334-1.316C17.672,22.768,18,21.609,18,21C18,19.895,17.104,19,16,19z" fill="#333333"/></g></svg>
            </label>
            <input type="password" id="password" name="password" placeholder="Enter your password" class="w-full px-2 pl-8 py-2 rounded-lg outline-none transition-all ease-in duration-300 bg-gray-100/50 focus:outline-none border-b-2 border-gray-200 focus:border-b-blue-500"/>
        </div>
        <div class="w-full mb-10 text-right">
            <a href="#" class="text-right text-gray-400 text-sm">Forgot your password?</a>
        </div>

        <?php
            checkLoginErrors();
        ?>

        <input type="submit" value="Login" name="submit" class="w-full bg-blue-500 text-white hover:cursor-pointer py-2 hover:bg-blue-500/50 transition-colors duration-75 ease-linear rounded-md">
    </form>
</section>