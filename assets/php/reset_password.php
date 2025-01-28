<?php

include 'conn.php';

require "vendor/autoload.php";
require "vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

    $token = $_GET["token"];
    $token_hash = hash("sha256", $token);
    $sql = "SELECT * FROM users
            WHERE reset_token_hashed = ?";

    $stmt = $conn->prepare($sql);
    $stmt-> bind_param("s", $token);

    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user === null) {
        die("token not found!");
    }

    if(strtotime($user["reset_token_expires_at"]) <= time()){
        die("token has expired");
    }

    echo "token is valid and hasn't expired";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset Password</h1>

    <form method="post" action="process-reset-password.php">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

        <label for="password">New passsword</label><label for=""></label>
        <input type="password" id="password" name="password">
        
        <label for="password_confirmation">Reset password</label>
        <input type="password" id="password_confirmation" name="password_confirmation">

        <button>Send</button>

    </form>
</body>
</html>