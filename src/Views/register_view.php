<?php

    declare(strict_types=1);

    function registerInputs(){

        // First Name
        if(isset($_SESSION['register_data']['firstname']) && !isset($_SESSION['errors_register']['firstname_invalid'])){
            echo 
            '<div class="relative mb-5 shadow-sm">
                <label for="firstname" class="absolute left-1 top-[50%] translate-y-[-50%] transition-all ease-in duration-300 text-gray-500 focus:text-blue-500 border-r pr-1 border-gray-300">
                    <svg class="feather feather-user" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </label>
            <input value="'.$_SESSION['register_data']['firstname'].'"  type="text" autocomplete="off" name="firstname" placeholder="Enter First Name" pattern="^[a-zA-Z.-]+$" title="Only letters, dots, and hyphens are allowed" class="w-full px-2 pl-10 py-2 rounded-lg outline-none transition-all ease-in duration-300 bg-gray-100/50 focus:outline-none border-b-2 border-gray-200 focus:border-b-blue-500" required/>
            </div>';
        } else {
            echo
            '<div class="relative mb-5 shadow-sm">
                <label for="firstname" class="absolute left-1 top-[50%] translate-y-[-50%] transition-all ease-in duration-300 text-gray-500 focus:text-blue-500 border-r pr-1 border-gray-300">
                    <svg class="feather feather-user" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </label>
            <input type="text" autocomplete="off" name="firstname" placeholder="Enter First Name" pattern="^[a-zA-Z.-]+$" title="Only letters, dots, and hyphens are allowed" class="w-full px-2 pl-10 py-2 rounded-lg outline-none transition-all ease-in duration-300 bg-gray-100/50 focus:outline-none border-b-2 border-gray-200 focus:border-b-blue-500" required/>
            </div>';
        }

        // Last Name
        if(isset($_SESSION['register_data']['lastname']) && !isset($_SESSION['errors_register']['lastname_invalid'])){
            echo 
            '<div class="relative mb-5 shadow-sm">
                <label for="lastname" class="absolute left-1 top-[50%] translate-y-[-50%] transition-all ease-in duration-300 text-gray-500 focus:text-blue-500 border-r pr-1 border-gray-300">
                    <svg class="feather feather-user" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </label>
            <input value="'.$_SESSION['register_data']['lastname'].'"  type="text" autocomplete="off" name="lastname" placeholder="Enter Last Name" pattern="^[a-zA-Z.-]+$" title="Only letters, dots, and hyphens are allowed" class="w-full px-2 pl-10 py-2 rounded-lg outline-none transition-all ease-in duration-300 bg-gray-100/50 focus:outline-none border-b-2 border-gray-200 focus:border-b-blue-500" required/>
            </div>';
        } else {
            echo
            '<div class="relative mb-5 shadow-sm">
                <label for="lastname" class="absolute left-1 top-[50%] translate-y-[-50%] transition-all ease-in duration-300 text-gray-500 focus:text-blue-500 border-r pr-1 border-gray-300">
                    <svg class="feather feather-user" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </label>
            <input type="text" name="lastname" placeholder="Enter Last Name" autocomplete="off" pattern="^[a-zA-Z.-]+$" title="Only letters, dots, and hyphens are allowed" class="w-full px-2 pl-10 py-2 rounded-lg outline-none transition-all ease-in duration-300 bg-gray-100/50 focus:outline-none border-b-2 border-gray-200 focus:border-b-blue-500" required/>
            </div>';
        }

        // Email
        if(isset($_SESSION['register_data']['email']) && !isset($_SESSION['errors_register']['email_invalid'])){
            echo 
            '<div class="relative mb-5 shadow-sm">
                <label for="email" class="absolute left-1 top-[50%] translate-y-[-50%] transition-all ease-in duration-300 text-gray-500 focus:text-blue-500 border-r pr-1 border-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                    </svg>
                </label>
            <input value="'.$_SESSION['register_data']['email'].'"  type="email" autocomplete="off" name="email" placeholder="Enter Email" class="w-full px-2 pl-10 py-2 rounded-lg outline-none transition-all ease-in duration-300 bg-gray-100/50 focus:outline-none border-b-2 border-gray-200 focus:border-b-blue-500"/>
            </div>';
        } else {
            echo
            '<div class="relative mb-5 shadow-sm">
                <label for="email" class="absolute left-1 top-[50%] translate-y-[-50%] transition-all ease-in duration-300 text-gray-500 focus:text-blue-500 border-r pr-1 border-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                    </svg>
                </label>
            <input type="email" name="email" placeholder="Enter Email" autocomplete="off" class="w-full px-2 pl-10 py-2 rounded-lg outline-none transition-all ease-in duration-300 bg-gray-100/50 focus:outline-none border-b-2 border-gray-200 focus:border-b-blue-500"/>
            </div>';
        }

        //username
        if(isset($_SESSION['register_data']['username']) && !isset($_SESSION['errors_register']['username_exist']) && !isset($_SESSION['errors_register']['username_invalid'])){
            echo 
            '<div class="relative mb-5 shadow-sm">
                <label for="username" class="absolute left-1 top-[50%] translate-y-[-50%] transition-all ease-in duration-300 text-gray-500 focus:text-blue-500 border-r pr-1 border-gray-300">
                    <svg class="feather feather-user" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </label>
            <input value="'.$_SESSION['register_data']['username'].'"  type="text" autocomplete="off" name="username" placeholder="Enter Student ID" class="w-full px-2 pl-10 py-2 rounded-lg outline-none transition-all ease-in duration-300 bg-gray-100/50 focus:outline-none border-b-2 border-gray-200 focus:border-b-blue-500"/>
            </div>';
        } else {
            echo
            '<div class="relative mb-5 shadow-sm">
                <label for="username" class="absolute left-1 top-[50%] translate-y-[-50%] transition-all ease-in duration-300 text-gray-500 focus:text-blue-500 border-r pr-1 border-gray-300">
                    <svg class="feather feather-user" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </label>
            <input type="text" name="username" placeholder="Enter Student ID" autocomplete="off" class="w-full px-2 pl-10 py-2 rounded-lg outline-none transition-all ease-in duration-300 bg-gray-100/50 focus:outline-none border-b-2 border-gray-200 focus:border-b-blue-500"/>
            </div>';
        }

        //password
        if(isset($_SESSION['register_data']['password']) && !isset($_SESSION['errors_register']['password_invalid'])){
            echo 
            '<div class="relative mb-5 w-full">
                <label for="password" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 cursor-pointer toggle-password">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </label>

                <input value="'.$_SESSION['register_data']["password"] .'" type="password" autocomplete="off" id="password" name="password" placeholder="Enter password" class="w-full rounded-lg border-b-2 border-gray-200 bg-gray-100/50 px-2 py-2 pl-10 pr-10 outline-none transition-all duration-300 ease-in focus:border-b-blue-500 focus:outline-none">
                
                <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 tooltip-trigger">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                    <span class="sr-only">Password strength requirements</span>
                </button>
                <div class="tooltip absolute right-0 mt-2 w-64 p-2 bg-white z-40 rounded-lg shadow-lg text-sm">
                    <h4 class="font-semibold mb-1">Password must contain:</h4>
                    <ul class="list-disc pl-5 text-gray-600">
                        <li>At least one uppercase letter</li>
                        <li>At least one lowercase letter</li>
                        <li>At least one number</li>
                        <li>At least one special character</li>
                    </ul>
                </div>
            </div>';
        } else {
            echo 
            '<div class="relative mb-5 w-full">
                <label for="password" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 cursor-pointer toggle-password">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </label>

                <input  type="password" id="password" name="password" autocomplete="off" placeholder="Enter password" class="w-full rounded-lg border-b-2  border-gray-200 bg-gray-100/50 px-2 py-2 pl-10 pr-10 outline-none transition-all duration-300 ease-in focus:border-b-blue-500 focus:outline-none">
                
                <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 tooltip-trigger">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                    <span class="sr-only">Password strength requirements</span>
                </button>
                <div class="tooltip absolute right-0 mt-2 w-72 p-2 z-40 bg-white rounded-lg shadow-lg text-sm">
                    <h4 class="font-semibold mb-1">Password must contain:</h4>
                    <ul class="list-disc pl-5 text-gray-600">
                        <li>At least one uppercase letter.(A-Z)</li>
        
                        <li>At least one lowercase letter.(a-z)</li>
                   
                        <li>At least one number.(0-9)</li>
                        
                        <li>At least one special character.(@#$!%*?&)</li>
                    
                    </ul>
                </div>
            </div>';
        }

        if(isset($_SESSION['register_data']['cpassword']) && !isset($_SESSION['errors_register']['password_mismatch'])){
            echo
            '<div class="relative mb-5 w-full">
                <label for="cpassword" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 cursor-pointer toggle-confirm-password">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </label>

                <input value="'.$_SESSION['register_data']['cpassword'].'" type="password" autocomplete="off" id="cpassword" name="cpassword" placeholder="Confirm password" class="w-full rounded-lg border-b-2 border-gray-200 bg-gray-100/50 px-2 py-2 pl-10 pr-10 outline-none transition-all duration-300 ease-in focus:border-b-blue-500 focus:outline-none">
            </div>';
        } else{
            echo
            '<div class="relative mb-5 w-full">
                <label for="cpassword" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 cursor-pointer toggle-confirm-password">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </label>

                <input type="password" id="cpassword" name="cpassword" autocomplete="off" placeholder="Confirm password" class="w-full rounded-lg border-b-2 border-gray-200 bg-gray-100/50 px-2 py-2 pl-10 pr-10 outline-none transition-all duration-300 ease-in focus:border-b-blue-500 focus:outline-none">
            </div>';
        }
    }

    function checkRegisterErrors(){
        if(isset($_SESSION["errors_register"]) && is_array($_SESSION["errors_register"])){
            $errors = $_SESSION["errors_register"];

            foreach($errors as $error){
                echo '<p class="login-errors text-sm font-medium mb-1">*' . $error . '</p>';
                // Log errors instead of displaying directly
                error_log($error);
            }

            unset($_SESSION["errors_register"]);
        } else if(isset($_GET['register']) && $_GET['register'] === 'success'){
            echo '<p class="text-white  text-center border-l-4 py-1 bg-green-500 border-l-green-500 mb-3 rounded-md"> Registered Successfully!</p>';

          
        }
    }
?>