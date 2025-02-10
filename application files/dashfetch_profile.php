<?php
session_start();
include '../assets/php/conn.php'; // Database connection

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['User_ID'])) {
    echo json_encode(["success" => false, "message" => "User not logged in"]);
    exit();
}

$user_id = $_SESSION['User_ID'];

// Fetch user details from the database
$sql = "SELECT FullName, EmailAddress FROM users WHERE User_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo json_encode([
        "success" => true,
        "fullname" => $user['FullName'],
        "email" => $user['EmailAddress']
    ]);
} else {
    echo json_encode(["success" => false, "message" => "User not found"]);
}

$stmt->close();
$conn->close();
?>
