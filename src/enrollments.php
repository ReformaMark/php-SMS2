<?php 

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstName =  $_POST['firstName'];
    $lastName =  $_POST['lastName'];
    $email =  $_POST['email'];
    $birthDate = date('Y-m-d', strtotime($_POST['birthDate']));
    $gender = $_POST['gender'];
    $phoneNumber =  $_POST['phoneNumber'];
    $enrollmentDate =  $_POST['enrollmentDate'];
    $status = "Active";
    
    require_once "dbh.php";
    require_once "config_session.php";
    require_once "./Models/enrollments_model.php";
    require_once "Controllers/enrollments_controller.php";
    $errors = [];

    error_log("Received birth date: " . $birthDate);

    // all required
    if(empty($firstName) || empty($lastName) || empty($email) || empty($phoneNumber) || empty($birthDate) || empty($enrollmentDate) || empty($gender) || empty($status)){
        $errors["empty_field"] = "All fields are required!";
    }

    if(!in_array($gender, ["Male", "Female"])) {
        $errors["invalid_gender"] = "Invalid gender. Please select Male or Female";
    }

    if(empty($errors)) {
        try {
            createStudent($pdo, $firstName, $lastName, $birthDate, $gender, $email, $phoneNumber, $enrollmentDate, $status);
            $pdo = null;
            $stmt = null;
            header("Location: ./layouts/enrollments.php");
            die();
        } catch (PDOException $e) {
            $errors["database_error"] = "Database error: " . $e->getMessage();
        } catch (Exception $e) {
            $errors["general_error"] = "An error occured: " . $e->getMessage();
        }
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<script>alert('Error: " . addslashes($error) . "');</script>";
        }
        echo "<script>window.location.href = './enrollment_form.php';</script>";
        die();
    }
};

function fetchAllStudents(object $pdo, string|null $filter, int $offset, int $total_records_per_page){
    try{
      
        $students = getAllStudents($pdo,$filter,$offset,$total_records_per_page); 

        if($students !== null){
            return $students;
        } else {
            return null;
        }
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    };
};