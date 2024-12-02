<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliography Information Form</title>
    <link href="../assets/img/favicon.webp" rel="icon">
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <h2>Bibliography Information Form</h2>
    <form id ="" action="../assets/php/db_connect.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" required>

        <label for="author_name">Author's Name:</label>
        <input type="text" id="author_name" name="author_name" required><br><br>

        <label for="author_pseudonym">Author's Pseudonym:</label>
        <input type="text" id="author_pseudonym" name="author_pseudonym" required><br><br>

        <label for="editor_name">Editor's Name:</label>
        <input type="text" id="editor_name" name="editor_name" required><br><br>

        <label for="title_of_publication">Title of Publication:</label>
        <input type="text" id="title_of_publication" name="title_of_publication" required><br><br>

        <label for="edition">Edition:</label>
        <input type="text" id="edition" name="book_edition" required><br><br>

        <label for="impression">Impression:</label>
        <input type="text" id="impression" name="impression" required><br><br>

        <label for="isbn_electronic">ISBN of Electronic Book:</label>
        <input type="text" id="isbn_electronic" name="isbn_electronic" required><br><br>

        <label for="set_isbn">Set ISBN:</label>
        <input type="text" id="set_isbn" name="set_isbn" required><br><br>

        <label for="publisher_name">Publisher's Name:</label>
        <input type="text" id="publisher_name" name="publisher_name" required><br><br>

        <label for="publisher_address">Publisher's Address:</label>
        <input type="text" id="publisher_address" name="publisher_address" required><br><br>

        <label for="publication_year">Publication Year:</label>
        <input type="number" id="publication_year" name="publication_year" required><br><br>

        <label for="price">Price (Rand):</label>
        <input type="number" step="0.01" id="price" name="price" required><br><br>

        <label for="fiction_or_nonfiction">Fiction or Nonfiction:</label>
        <input type="text" id="fiction_or_nonfiction" name="fiction_or_nonfiction" required><br><br>

        <label for="genre">Genre:</label>
        <input type="text" id="genre" name="genre" required><br><br>

        <label for="language_of_publication">Language of Publication:</label>
        <input type="text" id="language_of_publication" name="language_of_publication" required><br><br>

        <label for="english_translation_title">English Translation of Title:</label>
        <input type="text" id="english_translation_title" name="english_translation_title" required><br><br>

        <label for="file">Upload File:</label>
        <input type="file" id="file" name="file" required>       
      <button type="submit">Submit</button>
    </form>
</body>
</html>