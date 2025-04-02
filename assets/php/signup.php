<?php
session_start();
include 'conn.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = trim($_POST['fullname'] ?? '');
    $email_address = trim($_POST['email_address'] ?? '');
    $contact = trim($_POST['contact'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($fullname) || empty($email_address) || empty($contact) || empty($password)) {
        $_SESSION['error'] = "Please fill all fields.";
        header("Location: ../../application files/signup.php");
        exit;
    }

    if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: ../../application files/signup.php");
        exit;
    }

    // Password validation (Minimum 8 characters, at least one uppercase letter, one number, and one special character)
    if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W]).{8,}$/', $password)) {
        $_SESSION['error'] = "Password must be at least 8 characters long, contain one uppercase letter, one number, and one special character.";
        header("Location: ../../application files/signup.php");
        exit;
    }

    if ($conn && $conn->ping()) {
        // Check for duplicate email
        $stmt = $conn->prepare("SELECT * FROM users WHERE EmailAddress = ?");
        $stmt->bind_param("s", $email_address);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['error'] = "Email already registered.";
            header("Location: ../../application files/signup.php");
            exit;
        }

        $stmt->close();

        // Secure password hashing
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO users (FullName, EmailAddress, Contact, Password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $fullname, $email_address, $contact, $hashed_password);

        if ($stmt->execute()) {
            $_SESSION['status'] = "Registration successful!";
            header("Location: ../../application files/signup.php");
            exit;
        } else {
            $_SESSION['error'] = "Database error. Try again.";
            header("Location: ../../application files/signup.php");
            exit;
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = "Database connection error.";
        header("Location: ../../application files/signup.php");
        exit;
    }
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: ../../application files/signup.php");
    exit;
}
