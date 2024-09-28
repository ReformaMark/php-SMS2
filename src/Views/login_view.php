<?php

declare(strict_types=1);

function checkLoginErrors(){
    if(isset($_SESSION["errors_login"]) && is_array($_SESSION["errors_login"])){
        $errors = $_SESSION["errors_login"];

        foreach($errors as $error){
            echo '<p class="login-errors ">*' . $error . '</p>';
            // Log errors instead of displaying directly
            error_log($error);
        }   

        unset($_SESSION["errors_login"]);

    } elseif (isset($_GET['login']) && $_GET['login'] === "success"){

    }
}

?>