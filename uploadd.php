<?php
include 'contribution.php'; // This will include your database connection code

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if a file was uploaded
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $uploadedFile = $_FILES['file'];

        // Define the target directory where the file will be saved
        $targetDirectory = "uploads/"; // You can create this directory on your server
        $targetFile = $targetDirectory . basename($uploadedFile["name"]);
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if the uploaded file is a PDF
        if ($fileType == "pdf") {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($uploadedFile["tmp_name"], $targetFile)) {
                // Insert the file path into the database
                $stmt = $conn->prepare("INSERT INTO user_cont (uploaded_pdf) VALUES (?)");
                $stmt->bind_param("s", $targetFile);  // Bind the file path parameter

                if ($stmt->execute()) {
                    echo "The file has been uploaded and saved to the database.";
                } else {
                    echo "Error inserting file into the database.";
                }
                $stmt->close();
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Only PDF files are allowed.";
        }
    } else {
        echo "No file uploaded or there was an error uploading the file.";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contribute - Q&B</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <style>
    body {
      background-color: #e9ecef; /* Light gray background */
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
      color: #343a40; /* Dark gray text */
    }
    .form-label {
      font-weight: bold;
    }
    .btn-primary {
      background-color: #007bff; /* Blue button */
      border: none;
    }
    .btn-primary:hover {
      background-color: #0056b3; /* Darker blue on hover */
    }
  </style>
</head>
<body>
  <div class="container">
    <h1 class="text-center mb-4">Contribute to Q&B</h1>
    <form action="contribute.php" method="POST" enctype="multipart/form-data">
      <!-- File Upload -->
      <div class="mb-3">
        <label for="file" class="form-label">Upload PDF</label>
        <input type="file" class="form-control" id="file" name="file" accept=".pdf" required>
      </div>

      <!-- Note Input -->
      <div class="mb-3">
        <label for="note" class="form-label">Upload Note</label>
        <textarea class="form-control" id="note" name="note" rows="3"></textarea>
      </div>

      <!-- Submit Button -->
      <button type="submit" class="btn btn-primary">Upload</button>
    </form>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>