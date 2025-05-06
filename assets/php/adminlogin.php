<?php

session_start();
// Database connection parameters
include 'conn.php';

$username = $_POST['email'];
$password = $_POST['password'];
$_SESSION['email'] = $username;
// Check if the form is submitted
if (trim($username)!=""and trim($password)!= "") {
    // Retrieve form data
 // Perform SQL query to check user credentials
    $sql = "SELECT * FROM admin WHERE username = '$username' AND Password = '$password'";
    $result = $conn->query($sql);
    
    // Check if user exists
    if ($result->num_rows > 0) {
        // User authenticated successfully, set session variables
        
        // Redirect to dashboard or desired page
        if(isset($_SESSION['email']) || isset($_SESSION['username']))
        {
            header("Location: ../../application files/adminDashboard.php");
        }
        else{
            header("location: adminlogin.php");
        }
        exit();
    } else {
        // Invalid credentials, display error message
        echo "Invalid email or password.";
    }
}

// Close connection
$conn->close();

