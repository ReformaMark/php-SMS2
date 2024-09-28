<?php

if($_SERVER["REQUEST_METHOD"] === "POST"){

    $username =  $_POST['username'];
    $password = $_POST['password'];

    try{

        require_once 'dbh.php';
        require_once 'Models/login_model.php';
        require_once 'Controllers/login_controller.php';

        //ERROR  HANDLERS 
        $errors = [];

        if(isEmpty($username, $password)){
            $errors["empty_field"] = "Fill in all fields!"; 
        }

        $result = getUsername($pdo, $username);

        if(!$result){
            $errors["incorrect_credentials"] = "Username or password are incorrect!";
        }
        
        if(isUsernameExist($result) && !isPasswordMatch($password, $result["password_hash"])){
            $errors["incorrect_credentials"] = "Username or password are incorrect!";
        }

        require_once 'config_session.php';

        if($errors){
            $_SESSION["errors_login"] = $errors;

            header("Location: ../index.php");
            die();
        }

        $_SESSION['user_id'] = $result['user_id'];
        $_SESSION['user_username'] = htmlspecialchars($result['username']);

        $_SESSION["last_regeneration"] = time();

        header("Location: ../dashboard.php?login=success");

        $pdo = null;
        $stmt = null;

        die();

    } catch (PDOException $e){
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
    die();
}