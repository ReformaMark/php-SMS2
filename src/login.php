<?php

require_once 'config_session.php';

if($_SERVER["REQUEST_METHOD"] === "POST"){

    $username =  $_POST['username'];
    $password = $_POST['password'];

    error_log("Username: $username");
    error_log("Password: $password");

    try {

        require_once 'dbh.php';
        require_once 'Models/login_model.php';
        require_once 'Controllers/login_controller.php';

        //ERROR  HANDLERS 
        $errors = [];

        if(isUsernameEmpty($username)){
            $errors["empty_username"] = "Username is empty!"; 
        }

        if(isPasswordEmpty($password)){
            $errors["empty_field"] = "Password is empty!"; 
        }

        if(empty($errors)){
            // fetch username
            $result = getUsername($pdo, $username);

            if($result === false || $result === null) {
                $errors["incorrect_credentials"] = "Username or password is incorrect!";
            } else {
                if(!isPasswordMatch($password, $result["password_hash"])) {
                    $errors["incorrect_credentials"] = "Username or password is incorrect!";
                } else {
                    // Check user role and redirect
                    $_SESSION['user_id'] = $result['user_id'];
                    $_SESSION['user_username'] = htmlspecialchars($result['username']);
                    $_SESSION['user_role'] = $result['role'];

                    $_SESSION["last_regeneration"] = time();

                    if ($result['role'] === 'Admin') {
                        header("Location: ./layouts/dashboard.php?login=success");
                    } else {
                        header("Location: ./layouts/student_dashboard.php?login=success");
                    }

                    $pdo = null;
                    $stmt = null;
                    die();
                }
            }
        }


        // fetch username
        // $result = getUsername($pdo, $username);

        // if username does not exist
        // if(!$result) {
            // $errors["incorrect_credentials"] = "Username or password is incorrect!";
        // }

        // if wrong password
        // if(!isPasswordMatch($password, $result["password_hash"])){
            // $errors["incorrect_credentials"] = "Username or password is incorrect!";
        // }

        // $result = getUsername($pdo, $username);

        // if(!isPasswordEmpty($password) && !isUsernameEmpty($username)){
        //     if(!$result){
        //         $errors["incorrect_credentials"] = "Username or password is incorrect!";
        //     }
            
        //     if(isUsernameExist($pdo, $result) && !isPasswordMatch($password, $result["password_hash"])){
        //         $errors["incorrect_credentials"] = "Username or password is incorrect!";
        //     }
        // }
        
        require_once 'config_session.php';

        if($errors){
            $_SESSION["errors_login"] = $errors;

            header("Location: ../index.php");
            die();
        }

        $pdo = null;
        $stmt = null;

        die();

    } catch (PDOException $e){
        error_log("Database error: " . $e->getMessage());
        
        $errors["db_error"] = "An error occurred. Please try again later.";
        $_SESSION["errors_login"] = $errors;
        header("Location: ../index.php");
        die();
    }
} else {
    header("Location: ../index.php");
    die();
}
