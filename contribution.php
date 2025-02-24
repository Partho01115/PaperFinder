<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contribute - Q&B</title>
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
    .form-label {
      font-weight: bold;
    }
    .btn-primary {
      background-color: #007bff;
      border: none;
    }
    .btn-primary:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>

<div class="container">
    <h1 class="text-center mb-4">Contribute to Q&B</h1>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "q-b";
    
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die('<div class="alert alert-danger">Database Connection Failed: ' . $conn->connect_error . '</div>');
    }

    $uploadDir = 'contributions/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['file'];

            
            if ($file['type'] !== 'application/pdf') {
                echo '<div class="alert alert-danger">Invalid file type. Only PDF files are allowed.</div>';
            } else {
              
                $fileName = uniqid() . '_' . preg_replace("/[^a-zA-Z0-9\.\-_]/", "", basename($file['name']));
                $filePath = $uploadDir . $fileName;

                
                if (move_uploaded_file($file['tmp_name'], $filePath)) {
                   
                    $stmt = $conn->prepare("INSERT INTO upload_pdf (uploaded_pdf) VALUES (?)");
                    $stmt->bind_param("s", $filePath);

                    if ($stmt->execute()) {
                        echo '<div class="alert alert-success">Thank you for your contribution! File uploaded successfully.</div>';
                    } else {
                        echo '<div class="alert alert-danger">Database error. Failed to save file info.</div>';
                    }
                    $stmt->close();
                } else {
                    echo '<div class="alert alert-danger">File upload failed.</div>';
                }
            }
        } else {
            echo '<div class="alert alert-warning">Please select a valid file to upload.</div>';
        }
    }

    
    $conn->close();
    ?>

    <form action="" method="POST" enctype="multipart/form-data">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
