<?php

$serverName = "PMF\SQLEXPRESS";
$ConnectionOptions = [
    "Database" => "nlsa_db",
    "Uid" => "",
    "PWD" => ""
];

$conn = sqlsrv_connect($serverName, $ConnectionOptions);

if ($conn == false) {
    die(print_r(sqsrvl_errors(), true));
}else{
    echo 'Connection succeeded!';
}
// Database connection details


// // Create connection

// $conn = new mysqli($servername, $database, $password);

 

// // Check connection

// if ($conn->connect_error) {

//     die("Connection failed: " . $conn->connect_error);

// }

 

// // Function to fetch data from the database

// function fetchData() {

//     global $conn;

//     $result = $conn->query("SELECT * FROM dbo.Book_InformationSheet");

   

//     // Check if there is data in the table

//     if ($result->num_rows > 0) {

//         while ($row = $result->fetch_assoc()) {

//             echo "<p>Name: " . $row['author_name'] . " - Email: " . $row['email'] . "</p>";

//         }

//     } else {

//         echo "No data found";

//     }

// }

 

// // Function to insert data into the database

// function insertData($author_name, $email, $author_pseudonym, $editor_name, $title_of_publication, $book_edition, $impression, $isbn_electronic, $set_isbn, $publisher_name, $publisher_address, $publication_year, $price, $fiction_or_nonfiction, $genre, $language_of_publication, $english_translation_title, $file_upload) {

//     global $conn;

//     $stmt = $conn->prepare("INSERT INTO dbo.Book_InformationSheet ( email, author_name, author_pseudonym, editor_name, title_of_publication, book_edition, impression, isbn_electronic, set_isbn, publisher_name, publisher_address, publication_year, price, fiction_or_nonfiction, genre, language_of_publication, english_translation_title, file_upload) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

//     $stmt->bind_param("ssssssssssssssssss", $author_name, $email, $author_pseudonym, $editor_name, $title_of_publication, $book_edition, $impression, $isbn_electronic, $set_isbn, $publisher_name, $publisher_address, $publication_year, $price, $fiction_or_nonfiction, $genre, $language_of_publication, $english_translation_title, $file_upload);

 

//     // Sample data

//     $name = "John Doe";

//     $email = "john@example.com";

 

//     if ($stmt->execute() === TRUE) {

//         echo "Data inserted successfully";

//     } else {

//         echo "Error: " . $stmt->error;

//     }

 

//     $stmt->close();

// }

 

// // Close the database connection

// $conn->close();

?>
