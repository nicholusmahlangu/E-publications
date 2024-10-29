<?php

// Database connection settings

//$host = "PMF\SQLEXPRESS"; // Change this if your database server is running on a different host

//$username = "NLSA\Nicholus"; // Default username for XAMPP MySQL

//$password = ""; // Default password for XAMPP MySQL is empty

//$database = "nlsa_db"; // Change this to your database name

 

// Create connection

//$conn = new mysqli($host, $username, $password, $database);

 

// Check connection

//if ($conn->connect_error) {

  //  die("Connection failed: " . $conn->connect_error);

//} else {

  //  echo "Connected successfully";

//}

 

// Close connection

//$conn->close();
include("db_connect.php");
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
print_r($request);

function getData(){
    $data = array();
    $data[1] = $_POST['email'];
    $data[2] = $_POST['author_name'];
    $data[3] = $_POST['author_pseudonym'];
    $data[4] = $_POST['editor_name'];
    $data[5] = $_POST['title_of_publication'];
    $data[6] = $_POST['book_edition'];
    $data[7] = $_POST['impression'];
    $data[8] = $_POST['isbn_electronic'];
    $data[9] = $_POST['set_isbn'];
    $data[10] = $_POST['publisher_name'];
    $data[11] = $_POST['publisher_address'];
    $data[12] = $_POST['publication_year'];
    $data[13] = $_POST['price'];
    $data[14] = $_POST['fiction_or_nonfiction'];
    $data[15] = $_POST['genre'];
    $data[16] = $_POST['language_of_publication'];
    $data[17] = $_POST['english_translation_title'];
    $data[18] = $_POST['file_upload'];
    return $data;
}

if(isset($_POST['insert'])){
    $info = getData();
    $insert = "INSERT INTO [Book_InformationSheet]([Book_Id]
      ,[Publisher_email]
      ,[Author_Names]
      ,[Author_Pseudonym]
      ,[Editor_Name]
      ,[Publication_Title]
      ,[Edition]
      ,[Impression]
      ,[Book_ISBN]
      ,[Set_ISBN]
      ,[Publisher_Name]
      ,[Publisher_Address]
      ,[Publication_Year]
      ,[Price]
      ,[Fiction_Or_NonFiction]
      ,[Genre]
      ,[Publication_langauge]
      ,[English_Title_version]
      ,[Book_Upload]) VALUES('$info[1]', '$info[2]', '$info[3]', '$info[4]', '$info[5]', '$info[6]', '$info[7]', '$info[8]', '$info[9]', '$info[10]', '$info[11]', '$info[12]', '$info[13]', '$info[14]', '$info[15]', '$info[16]', '$info[17]', '$info[18]')";
    $exe_stmt = odbc_exec($connection, $insert);
}

?>