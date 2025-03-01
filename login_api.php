<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

include_once("src/connection/connection.php");
require_once 'src/config_session.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        // Update query to match your users table structure
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Check if the password matches the hashed password
            if (password_verify($password, $row['password_hash'])) { // Change 'password' to 'password_hash'
                $_SESSION['auth'] = true;
                
                // Update session variables to match your existing login.php
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['user_username'] = htmlspecialchars($row['username']);
                $_SESSION['user_role'] = $row['role'];
                $_SESSION['user_name'] = htmlspecialchars($row['first_name']);
                $_SESSION['user_lastname'] = htmlspecialchars($row['last_name']);
                $_SESSION["last_regeneration"] = time();

                // Return success response with redirect URL based on role
                $redirectUrl = '';
                switch ($row['role']) {
                    case 'SuperAdmin':
                        $redirectUrl = 'layouts/super_admin_dashboard.php';
                        break;
                    case 'Admin':
                        $redirectUrl = 'layouts/dashboard.php';
                        break;
                    default:
                        $redirectUrl = 'layouts/student_dashboard.php';
                        break;
                }

                echo json_encode([
                    'success' => true,
                    'redirect' => $redirectUrl,
                    'message' => 'Welcome to Dashboard'
                ]);
              
              header("Location: https://mis.schoolmanagementsystem2.com/index.php");
              
                exit();
            } else {
                echo json_encode(['success' => false, 'error' => 'Invalid username or password']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'User not found']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Missing username or password fields']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
    exit();
}
?>