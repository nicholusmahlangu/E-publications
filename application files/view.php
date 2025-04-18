<?php
session_start();

// Database connection
$host = 'localhost';
$dbname = 'e-pubsdb'; // Ensure this is correct
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Pagination and search
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit = 10;
$offset = ($page - 1) * $limit;
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

// Query to fetch data with ISBN and Cataloguer Name
$query = "SELECT 
            b.Book_ID AS id, 
            b.PublicationTitle AS title, 
            b.Genre AS description, 
            b.ISBN AS isbn, 
            b.FileUpload AS file_path, 
            b.downloads AS download_count, 
            b.publicationyear,
            b.status, 
            u.FullName AS cataloguer_name 
          FROM book_informationsheet b
          LEFT JOIN assignments a ON b.Book_ID = a.book_id
          LEFT JOIN users u ON a.cataloguer_id = u.User_ID";

if ($searchTerm !== '') {
    $query .= " WHERE b.PublicationTitle LIKE :search OR b.Genre LIKE :search OR b.ISBN LIKE :search OR b.Book_ID LIKE :search OR u.fullname LIKE :search OR b.publicationyear LIKE :search OR b.status LIKE :search";
}
$query .= " LIMIT :limit OFFSET :offset";

$stmt = $pdo->prepare($query);
if ($searchTerm !== '') {
    $stmt->bindValue(':search', '%' . $searchTerm . '%', PDO::PARAM_STR);
}
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$documents = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Total record count for pagination
$countQuery = "SELECT COUNT(*) as total FROM book_informationsheet";
if ($searchTerm !== '') {
    $countQuery .= " WHERE PublicationTitle LIKE :search OR Genre LIKE :search OR ISBN LIKE :search";
}
$countStmt = $pdo->prepare($countQuery);
if ($searchTerm !== '') {
    $countStmt->bindValue(':search', '%' . $searchTerm . '%', PDO::PARAM_STR);
}
$countStmt->execute();
$totalRecords = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = ceil($totalRecords / $limit);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document Management</title>
  <link href="../assets/img/favicon.webp" rel="icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .sidebar {
      background-color: #343a40;
      color: white;
      min-height: 100vh;
    }
    .sidebar a {
      color: white;
      text-decoration: none;
      padding: 10px 20px;
      display: block;
      font-weight: bold;
    }
    .sidebar a:hover {
      background: #495057;
      border-radius: 5px;
    }
  </style>
    <script>
    function checkStatus(selectElement, buttonId) {
        var updateButton = document.getElementById(buttonId);
        if (selectElement.value === "Reviewed") {
            updateButton.disabled = true;
        } else {
            updateButton.disabled = false;
        }
    }
  </script>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <nav class="col-md-3 col-lg-2 d-md-block sidebar">
        <h3 class="text-center py-3">Dashboard</h3>
        <ul class="nav flex-column">
          <li class="nav-item"><a href="dashboard.php" class="nav-link">Home</a></li>
          <li class="nav-item"><a href="view.php" class="nav-link">Document Management</a></li>
          <li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>
        </ul>
      </nav>

      <!-- Main Content -->
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <h1 class="mt-4">Document Management</h1>

        <!-- Search Bar -->
        <div class="input-group mb-4">
          <input type="text" id="search-input" class="form-control" placeholder="Search documents using any keyword..." value="<?= htmlspecialchars($searchTerm) ?>">
          <button class="btn btn-primary" onclick="search()">Search</button>
        </div>

        <!-- Table - we need to include the assigned analytics to admin dashboard NB Nick-->
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>ISBN</th>
                <th>Cataloguer</th>
                <th>File</th>
                <th>Downloads</th>
                <th>Publication Year</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($documents)): ?>
                <tr><td colspan="9" class="text-center">No documents found.</td></tr>
              <?php else: ?>
                <?php foreach ($documents as $doc): ?>
                  <tr>
                    <td><?= htmlspecialchars($doc['id']) ?></td>
                    <td><?= htmlspecialchars($doc['title']) ?></td>
                    <td><?= htmlspecialchars($doc['description']) ?></td>
                    <td><?= htmlspecialchars($doc['isbn'] ?? 'N/A') ?></td>
                    <td><?= htmlspecialchars($doc['cataloguer_name'] ?? 'N/A') ?></td>
                    <td>
                      <a href="download_document.php?Book_ID=<?= htmlspecialchars($doc['id']) ?>" class="btn btn-link">Download</a>
                    </td>
                    <td><?= htmlspecialchars($doc['download_count']) ?></td>
                    <td><?= htmlspecialchars($doc['publicationyear']) ?></td>
                    <td><?= htmlspecialchars($doc['status']?? 'assigned') ?></td>

                    <td>
                      <form action="update_status.php" method="POST" class="d-inline">
                        <input type="hidden" name="Book_ID" value="<?= htmlspecialchars($doc['id']) ?>">
                        <select name="status" class="form-select form-select-sm" required>
                          <option value="Assigned" <?= $doc['status'] === 'Assigned' ? 'selected' : '' ?>>Assigned</option>
                          <option value="Pending" <?= $doc['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                          <option value="Reviewed" <?= $doc['status'] === 'Reviewed' ? 'selected' : '' ?>>Reviewed</option>
                        </select>
                        <button type="submit" id="updateBtn<?= $doc['id'] ?>" class="btn btn-sm btn-primary" <?= $doc['status'] === 'Reviewed' ? 'disabled' : '' ?>>Update</button>
                      </form>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <nav>
          <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
              <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>&search=<?= htmlspecialchars($searchTerm) ?>"><?= $i ?></a>
              </li>
            <?php endfor; ?>
          </ul>
        </nav>
      </main>
    </div>
  </div>

  <script>
    function search() {
      const searchInput = document.getElementById('search-input');
      const searchQuery = searchInput.value.trim();
      window.location.href = `view.php?search=${encodeURIComponent(searchQuery)}`;
    }
  </script>
</body>
</html>
