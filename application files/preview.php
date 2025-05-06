<?php
//include package
//include('TCPDF/tcpdf.php');
include('../assets/php/conn.php');
$book_id = $_GET['Book_ID'];

 $sqlComm = $conn->prepare("SELECT FileUpload FROM book_informationsheet WHERE Book_ID = ?");
$sqlComm->bind_param("i", $book_id);
$sqlComm->execute();
$result = $sqlComm->get_result();
$row = mysqli_fetch_array($result);


$filepath = '../uploads/';
$file1 = (string)$row;
$file = $filepath . $file1;

header('Content-type: application/pdf');
header('Content-Description:inline;filename="'.$file.'"');
header('Content-Transfer-Enconding:binary');
header('Accept-Ranges:bytes');

@readfile($file);

//echo $file;
?>

