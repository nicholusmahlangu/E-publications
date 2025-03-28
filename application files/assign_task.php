<?php 
    require_once('../assets/php/conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Book_ID'], $_POST['cataloguer_id'])) {
    $bookId = $_POST['Book_ID'];
    $cataloguerId = $_POST['cataloguer_id'];

    // Check if the book is already assigned
    $checkQuery = "SELECT * FROM Assignments WHERE book_id = '$bookId'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo "This book is already assigned.";
        exit;
    }

    // Insert into Assignments table
    $assignQuery = "INSERT INTO Assignments (book_id, cataloguer_id, status, assigned_at) 
                    VALUES ('$bookId', '$cataloguerId', 'Assigned', NOW())";
    if (mysqli_query($conn, $assignQuery)) {
        // Update book status
        $updateBookQuery = "UPDATE book_informationsheet SET status = 'Assigned' WHERE Book_ID = '$bookId'";
        mysqli_query($conn, $updateBookQuery);

        // Insert into notifications table
        $title = "New Task Assigned";
        $description = "A new task has been assigned for Book ID: $bookId.";
        $notificationQuery = "INSERT INTO notifications (title, description, type, date, created_at, cataloguer_id) 
                              VALUES ('$title', '$description', 'task', NOW(), NOW(), '$cataloguerId')";
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
