<?php

    declare(strict_types=1);

    function checkRegisterErrors(){
        if(isset($_SESSION["errors_register"]) && is_array($_SESSION["errors_register"])){
            $errors = $_SESSION["errors_register"];

            foreach($errors as $error){
                echo '<p class="login-errors ">*' . $error . '</p>';
                // Log errors instead of displaying directly
                error_log($error);
            }

            unset($_SESSION["errors_register"]);
        }
    }
?>