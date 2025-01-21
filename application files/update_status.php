<?php
<<<<<<< HEAD
// Start session for feedback messages
session_start();

=======
>>>>>>> main
// Database connection
$host = 'localhost';
$dbname = 'e-pubsdb';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

<<<<<<< HEAD
// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate required POST fields
    if (isset($_POST['Book_ID'], $_POST['status'])) {
        $bookId = (int)$_POST['Book_ID']; // Ensure Book_ID is an integer
        $status = trim($_POST['status']); // Sanitize status input

        // Valid status values
        $validStatuses = ['Assigned', 'Pending', 'Reviewed'];

        if (in_array($status, $validStatuses, true)) {
            try {
                // Update the status in the database
                $query = "UPDATE book_informationsheet SET status = :status WHERE Book_ID = :bookId";
                $stmt = $pdo->prepare($query);
                $stmt->bindValue(':status', $status, PDO::PARAM_STR);
                $stmt->bindValue(':bookId', $bookId, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    // Success feedback
                    $_SESSION['success'] = "Status updated successfully for Book ID $bookId.";
                } else {
                    throw new Exception("Failed to update status for Book ID $bookId.");
                }
            } catch (Exception $e) {
                // Handle exceptions
                $_SESSION['error'] = $e->getMessage();
            }
        } else {
            // Invalid status value
            $_SESSION['error'] = "Invalid status value.";
        }
    } else {
        // Missing required POST fields
        $_SESSION['error'] = "Required fields are missing.";
    }
} else {
    // Invalid request method
    $_SESSION['error'] = "Invalid request: Request method is not POST.";
}

// Redirect back to the viewStatus.php page
header('Location: view.php');
exit;
=======
// Validate POST data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Book_ID'], $_POST['status'])) {
    $bookId = $_POST['Book_ID'];
    $status = $_POST['status'];

    // Update the status
    $query = "UPDATE book_informationsheet SET status = :status WHERE Book_ID = :bookId";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':status', $status, PDO::PARAM_STR);
    $stmt->bindValue(':bookId', $bookId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header('Location: view.php'); // Redirect back to the view page
        exit;
    } else {
        echo "Error updating status.";
    }
} else {
    echo "Invalid request.";
}
>>>>>>> main
?>
