<?php
require_once('../assets/php/conn.php');

// Fetch books
$bookQuery = "SELECT * FROM book_informationsheet";
$bookResults = mysqli_query($conn, $bookQuery);

if (!$bookResults) {
    die("Error fetching books: " . mysqli_error($conn));
}

// Fetch cataloguers
$cataloguerQuery = "SELECT * FROM users";
$cataloguerResults = mysqli_query($conn, $cataloguerQuery);

if (!$cataloguerResults) {
    die("Error fetching cataloguers: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../assets/img/favicon.webp" rel="icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <title>Task Assignment</title>
  <style>
    body {
      background-color: #f8f9fa;
    }
    .container {
      margin-top: 40px;
    }
    .table-container {
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .table th, .table td {
      vertical-align: middle;
    }
    @media (max-width: 768px) {
      h1 {
        font-size: 1.5rem;
      }
      .table th, .table td {
        font-size: 0.9rem;
      }
    }
  </style>
</head>
<body>
  <!-- Admin Dashboard Link -->
  <div class="container mb-3">
    <a href="adminDashboard.php" class="btn btn-secondary">
      <i class="bi bi-house-fill"></i> Back to Admin Dashboard
    </a>
  </div>

  <div class="container table-container">
    <h1 class="mb-4 text-center">Task Assignment</h1>

    <!-- Task Table -->
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
                  <form action="assign_task.php" method="POST">
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
                  <button type="submit" class="btn btn-primary btn-sm">Assign</button>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
