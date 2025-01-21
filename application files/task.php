<?php
require_once('../assets/php/conn.php');

// Fetch books
$bookQuery = "SELECT * FROM book_informationsheet";
$bookResults = mysqli_query($conn, $bookQuery);

<<<<<<< HEAD
if (!$bookResults) {
    die("Error fetching books: " . mysqli_error($conn));
}

// Fetch cataloguers
$cataloguerQuery = "SELECT * FROM users";
$cataloguerResults = mysqli_query($conn, $cataloguerQuery);

if (!$cataloguerResults) {
    die("Error fetching cataloguers: " . mysqli_error($conn));
}
=======
// Fetch cataloguers
$cataloguerQuery = "SELECT * FROM users ";
$cataloguerResults = mysqli_query($conn, $cataloguerQuery);
>>>>>>> main
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../assets/img/favicon.webp" rel="icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<<<<<<< HEAD
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <title>Task Assignment</title>
=======
  <title>Book Details</title>
>>>>>>> main
  <style>
    body {
      background-color: #f8f9fa;
    }
<<<<<<< HEAD
    .container {
      margin-top: 40px;
    }
    .table-container {
      background-color: white;
      padding: 20px;
=======
    .table-container {
      margin: 20px auto;
      padding: 20px;
      background-color: white;
>>>>>>> main
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .table th, .table td {
      vertical-align: middle;
<<<<<<< HEAD
    }
    @media (max-width: 768px) {
      h1 {
        font-size: 1.5rem;
      }
      .table th, .table td {
        font-size: 0.9rem;
      }
=======
      text-align: center;
>>>>>>> main
    }
  </style>
</head>
<body>
<<<<<<< HEAD
  <!-- Admin Dashboard Link -->
  <div class="container mb-3">
    <a href="adminDashboard.php" class="btn btn-secondary">
      <i class="bi bi-house-fill"></i> Back to Admin Dashboard
    </a>
  </div>

  <div class="container table-container">
    <h1 class="mb-4 text-center">Task Assignment</h1>

    <!-- Task Table -->
=======
        <!-- Home Button Icon -->
        <a href="adminDashboard.php" class="home-icon">
        <i class="bi bi-house-fill"></i> Admin Dashboard
    </a>
  <div class="container table-container">
    <h1 class="mb-4 text-center">Book Details</h1>
>>>>>>> main
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead class="table-dark">
          <tr>
            <th>Book ID</th>
            <th>Publisher Email</th>
            <th>Author Name</th>
            <th>Book Title</th>
            <th>ISBN</th>
            <th>Assign to</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if (mysqli_num_rows($bookResults) > 0): ?>
            <?php while ($book = mysqli_fetch_assoc($bookResults)): ?>
              <tr>
                <td><?= htmlspecialchars($book['Book_ID']) ?></td>
                <td><?= htmlspecialchars($book['PublisherEmail']) ?></td>
                <td><?= htmlspecialchars($book['AuthorName']) ?></td>
                <td><?= htmlspecialchars($book['PublicationTitle']) ?></td>
                <td><?= htmlspecialchars($book['Isbn']) ?></td>
                <td>
<<<<<<< HEAD
                  <form action="assign_task.php" method="POST">
=======
                  <form action="assign_task.php" method="POST" class="d-inline">
>>>>>>> main
                    <input type="hidden" name="Book_ID" value="<?= htmlspecialchars($book['Book_ID']) ?>">
                    <select name="cataloguer_id" class="form-select form-select-sm" required>
                      <option value="">Select Cataloguer</option>
                      <?php 
                      mysqli_data_seek($cataloguerResults, 0); // Reset cataloguer results pointer
                      while ($cataloguer = mysqli_fetch_assoc($cataloguerResults)): ?>
                        <option value="<?= htmlspecialchars($cataloguer['User_ID']) ?>">
                          <?= htmlspecialchars($cataloguer['FullName']) ?>
                        </option>
                      <?php endwhile; ?>
                    </select>
                </td>
                <td>
<<<<<<< HEAD
                  <button type="submit" class="btn btn-primary btn-sm">Assign</button>
=======
                    <button type="submit" class="btn btn-primary btn-sm">Assign</button>
>>>>>>> main
                  </form>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="7" class="text-center">No books found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
<<<<<<< HEAD

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
=======
>>>>>>> main
</body>
</html>
