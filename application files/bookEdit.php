<?php 
    include "../assets/php/conn.php";
    $book_id = $_GET['Book_ID'];
        
    if (isset($_POST['submit'])) {
        
        $publisher_email = $_POST['PublisherEmail'];
        $author_name = $_POST['AuthorName'];
        $author_pseudonym = $_POST["AuthorPseudonym"];
        $editor_name = $_POST["EditorName"];
        $publication_title = $_POST["PublicationTitle"];
        $book_edition = $_POST["BookEdition"];
        $impression = $_POST["Impression"];
        $isbn = $_POST["ISBN"];
        $set_isbn = $_POST["SetISBN"];
        $publisher_name = $_POST["PublisherName"];
        $publisher_address = $_POST["PublisherAddress"];
        $publication_year = $_POST["PublisherYear"];
        $price = $_POST["Price"];
        $fiction_or_non = $_POST["FictionOrNonFiction"];
        $genre = $_POST["Genre"];
        $publication_language = $_POST["PublicationLangauge"];  
        $english_title = $_POST["EnglishVersionTitle"];
        $file_upload = $_POST["FileUpload"];

        $sql = "UPDATE `book_informationsheet` SET `BookEdition`='$book_edition',`Price` = '$price', 
        `FictionOrNonFiction`=$fiction_or_nonfiction,`Impression`='$impression',`SetISBN`='$set_isbn',
        `PublisherYear`='$publication_year' WHERE Book_ID=$book_id";
        $bookUpdate = mysqli_query($conn, $sql);
    
        if ($bookUpdate) {
            header("Location: bookDetails.php?msg=Book record has been updated successfully!");
        }
        else{
            echo "Failed: " . mysqli_error($conn);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Update books</title>
</head>
<body>
    <nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="background-color: #00ff5573;">
        NLSA Electronic Publications
    </nav>

    <div class="container">
        <div class="text-center mb-4">
            <h3>Update SANB Electronic Book Information</h3>
            <p class="text-muted">Click update after changing any information</p>
        </div>

        <?php 
            $sql = "SELECT * FROM `book_informationsheet` WHERE Book_ID = $book_id LIMIT 1";
            $editResult = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($editResult);
        ?>
        <div class="container_d-flex_justify-content-center">
            <form action="" method="POST" style="width:50vw; min-width:300px;">
                <div class="row_mb-3">
                    
                    <div class="col">
                        <label class="form-label">Publisher Email Address</label>
                        <input type="email" class="form-control" name="PublisherEmail" value="<?php echo $row['PublisherEmail'] ?>" readonly>
                    </div>
                    
                    <div class="col">
                        <label class="form-label">Author Fullname:</label>
                        <input type="text" class="form-control" name="AuthorName" value="<?php echo $row['AuthorName'] ?>" readonly>
                    </div>
                    
                    <div class="col">
                        <label class="form-label">Author Pseudonym:</label>
                        <input type="text" class="form-control" name="AuthorPseudonym" value="<?php echo $row['AuthorPseudonym'] ?>">
                    </div>
                    
                    <div class="col">
                        <label class="form-label">Editor Fullname:</label>
                        <input type="text" class="form-control" name="editor_name" value="<?php echo $row['EditorName'] ?>" readonly>
                    </div>
                    
                    <div class="col">
                        <label class="form-label">Title of Publication:</label>
                        <input type="text" class="form-control" name="publication_title" value="<?php echo $row['PublicationTitle'] ?>" readonly>
                    </div>
                    
                    <div class="col">
                        <label class="form-label">Book Edition:</label>
                        <input type="text" class="form-control" name="book_edition" value="<?php echo $row['BookEdition'] ?>" readonly>
                    </div>
                    
                    <div class="col">
                        <label class="form-label">Impression:</label>
                        <input type="text" class="form-control" name="impression" value="<?php echo $row['Impression'] ?>">
                    </div>

                    <div class="col">
                        <label class="form-label">ISBN:</label>
                        <input type="text" class="form-control" name="isbn" value="<?php echo $row['Isbn'] ?>" readonly>
                    </div>

                    <div class="col">
                        <label class="form-label">Set ISBN:</label>
                        <input type="text" class="form-control" name="set_isbn" value="<?php echo $row['SetISBN'] ?>">
                    </div>

                    <div class="col">
                        <label class="form-label">Publisher Fullname:</label>
                        <input type="text" class="form-control" name="publisher_name" value="<?php echo $row['PublisherName'] ?>" readonly>
                    </div>

                    <div class="col">
                        <label class="form-label">Publisher Address:</label>
                        <input type="text" class="form-control" name="publisher_address" value="<?php echo $row['PublisherAddress'] ?>">
                    </div>

                    <div class="col">
                        <label class="form-label">Year of publication:</label>
                        <input type="text" class="form-control" name="publication_year" value="<?php echo $row['PublicationYear'] ?>" readonly>
                    </div>

                    <div class="col">
                        <label class="form-label">Price:</label>
                        <input type="text" class="form-control" name="price" value="<?php echo $row['Price'] ?>">
                    </div>

                    <div class="col">
                        <label class="form-label">Fiction Or Non-fiction:</label>
                        <input type="text" class="form-control" name="fictionOrNonFiction" value="<?php echo $row['FictionOrNonFiction'] ?>">
                    </div>

                    <div class="col">
                        <label class="form-label">Genre:</label>
                        <input type="text" class="form-control" name="genre" value="<?php echo $row['Genre'] ?>">
                    </div>

                    <div class="col">
                        <label class="form-label">Language of Publication:</label>
                        <input type="text" class="form-control" name="publication_language" value="<?php echo $row['PublicationLanguage'] ?>" readonly>
                    </div>

                    <div class="col">
                        <label class="form-label"><em>English Translation of Title(if the book is written in another language):</em></label>
                        <input type="text" class="form-control" name="englishTransTitle" value="<?php echo $row['EnglishVersionTitle'] ?>">
                    </div>
                </div>
                
                <div class="col">
                        <label class="form-label">File Uploaded:</label>
                        <input type="text" class="form-control" name="fileuploaded" value="<?php echo $row['FileUpload'] ?>" readonly>
                </div>

                <div>
                    <button type="submit" class="btn btn-success" name="submit">Update</button>
                    <a href="bookDetails.php" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>

    </div>
      <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>
</html>