<?php  
    require_once('../assets/php/conn.php');
    $sql = "Select * from book_informationsheet";
    $bookresults = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Tab icon -->
  <link href="../assets/img/favicon.webp" rel="icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/bookDetails.css">
  <title>Book details</title>
</head>
<body>
          <!-- Home Button Icon -->
          <a href="adminDashboard.php" class="btn btn-secondary mb-3">
        <i class="bi bi-house-fill"></i> Admin Dashboard
    </a>
  <div class="scrollable-table">
  <table class="table">
    <thead>
      <tr>
        <th>Book ID</th>
        <th>Publisher Email</th>
        <th>Author Name</th>
        <th>Author Pseudonym</th>
        <th>Editor Name</th>
        <th>Book Title</th>
        <th>Book Edition</th>
        <th>Impression</th>
        <th>ISBN</th>
        <th>Set ISBN</th>
        <th>Publisher Name</th>
        <th>Publisher Address</th>
        <th>Year of Publication</th>
        <th>Price</th>
        <th>Fiction or Non-fiction</th>
        <th>Genre</th>
        <th>Language of Publication</th>
        <th>English translation of Title</th>
        <th>File Uploaded</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <?php   
          while ($row = mysqli_fetch_assoc($bookresults)) 
          {
        ?>
              <td><?php echo $row['Book_ID']; ?></td>
              <td><?php echo $row['PublisherEmail']; ?></td>
              <td><?php echo $row['AuthorName']; ?></td>
              <td><?php echo $row['AuthorPseudonym']; ?></td>
              <td><?php echo $row['EditorName']; ?></td>
              <td><?php echo $row['PublicationTitle']; ?></td>
              <td><?php echo $row['BookEdition']; ?></td>
              <td><?php echo $row['Impression']; ?></td>
              <td><?php echo $row['Isbn']; ?></td>
              <td><?php echo $row['SetISBN']; ?></td>
              <td><?php echo $row['PublisherName']; ?></td>
              <td><?php echo $row['PublisherAddress']; ?></td>
              <td><?php echo $row['PublicationYear']; ?></td>
              <td><?php echo $row['Price']; ?></td>
              <td><?php echo $row['FictionOrNonFiction']; ?></td>
              <td><?php echo $row['Genre']; ?></td>
              <td><?php echo $row['PublicationLanguage']; ?></td>
              <td><?php echo $row['EnglishVersionTitle']; ?></td>
              <td><?php echo $row['FileUpload']; ?></td>
              <td>
                <a href="bookEdit.php?Book_ID=<?php echo $row['Book_ID']?>" class="link-dark">Edit<i class="fa-solid fa-pen-to-sqaure fs-5 me-3"></i></a>
              </td>
       </tr>
                 <?php }?>

    </tbody>
  </table>
  </div>
</body>
</html>