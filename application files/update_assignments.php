<?php
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

// Validate POST data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_id'], $_POST['status'])) {
    $bookId = intval($_POST['book_id']); // Ensure integer value
    $status = trim($_POST['status']);

    try {
        $pdo->beginTransaction(); // Start transaction

        // Check if book_id exists in `assignments`
        $checkQuery = "SELECT COUNT(*) FROM assignments WHERE book_id = :bookId";
        $checkStmt = $pdo->prepare($checkQuery);
        $checkStmt->bindValue(':bookId', $bookId, PDO::PARAM_INT);
        $checkStmt->execute();
        $exists = $checkStmt->fetchColumn();

        if ($exists) {
            //Update status if book_id exists
            $updateQuery = "UPDATE assignments SET status = :status WHERE book_id = :bookId";
            $stmt = $pdo->prepare($updateQuery);
            $stmt->bindValue(':status', $status, PDO::PARAM_STR);
            $stmt->bindValue(':bookId', $bookId, PDO::PARAM_INT);
            $stmt->execute();

            $pdo->commit(); // Commit transaction
            echo "Status updated successfully!";
        } else {
            echo "Error: Book ID not found in assignments.";
        }
    } catch (PDOException $e) {
        $pdo->rollBack(); // Rollback if error occurs
        echo "Error updating status: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
