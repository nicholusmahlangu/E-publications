<?php
// Start session
session_start();
// Database connection parameters
include 'conn.php';

// // Create connection
// $conn = new mysqli($servername, $username, $password, $database);

// Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
$username = $_POST['email'];
$password = $_POST['password'];
// Check if the form is submitted
if (trim($username)!="" || trim($password)!="") {
    // Perform SQL query to check user credentials
    //$password = md5('password');
    $sql = "SELECT * FROM users WHERE EmailAddress = '$username' AND Password = '$password'";
    $result = $conn->query($sql);
    
    // Check if user exists
    if ($result->num_rows > 0) {
        // User authenticated successfully, set session variables
        $_SESSION['email'] = $username;
        $_SESSION['password'] = $password;
        // Redirect to dashboard or desired page
        header("Location:../../application files/dashboard.php");
        exit();
    } else {
        // Invalid credentials, display error message
        echo "Invalid email or password.";
    }
}else{
    echo "Please input the correct login credentials!";
}

// Close connection
$conn->close();