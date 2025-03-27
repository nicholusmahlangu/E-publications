<?php include 'forms_header.php';
include '../assets/php/conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<title>Bibliography Information Form</title>
    <link href="../assets/img/favicon.webp" rel="icon">-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!--<link rel="stylesheet" href="../assets/css/styles.css">-->
   <!-- JavaScript Validation -->
   <!--<script defer src="../assets/js/validation.js"></script>-->

       <!-- Inline Styles for Background -->
       <style>
        body {
            background-image: url('../assets/img/BackgroundI.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #333
        }

       /* @keyframes backgroundAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }*/




        input, select, button {
            width: 100%;
            margin-top: 5px;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        button[type="submit"] {
            background-color: #0066cc;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #004c99;
        }

        h2 {
            margin-top: 60px;
            padding-bottom: 20px;
            /*margin-top: 1px;*/
            text-align: center;
        }

        .alert {
            max-width: 600px;
            width: 100%;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ff4d4d;
            background-color: #ffcccc;
            color: #900;
            border-radius: 5px;
            text-align: center;
        }
        .logo-img{
            margin-top: 110px;
        }
    </style>
</head>
<body>

<center>
            <img src="../assets/img/NLSA-logo.png" class="logo-img" alt="NLSA Logo"style="width:24%; height:20%">
        </center>
    <h1 class="text-center mb-4">Bibliography Information Form</h1>
    
        <!-- Display server-side error messages if any -->
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($_SESSION['error_message']); ?>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>
        
            <form id ="" action="../assets/php/db_connect.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">

            <label for="ISBNtype"> Book ISBN formats type:</label>
                <select id="ISBNtype" name="ISBNtype" required>
                    <option value="" disabled selected>Select ISBN Format</option>
                    <option value="Electronic">Electronic</option>
                    <option value="Print">Print</option>
                    <option value="Mobi">Mobi</option>
                    <option value="Epub">Epub</option>
                </select>
                <label for="isbn_electronic">ISBN of a Book:</label>
                <input type="text" id="isbn_electronic" name="isbn_electronic" required pattern="\d{13}" placeholder="Enter 13-digit ISBN">

                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" required placeholder="example@example.com">

                <label for="author_name">Author's Name:</label>
                <input type="text" id="author_name" name="author_name" required placeholder="Enter Author's Name">

                <label for="author_pseudonym">Author's Pseudonym:
                <span style="cursor: pointer;" title="A pseudonym is a fictitious name used by an author instead of their real name."> 
                <i class="fa fa-info-circle" aria-hidden="true"></i>
                </span></label>
                <input type="text" id="author_pseudonym" name="author_pseudonym" placeholder="Enter Pseudonym (optional)">

                <label for="editor_name">Editor's Name:</label>
                <input type="text" id="editor_name" name="editor_name" required placeholder="Enter Editor's Name">

                <label for="title_of_publication">Title of Publication:</label>
                <input type="text" id="title_of_publication" name="title_of_publication" required placeholder="Enter Title">

                <label for="edition">Edition:</label>
                <input type="text" id="edition" name="book_edition" required placeholder="Enter Edition">

                <label for="impression">Impression:
                <span style="cursor: pointer;" title="reprinting the same book with the same ISBN."> 
                <i class="fa fa-info-circle" aria-hidden="true"></i>
                </span></label>
                <input type="text" id="impression" name="impression" placeholder="Enter Impression">

                <label for="set_isbn">Set ISBN:
                <span style="cursor: pointer;" title="When a publisher assembles a set of books to sell as a special offer, they can assign an ISBN to the set if it is required to identify the set in the supply chain for marketing and ordering purposes."> 
                <i class="fa fa-info-circle" aria-hidden="true"></i>
                </span></label>
                <input type="text" id="set_isbn" name="set_isbn" placeholder="Enter Set ISBN">

                <label for="publisher_name">Publisher's Name:</label>
                <input type="text" id="publisher_name" name="publisher_name" required placeholder="Enter Publisher Name">

                <label for="publisher_address">Publisher's Address:</label>
                <input type="text" id="publisher_address" name="publisher_address" required placeholder="Enter Publisher Address">

                <label for="publication_year">Publication Year:</label>
                <input type="number" id="publication_year" name="publication_year" required placeholder="Enter Year">

                <label for="price">Price (Rand):</label>
                <input type="number" step="0.01" id="price" name="price" required placeholder="R 0.00">

                <label for="fiction_or_nonfiction">Fiction or Nonfiction:</label>
                <select id="fiction_or_nonfiction" name="fiction_or_nonfiction" required>
                    <option value="" disabled selected>Select an option</option>
                    <option value="Fiction">Fiction</option>
                    <option value="Nonfiction">Nonfiction</option>
                </select>
                
                <label for="genre">Genre:</label>
                <input type="text" id="genre" name="genre" required placeholder="Enter Genre">

                <label for="language_of_publication">Language of Publication:</label>
                <input type="text" id="language_of_publication" name="language_of_publication" placeholder="Enter Language">

                <label for="english_translation_title">English Translation of Title:</label>
                <input type="text" id="english_translation_title" name="english_translation_title"  placeholder="Enter Translation (if any)">

                <label for="file">Upload File:</label>
                <input type="file" id="file" name="file" required>       
            <button type="submit">Submit</button>
            </form>

</body>
</html>