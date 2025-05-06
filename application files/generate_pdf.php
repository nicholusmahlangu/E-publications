<?php
//include package
//include('TCPDF/tcpdf.php');
include('../assets/php/conn.php');
$book_id = $_GET['Book_ID'];

$filepath = '../uploads/'.'67dc0fae84bc7_S2_Capeto0002 - Extension - 124023009.pdf';
//$file = $filepath;

 header('Content-type: application/pdf');
 header('Content-Description:inline;filename="'.$filepath.'"');
 header('Content-Transfer-Enconding:binary');
 header('Accept-Ranges:bytes');

 @readfile($filepath);

?>
