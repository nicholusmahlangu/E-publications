<?php
session_start();

// If admin is already logged in, redirect to dashboard
if (isset($_SESSION['admin_id'])) {
    header("Location: adminDashboard.php");
    exit();
}

// Generate CSRF Token for Form Security
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin login - E-pubs</title>

        <!-- Tab Icon -->
        <link href="../assets/img/favicon.webp" rel="icon">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" 
      rel="stylesheet" 
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" 
      crossorigin="anonymous">

<!-- Bootstrap Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" 
      rel="stylesheet">

<!-- Ion Icons -->
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>


    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/login.css">

    <style>
        
        /* Footer styling */
        footer {
            text-align: bottom; /* Center align the content */
            background-color: #f8f9fa; /* Light background color */
            padding: 20px; /* Add some padding */
        }

            footer img {
                max-width: 100%; /* Responsive image */
                height: auto; /* Preserve aspect ratio */
                margin-bottom: 10px; /* Add space between the image and copyright text */
            }
    </style>
</head>

<body>

    <!-- Home Button Icon -->
    <a href="index.php" class="home-icon">
        <i class="bi bi-house-fill"></i> Home
    </a>

     <!-- Admin Login Button -->
     <a href="cataloguerlogin.php" class="admin-login-button">
        <i class="bi bi-person-circle"></i> Cataloguer Login
    </a>

    <!-- Login Form Section -->
    <div class="sid d-flex flex-wrap justify-content-between align-items-center">

        <!-- Logo and Heading -->
        <div class="container text-center logo-container">
            
            <img src="../assets/img/NLSA-logo.png" class="logo-img" alt="NLSA Logo"style="width:22%; height:22%">
            <h1 class="system-heading">Electronic Publications</h1>
        </div>

    <!-- Left Side with Illustration -->
        <div class="side-left">
            <img src="../assets/img/photo 5.png" alt="Illustration" class="img-fluid">
        </div>

        <!-- Right Side with Form -->
        <div class="side-right">
            <h4 class="text-center mb-4">Administrator</h4>

            <form class="sub-form" method="post" action="../assets/php/adminlogin.php">
                <!-- Email Input -->
                <div class="input-group mb-3">
                    <span class="input-group-text">
                      <ion-icon name="mail"></ion-icon>
                    </span>
                    <input type="email" id="email" name="email" class="form-control" 
                           placeholder="Enter your email" required>
                </div>

                <!-- Password Input -->
                <div class="input-group mb-3">
                    <span class="input-group-text">
                      <ion-icon name="lock-closed"></ion-icon>
                    </span>
                    <input type="password" id="password" name="password" class="form-control" 
                           placeholder="Enter your password" required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="button1 btn btn-primary mt-4 w-100">
                    Admin Login
                </button>

            </form>
        </div>
    </div>

    <!-- Footer -->

    <!-- Footer section with image 
    <footer>
    <img src="../assets/img/Building.png" class="logo-img" alt="NLSA Logo"style="width:30%; height:30%">
        <p>&copy; 2025 National Library of South Africa. All rights reserved.</p>
    </footer>
-->
    <script src="../assets/js/login.js"></script>
</body>
</html>
