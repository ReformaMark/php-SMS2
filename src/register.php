<?php

    if($_SERVER["REQUEST_METHOD"] === "POST") {

        $username =  $_POST['username'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];

    try {

        require_once "dbh.php";
        require_once "config_session.php";
        require_once "Models/login_model.php";
        require_once "Controllers/login_controller.php";
    
        $errors = [];

        // all required
        if(empty($username) || empty($password) || empty($cpassword)){
            $errors["empty_field"] = "All fields are required!";
        }

        // Password not matching
        if($password !== $cpassword){
            $errors["password_mismatch"] = "Password does not match!";
        }

        // check if password is strong: 8 characters, 1 uppercase, 1 lowercase, 1 number, 1 special character
        if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
            $errors["password_mismatch"] = "Password must contain at least 8 characters, 1 uppercase, 1 lowercase, 1 number, 1 special character!";
        }

        // check if username exist
        if(isUsernameExist($pdo, $username)){
            $errors["username_exist"] = "Username already exist!";
        }

        if($errors) {
            $_SESSION["errors_register"] = $errors;
            header("Location: ../register.php");
            die();
        }

        // if username does not exist then register
        if(!isUsernameExist($pdo, $username)) {

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO users (username, password_hash) VALUES (:username, :password_hash);";

            $stmt = $pdo->prepare($query);

            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":password_hash", $hashed_password);

            $stmt->execute();
        }

        if(!isset($errors["empty_field"]) && !isset($errors["password_mismatch"]) && !isset($errors["username_exist"])) {
            header("Location: ../index.php");

            $_SESSION['register_success'] = true;

            $pdo = null;
            $stmt = null;

            die();
        }


        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }
?>