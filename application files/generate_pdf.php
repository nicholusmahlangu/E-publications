<?php
include('../assets/php/conn.php');
$bookID = $_GET['Book_ID'];

$stmt = $conn->prepare("SELECT FileUpload FROM book_informationsheet WHERE Book_ID = ? LIMIT 1");
$stmt->bind_param("i", $bookID);
$stmt->execute();
$result = $stmt->get_result();
$profile = $result->fetch_assoc();
echo (string)$profile['FileUpload'];

$filepath = '../uploads/';
$filepath .= (string)$profile['FileUpload'];

  header('Content-type: application/pdf');
  header('Content-Description:inline;filename="'.$filepath.'"');
  header('Content-Transfer-Enconding:binary');
  header('Accept-Ranges:bytes');

 @readfile($filepath);
 $stmt->close();

?>