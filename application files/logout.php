<?php
// Start the session
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection file
include '../assets/php/conn.php';

// Generate CSRF token if not already set
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

// Handle logout POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sessionToken = $_SESSION['csrf_token'] ?? null; // Retrieve session token
    $postToken = $_POST['csrf_token'] ?? null;      // Retrieve posted token

    // Validate CSRF token
    if (!$sessionToken || !$postToken || !hash_equals($sessionToken, $postToken)) {
        http_response_code(403);
        die('Invalid CSRF token.');
    }

    try {
        // Log user logout event if user is logged in
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $stmt = $pdo->prepare("INSERT INTO logout_logs (user_id, logout_time) VALUES (?, NOW())");
            $stmt->execute([$userId]);
        }
    } catch (Exception $e) {
        error_log("Logout logging failed: " . $e->getMessage());
    }

    // Clear session and destroy
    session_unset();
    session_destroy();

    // Redirect to the welcome page
    header('Location: ../../application files/index.php?logout=success');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Global Styling */
        body {
            font-family: "Poppins", sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f5f5f5;
            text-align: center;
            padding: 20px;
        }

        /* Back Button */
        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 16px;
            text-decoration: none;
            color: #333;
            padding: 8px 12px;
            border-radius: 5px;
            transition: 0.3s ease;
            font-weight: 500;
        }

        .back-button:hover {
            color: #007bff;
        }

        /* Logo Styling */
        .logo-container {
            width: 100%;
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-img {
            width: 18%;
            max-width: 150px;
            height: auto;
        }

        /* Logout Container */
        .logout-container {
            max-width: 400px;
            width: 100%;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        /* Logout Button */
        button {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            background: #007bff;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s ease;
        }

        button:hover {
            background: #0056b3;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .logout-container {
                padding: 20px;
                width: 90%;
            }
            .logo-img {
                width: 25%;
            }
        }
    </style>
</head>
<body>

    <!-- Back Button -->
    <a href="javascript:history.back()" class="back-button">← Back</a>

    <!-- Logo -->
    <div class="logo-container">
        <img src="../assets/img/NLSA-logo.png" class="logo-img" alt="NLSA Logo">
    </div>

    <!-- Logout Confirmation -->
    <div class="logout-container">
        <h1>Are you sure you want to log out?</h1>
        <form action="index.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
            <button type="submit">Logout</button>
        </form>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
