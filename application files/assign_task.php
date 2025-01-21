<?php
require_once('../assets/php/conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Book_ID'], $_POST['cataloguer_id'])) {
    $bookId = mysqli_real_escape_string($conn, $_POST['Book_ID']);
    $cataloguerId = mysqli_real_escape_string($conn, $_POST['cataloguer_id']);

    // Check if the cataloguer exists
    $validateCataloguerQuery = "SELECT User_ID FROM users WHERE User_ID = '$cataloguerId'";
    $validateCataloguerResult = mysqli_query($conn, $validateCataloguerQuery);
    if (mysqli_num_rows($validateCataloguerResult) === 0) {
        echo "Invalid cataloguer ID.";
        exit;
    }

    // Check if the book is already assigned
    $checkQuery = "SELECT * FROM assignments WHERE book_id = '$bookId'";
    $checkResult = mysqli_query($conn, $checkQuery);
    if (mysqli_num_rows($checkResult) > 0) {
        echo "This book is already assigned.";
        exit;
    }

    // Assign the task
    $assignQuery = "INSERT INTO assignments (book_id, cataloguer_id, status) VALUES ('$bookId', '$cataloguerId', 'Assigned')";
    if (mysqli_query($conn, $assignQuery)) {
        // Update book status
        $updateBookQuery = "UPDATE book_informationsheet SET status = 'Assigned' WHERE Book_ID = '$bookId'";
        mysqli_query($conn, $updateBookQuery);

        // Create notification for the cataloguer
        $notificationTitle = "New Task Assigned";
        $notificationDescription = "A new task has been assigned for Book ID: $bookId.";
        $notificationQuery = "INSERT INTO notifications (cataloguer_id, type, title, description) 
                              VALUES ('$cataloguerId', 'task', '$notificationTitle', '$notificationDescription')";
        mysqli_query($conn, $notificationQuery);

        header("Location: viewStatus.php");
        exit;
    } else {
        echo "Error assigning task: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>
