<?php
session_start();
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === "" || $password === "") {
        echo "Please input the correct login credentials!";
        exit;
    }

    if ($conn && $conn->ping()) {
        // Use prepared statement with error checking
        $stmt = $conn->prepare("SELECT User_ID, EmailAddress, Password FROM users WHERE EmailAddress = ?");
        if ($stmt === false) {
            die("Prepare failed: " . htmlspecialchars($conn->error));
        }
        
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Verify password
            if (password_verify($password, $row['Password'])) {
                // Set session variables
                $_SESSION['email'] = $row['EmailAddress'];
                $_SESSION['user_id'] = $row['User_ID']; // store user id instead of password
                header("Location: ../../application files/dashboard.php");
                exit;
            }
        }
        echo "Invalid email or password.";
        exit;
    } else {
        echo "Database connection error.";
        exit;
    }
} else {
    echo "Invalid request method.";
    exit;
}
