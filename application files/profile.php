<?php
// Start session
session_start();

// Include database connection
include '../assets/php/conn.php';

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: cataloguerlogin.php");
    exit();
}

// Fetch user details from the database
$email = $_SESSION['email'];
$profile = [];
$message = "";

try {
    // Fetch user profile from the database
    $stmt = $conn->prepare("SELECT FullName, EmailAddress, Contact FROM users WHERE EmailAddress = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $profile = $result->fetch_assoc();
    } else {
        $message = "Profile not found.";
    }
    $stmt->close();
} catch (Exception $e) {
    error_log("Error fetching profile: " . $e->getMessage());
    $message = "An error occurred while loading your profile.";
}

// Handle form submission for profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['fullName']);
    $contact = trim($_POST['contact']);

    if (!empty($fullName) && !empty($contact)) {
        try {
            $updateStmt = $conn->prepare("UPDATE users SET FullName = ?, Contact = ? WHERE EmailAddress = ?");
            $updateStmt->bind_param("sss", $fullName, $contact, $email);

            if ($updateStmt->execute()) {
                $message = "Profile updated successfully!";
                $profile['FullName'] = $fullName;
                $profile['Contact'] = $contact;
            } else {
                $message = "Failed to update profile. Please try again.";
            }
            $updateStmt->close();
        } catch (Exception $e) {
            error_log("Error updating profile: " . $e->getMessage());
            $message = "An error occurred while updating your profile.";
        }
    } else {
        $message = "All fields are required.";
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('../assets/img/BackgroundI.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        @media (max-width: 768px) {
            .container {
                margin: 20px auto;
                padding: 15px;
            }
        }

        .sidebar {
      background-color: #233245;
      color: white;
      min-height: 100vh;
      width: 200px;
    }
    .sidebar a {
      color: white;
      text-decoration: none;
      padding: 10px 15px;
      display: block;
      font-weight: bold;
    }
    .sidebar a:hover {
      background: #495057;
      border-radius: 5px;
    }
    </style>
</head>


<body>
<!-- Sidebar -->
<nav class="col-md-3 col-lg-2 d-md-block sidebar" style="position: fixed; top: 0; left: 0; height: 100vh;">
<h3 class="text-center py-3">Dashboard</h3>
<ul class="nav flex-column">
<li class="nav-item"><a href="dashboard.php" class="nav-link">Dashboard</a></li>
<li class="nav-item"><a href="profile.php" class="nav-link">Profile</a></li>
<li class="nav-item"><a href="notifications.php" class="nav-link">Notifications</a></li>
<li class="nav-item"><a href="view.php" class="nav-link">Document Management</a></li>
<li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>
</ul>
</nav>

<center>
<h1></h1>
<img src="../assets/img/NLSA-logo.png" class="logo-img" alt="NLSA Logo" style="width:18%; height:18%">
</center>
<div class="container" style="margin-left: 250px;">


<h2 class="text-center mb-4">Your Profile</h2>
<?php if (!empty($message)): ?>
<div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>
<form action="profile.php" method="POST">
<div class="mb-3">
<label for="fullName" class="form-label">Full Name</label>
<input type="text" class="form-control" id="fullName" name="fullName" value="<?= htmlspecialchars($profile['FullName'] ?? '') ?>" required>
</div>
<div class="mb-3">
<label for="email" class="form-label">Email Address</label>
<input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($profile['EmailAddress'] ?? '') ?>" readonly>
</div>
<div class="mb-3">
<label for="contact" class="form-label">Contact Number</label>
<input type="text" class="form-control" id="contact" name="contact" value="<?= htmlspecialchars($profile['Contact'] ?? '') ?>" required>
</div>
<div class="text-center">
<button type="submit" class="btn btn-primary">Update Profile</button>
</div>
</form>
</div>
</body>

</html>
