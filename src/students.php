<?php 

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstName =  $_POST['firstName'];
    $lastName =  $_POST['lastName'];
    $email =  $_POST['email'];
    $birthDate = $_POST['birthDate'];
    $gender = $_POST['gender'];
    $phoneNumber =  $_POST['phoneNumber'];
    $enrollmentDate =  $_POST['enrollmentDate'];
    $status = "Active";
    
    require_once "dbh.php";
    require_once "config_session.php";
    require_once "Models/students_model.php";
    require_once "Controllers/student_controller.php";
    $errors = [];

    // all required
    if(empty($firstName) || empty($lastName)  || empty($email)|| empty($phoneNumber) || empty($birthDate) || empty($enrollmentDate)|| empty($status)){
        $errors["empty_field"] = "All fields are required!";
    }

    createStudent($pdo, $firstName, $lastName, $birthDate , $gender, $email, $phoneNumber, $enrollmentDate, $status);
    $pdo = null;
    $stmt = null;

    header("Location: ./layouts/students.php");

    die();

};

function fetchAllStudents(object $pdo){
    try{
      
        $students = getAllStudents($pdo); 

        if($students !== null){
            return $students;
        } else {
            return null;
        }

        return $students;
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    };
};