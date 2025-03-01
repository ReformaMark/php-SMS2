<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstname = $_POST['firstname'] ?? '';
    $middlename = $_POST["middlename"] ?? '';
    $lastname = $_POST['lastname'] ?? '';
    $email = $_POST['email'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $cpassword = $_POST['cpassword'] ?? '';
    $course = $_POST['course'] ?? null;

    try {
        require_once "dbh.php";
        require_once "config_session.php";
        require_once "Models/register_model.php";
        require_once "Controllers/register_controller.php";
    
        $errors = [];

        // Validate first name
        if (empty($firstname)) {
            $errors["firstname_empty"] = "First name is required!";
        } elseif (!preg_match('/^[a-zA-Z.-]+$/', $firstname)) {
            $errors["firstname_invalid"] = "First name can only contain letters, dots, and hyphens! ex: John Jr.";
        }

        if (!empty($middlename) && !preg_match('/^[a-zA-Z.-]+$/', $middlename)) {
            $errors["middlename_invalid"] = "Middle name can only contain letters, dots, and hyphens! ex: De-la";
        }

        // Validate last name
        if (empty($lastname)) {
            $errors["lastname_empty"] = "Last name is required!";
        } elseif (!preg_match('/^[a-zA-Z.-]+$/', $lastname)) {
            $errors["lastname_invalid"] = "Last name can only contain letters, dots, and hyphens! ex: Den-den";
        }

        // Validate email
        if (empty($email)) {
            $errors["email_empty"] = "Email is required!";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["email_invalid"] = "Invalid email format!";
        }

        // Validate username (Student ID)
        if (empty($username)) {
            $errors["username_empty"] = "Student ID is required!";
        } elseif (!preg_match('/^s\d{8}$/', $username)) {
            $errors["username_invalid"] = "Student ID must be in the format 's' followed by 8 digits!";
        } elseif (isUsernameRegistered($pdo, $username)) {
            $errors["username_taken"] = "This Student ID is already taken!";
        }

        // Validate password
        if (empty($password)) {
            $errors["password_empty"] = "Password is required!";
        } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/', $password)) {
            $errors["password_invalid"] = "Password must contain at least 8 characters, 1 uppercase, 1 lowercase, 1 number, 1 special character!";
        }

        // Confirm password
        if ($password !== $cpassword) {
            $errors["password_mismatch"] = "Passwords do not match!";
        }

        // Check if email exists
        if (isEmailRegistered($pdo, $email)) {
            $errors["email_exist"] = "Email already exists!";
        }

        if ($errors) {
            $_SESSION["errors_register"] = $errors;

            $registerData = [
                "firstname" => $firstname,
                "middlename" => $middlename,
                "lastname" => $lastname,
                "email" => $email,
                "username" => $username,
                "password" => $password,
                "cpassword" => $cpassword,
                "course" => $course
            ];
            

            $_SESSION['register_data'] = $registerData;

            header("Location: ./layouts/register.php");
            die();
        }

        if (empty($errors)) {
            // Sanitize inputs
            $firstname = htmlspecialchars($firstname);
            $middlename = htmlspecialchars($middlename);
            $lastname = htmlspecialchars($lastname);
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            $username = htmlspecialchars($username);

            // Set default role to 'Student'
            $role = 'Student';
            createUser($pdo, $firstname, $middlename, $lastname, $email, $username, $password, $role, $course);

            header("Location: ./layouts/register.php?register=success");
            $pdo = null;
            $stmt = null;

            die();
        }

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}
