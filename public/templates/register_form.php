<?php
    require_once "src/config_session.php";
    require_once "src/Views/register_view.php";
?>

<section class="w-full sm:w-1/3 md:w-1/2 bg-white p-10 rounded-lg outline-1 outline-gray-100 shadow-xl">
    <div class="block sm:hidden text-center">
        <h1 class="md:text-4xl sm:text-3xl text-2xl font-semibold font-serif">Welcome to Bestlink College</h1>
        <h1 class="md:text-4xl sm:text-3xl text-2xl font-semibold font-serif">of the Philippines</h1>
        <h1 class="md:text-xl sm:text-lg text-sm font-medium font-serif">Student Management System 2</h1>
    </div>
    

    <form action="src/register.php" onsubmit="" method="post">
        <h1 class="md:text-3xl sm:text-2xl text-xl font-semibold text-center pt-3 sm:pt-0 mt-10 mb-5 sm:mt-0 sm:mb-10 border-t border-t-gray-300 sm:border-none ">Register</h1>

        <div class="relative mb-5 shadow-sm">
            <label for="username" class="absolute left-1 top-[50%] translate-y-[-50%] transition-all ease-in duration-300 text-gray-500 focus:text-blue-500 border-r pr-1 border-gray-300">
                <svg class="feather feather-user" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </label>
            <input  type="text" name="username" placeholder="Enter username" class="w-full px-2 pl-10 py-2 rounded-lg outline-none transition-all ease-in duration-300 bg-gray-100/50 focus:outline-none border-b-2 border-gray-200 focus:border-b-blue-500"/>
        </div>

        <div class="relative mb-5 w-full">
            <label for="password" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 cursor-pointer toggle-password">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                </svg>
            </label>

            <input  type="password" id="password" name="password" placeholder="Enter password" class="w-full rounded-lg border-b-2 border-gray-200 bg-gray-100/50 px-2 py-2 pl-10 pr-10 outline-none transition-all duration-300 ease-in focus:border-b-blue-500 focus:outline-none">
            
            <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 tooltip-trigger">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
            <span class="sr-only">Password strength requirements</span>
        </button>
        <div class="tooltip absolute right-0 mt-2 w-64 p-2 bg-white rounded-lg shadow-lg text-sm">
            <h4 class="font-semibold mb-1">Password must contain:</h4>
            <ul class="list-disc pl-5 text-gray-600">
                <li>At least one uppercase letter</li>
                <li>At least one lowercase letter</li>
                <li>At least one number</li>
                <li>At least one special character</li>
            </ul>
        </div>
    </div>

    <div class="relative mb-5 w-full">
            <label for="cpassword" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 cursor-pointer toggle-confirm-password">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                </svg>
            </label>

            <input  type="password" id="cpassword" name="cpassword" placeholder="Confirm password" class="w-full rounded-lg border-b-2 border-gray-200 bg-gray-100/50 px-2 py-2 pl-10 pr-10 outline-none transition-all duration-300 ease-in focus:border-b-blue-500 focus:outline-none">
    </div>

        <div class="relative mb-2 space-x-3">
            <input type="checkbox" name="agree" id="agree" class="w-4 h-4" required>
            <label for="agree" class="">
                I agree to the <a href="#" class="text-blue-500">terms and conditions</a>
            </label>
        </div>

        <?php
            checkRegisterErrors();
        ?>

        <input disabled type="submit" id="loginSubmit" value="Register" name="submit" class="w-full mt-5 bg-[#d3d3d3] text-white hover:cursor-pointer py-2 hover:bg-blue-500/50 transition-colors duration-75 ease-linear rounded-md">
    </form>

    <h1 class="text-center text-sm text-gray-500">Already have an account? <a href="./index.php" class="text-blue-500">Login!</a></h1>
</section>

<script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const togglePassword = document.querySelector('.toggle-password');

            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                if (type === 'password') {
                    this.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />';
                } else {
                    this.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />';
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const confirmPasswordInput = document.getElementById('cpassword');
            const confirmTogglePassword = document.querySelector('.toggle-confirm-password');

            confirmTogglePassword.addEventListener('click', function() {
                const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPasswordInput.setAttribute('type', type);
                
                if (type === 'password') {
                    this.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />';
                } else {
                    this.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />';
                }
            });
        })
</script>
