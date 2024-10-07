<?php

    if($_SERVER["REQUEST_METHOD"] === "POST") {

        $username =  $_POST['username'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];

    try {

        require_once "dbh.php";
        require_once "config_session.php";
        require_once "Models/register_model.php";
        require_once "Controllers/register_controller.php";
    
        $errors = [];

        // all required
        if(empty($username) || empty($password) || empty($cpassword)){
            $errors["empty_field"] = "All fields are required!";
        }

        // check if the username is valid
        // if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[^\s]{4,}$/', $password)){
        //     $errors["password_invalid"] = "Password must contain both uppercase and lowercase letters, at least one number, no whitespace, and be at least 4 characters long!";
        // }

        // Password not matching
        if($password !== $cpassword){
            $errors["password_mismatch"] = "Password does not match!";
        }

        // check if password is strong: 8 characters, 1 uppercase, 1 lowercase, 1 number, 1 special character
        if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/', $password)) {
            $errors["password_invalid"] = "Password must contain at least 8 characters, 1 uppercase, 1 lowercase, 1 number, 1 special character!";
        }

        // check if username exist
        if(isUsernameRegistered($pdo, $username)){
            $errors["username_exist"] = "Username already exist!";
        }

        require_once 'config_session.php';
        
        if($errors) {
            $_SESSION["errors_register"] = $errors;

            $registerData = [
                "username" => $username,
                "password" => $password, 
                "cpassword" => $cpassword
            ];

            $_SESSION['register_data'] = $registerData;

            header("Location: ./layouts/register.php");
            die();
        }

        createUser($pdo, $username, $password);

        header("Location: ./layouts/register.php?register=success");
        $pdo = null;
        $stmt = null;

        die();

        // if username does not exist then register
        // if(!isUsernameExist($pdo, $username)) {

        //     $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        //     $query = "INSERT INTO users (username, password_hash) VALUES (:username, :password_hash);";

        //     $stmt = $pdo->prepare($query);

        //     $stmt->bindParam(":username", $username);
        //     $stmt->bindParam(":password_hash", $hashed_password);

        //     $stmt->execute();
        // }

        // if(!isset($errors["empty_field"]) && !isset($errors["password_mismatch"]) && !isset($errors["username_exist"])) {
        //     header("Location: ../index.php");

        //     $_SESSION['register_success'] = true;

        //     $pdo = null;
        //     $stmt = null;

        //     die();
        // }


        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }
?>