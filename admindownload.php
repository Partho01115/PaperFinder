<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "q-b";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$uploadDir = 'contributions/';

if (isset($_GET['delete'])) {
    $fileToDelete = urldecode($_GET['delete']); 

    $fullFilePath = $uploadDir . basename($fileToDelete);

    
    $stmt = $conn->prepare("SELECT uploaded_pdf FROM upload_pdf WHERE uploaded_pdf = ?");
    $stmt->bind_param("s", $fullFilePath);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($filePath);
        $stmt->fetch();
        $stmt->close();

        // Ensure file exists before deleting
        if (file_exists($filePath)) {
            unlink($filePath); 

            // Delete entry from the database
            $stmt = $conn->prepare("DELETE FROM upload_pdf WHERE uploaded_pdf = ?");
            $stmt->bind_param("s", $filePath);
            $stmt->execute();
            $stmt->close();

            // JavaScript to reload page correctly
            echo "<script>
                    alert('File deleted successfully.');
                    window.location.replace('admin_contributions.php');
                  </script>";
            exit();
        } else {
            echo "<script>
                    alert('Error: File not found on the server!');
                    window.location.replace('admin_contributions.php');
                  </script>";
        }
    } else {
        echo "<script>
                alert('Error: File not found in the database!');
                window.location.replace('admin_contributions.php');
              </script>";
    }
}

// Fetch files from the database
$result = $conn->query("SELECT * FROM upload_pdf");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Manage Contributions</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <style>
    body {
      background-color: #e9ecef;
      font-family: Arial, sans-serif;
    }
    .container {
      background-color: white;
      border-radius: 10px;
      padding: 20px;
      margin-top: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    h1 {
      color: #343a40;
    }
    .btn-primary {
      background-color: #007bff;
      border: none;
    }
    .btn-primary:hover {
      background-color: #0056b3;
    }
    .btn-danger {
      background-color: #dc3545;
      border: none;
    }
    .btn-danger:hover {
      background-color: #a71d2a;
    }
  </style>
</head>
<body>

<div class="container">
    <h1 class="text-center mb-4">Admin - Manage Contributions</h1>

    <table class="table table-bordered">
      <thead>
        <tr>
          <th>File Name</th>
          <th>View</th>
          <th>Download</th>
          <th>Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars(basename($row['uploaded_pdf'])) ?></td>
            <td>
              <a href="<?= htmlspecialchars($row['uploaded_pdf']) ?>" target="_blank" class="btn btn-success">View</a>
            </td>
            <td>
              <a href="<?= htmlspecialchars($row['uploaded_pdf']) ?>" class="btn btn-primary" download>Download</a>
            </td>
            <td>
              <a href="?delete=<?= urlencode(basename($row['uploaded_pdf'])) ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this file?')">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
