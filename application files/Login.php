<?php
// Start session
session_start();
// Database connection parameters
include '../assets/php/conn.php';

// // Create connection
// $conn = new mysqli($servername, $username, $password, $database);

// Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// Check if the form is submitted
if (isset($_POST['email']) && isset($_POST['password'])) {
    // Retrieve form data
    echo"it reaches this point";
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Perform SQL query to check user credentials
    $sql = "SELECT * FROM users WHERE EmailAddress = '$email' AND Password = '$password'";
    $result = $conn->query($sql);
    
    // Check if user exists
    if ($result->num_rows > 0) {
        // User authenticated successfully, set session variables
        $_SESSION['email'] = $email;
        // Redirect to dashboard or desired page
        header("Location: index.html");
        exit();
    } else {
        // Invalid credentials, display error message
        echo "Invalid email or password.";
    }
}

// Close connection
$conn->close();
?>
