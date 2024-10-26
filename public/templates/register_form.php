<?php
    require_once "../../src/config_session.php";
    require_once "../../src/Views/register_view.php";
?>

<section class="w-full sm:w-1/3 md:w-1/2 bg-white text-black p-10 rounded-lg outline-1 outline-gray-100 shadow-xl">
    <div class="block sm:hidden text-center">
    
        <h1 class="md:text-4xl text-black sm:text-3xl text-2xl font-semibold font-serif">Welcome to Bestlink College</h1>
        <h1 class="md:text-4xl text-black sm:text-3xl text-2xl font-semibold font-serif">of the Philippines</h1>
        <h1 class="md:text-xl text-black sm:text-lg text-sm font-medium font-serif">Student Management System 2</h1>
    </div>
    

    <form action="../register.php" onsubmit="" method="post">
        <h1 class="md:text-3xl sm:text-2xl text-xl text-blue-500 font-semibold text-center pt-3 sm:pt-0 mt-10 mb-5 sm:mt-0 sm:mb-10 border-t border-t-gray-300 sm:border-none ">Register</h1>

        <?php
            checkRegisterErrors();
        ?>
        <?php 
            registerInputs();
            unset($_SESSION['register_data']);
        ?>
        <div class="flex item-center gap-x-3 py-1 ">
            <input type="checkbox" name="agree" id="agree" class="size-4 mt-[2px]" required>
            <label for="agree" class="text-sm text-gray-500">
                I agree to the <a href="#" class="text-blue-500">terms and conditions.</a>
            </label>
        </div>

       

        <input disabled type="submit" id="loginSubmit" value="Register" name="submit" class="w-full mt-5 bg-[#d3d3d3] text-white hover:cursor-pointer py-2 hover:bg-blue-500/50 transition-colors duration-75 ease-linear rounded-md">
    </form>


    <h1 class="text-center text-sm text-gray-500">Already have an account? <a href="../../index.php" class="text-blue-500">Login!</a></h1>
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
