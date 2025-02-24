<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Q&B - Upload Questions</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .form-container {
      max-width: 600px;
      margin: 50px auto;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    footer {
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Q&B</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Upload</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Upload Form -->
  <div class="form-container">
    <h1 class="text-center">Upload Questions</h1>
    <form id="uploadForm">
      <!-- Select Branch -->
      <div class="mb-3">
        <label for="branchSelect" class="form-label">Select Branch</label>
        <select id="branchSelect" class="form-select" onchange="loadSemesters()" required>
          <option value="">Select a Branch</option>
        </select>
      </div>

      <!-- Select Semester -->
      <div class="mb-3">
        <label for="semesterSelect" class="form-label">Select Semester</label>
        <select id="semesterSelect" class="form-select" onchange="loadSubjects()" required>
          <option value="">Select a Semester</option>
        </select>
      </div>

      <!-- Select Subject -->
      <div class="mb-3">
        <label for="subjectSelect" class="form-label">Select Subject</label>
        <select id="subjectSelect" class="form-select" required>
          <option value="">Select a Subject</option>
        </select>
      </div>

      <!-- Upload PDF -->
      <div class="mb-3">
        <label for="questionFile" class="form-label">Upload PDF</label>
        <input type="file" id="questionFile" class="form-control" accept=".pdf" required>
      </div>

      <!-- Submit Button -->
      <button type="submit" class="btn btn-primary w-100">Upload</button>
    </form>
  </div>

  <!-- Footer -->
  <footer class="text-center bg-dark text-light py-3">
    <p>&copy; 2025 PaperFinder - Empowering educators everywhere!</p>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Predefined Data
    const qnbData = {
      branches: [
        { id: 1, name: "MCA" },
      { id: 2, name: "BCA" },
      { id: 3, name: "MBA" },
      { id: 4, name: "Engineering" },
      { id: 5, name: "MTech" },
      { id: 6, name: "BBA" },
      { id: 7, name: "BSc Nursing" },
      { id: 8, name: "BSc Agriculture" },
    ],
    semesters: {
      MCA: {
        1: ["Mathematics", "Programming", "Data Structures"],
        2: ["Database Systems", "Operating Systems"],
        3: ["COA", "Programming"],
        4: ["RDBMS", "ETC"],
      },
      BCA: {
        1: ["BMC", "C Programming", "ETC", "EVS"],
        2: ["DBMS", "Data Structure", "COA", "AMC"],
        3: ["OOPS", "Operating System", "CG", "MAC"],
        4: ["Python", "IWT", "Cmp. Network", "Software Eng."],
        5: ["Cloud Computing", "AI", "Unix"],
        6: ["PHP", "Ethics & Values"],
      },
      MBA: {
        1: ["Management", "Economics"],
        2: ["Finance", "Marketing"],
        3: ["Management", "Economics"],
        4: ["Finance", "Marketing"],
      },
      BBA: {
        1: ["MAC", "BUSS. MANAGEMENT"],
        2: ["XYZ", "MNO"],
      },
      'BSc Nursing': {
        1: ["Physics", "Eng. Mathematics"],
        2: ["Thermodynamics", "Circuits"],
        3: ["Physics", "Eng. Mathematics"],
        4: ["Thermodynamics", "Circuits"],
        5: ["MAC", "BUSS. MANAGEMENT"],
        6: ["XYZ", "MNO"],
        7: ["COA", "Programming"],
        8: ["RDBMS", "ETC"],

      },
        MBA: {
            1: ["Management", "Economics"],
            2: ["Finance", "Marketing"] },
        Engineering: {
            1: ["Physics", "Maths"],
            2: ["Thermodynamics", "Circuits"] },
      },
      questions: {}, // Will be updated dynamically
    };

    // Populate Branch Select
    const branchSelect = document.getElementById("branchSelect");
    qnbData.branches.forEach(branch => {
      const option = document.createElement("option");
      option.value = branch.name;
      option.textContent = branch.name;
      branchSelect.appendChild(option);
    });

    // Load Semesters Based on Branch
    function loadSemesters() {
      const branchName = branchSelect.value;
      const semesterSelect = document.getElementById("semesterSelect");
      semesterSelect.innerHTML = '<option value="">Select a Semester</option>';

      if (qnbData.semesters[branchName]) {
        Object.keys(qnbData.semesters[branchName]).forEach(semester => {
          const option = document.createElement("option");
          option.value = semester;
          option.textContent = `Semester ${semester}`; // Corrected template literal
          semesterSelect.appendChild(option);
        });
      }
    }

    // Load Subjects Based on Semester
    function loadSubjects() {
      const branchName = branchSelect.value;
      const semesterId = document.getElementById("semesterSelect").value;
      const subjectSelect = document.getElementById("subjectSelect");
      subjectSelect.innerHTML = '<option value="">Select a Subject</option>';

      if (qnbData.semesters[branchName] && qnbData.semesters[branchName][semesterId]) {
        qnbData.semesters[branchName][semesterId].forEach(subject => {
          const option = document.createElement("option");
          option.value = subject;
          option.textContent = subject;
          subjectSelect.appendChild(option);
        });
      }
    }

    // Handle Upload Form Submission
    document.getElementById("uploadForm").addEventListener("submit", function (e) {
      e.preventDefault();

      const branch = branchSelect.value;
      const semester = document.getElementById("semesterSelect").value;
      const subject = document.getElementById("subjectSelect").value;
      const fileInput = document.getElementById("questionFile");
      const file = fileInput.files[0];

      if (branch && semester && subject && file) {
        if (!qnbData.questions[subject]) qnbData.questions[subject] = [];

        qnbData.questions[subject].push(file.name);

        alert(`Successfully uploaded "${file.name}" for ${branch} - Semester ${semester} - ${subject}`);
        fileInput.value = ""; // Clear file input
      } else {
        alert("Please fill out all fields and select a file to upload.");
      }
    });
  </script>

<?php
// Database connection
$servername = "localhost";  // XAMPP default server
$username = "root";         // Default XAMPP username
$password = "";             // Default XAMPP password (empty)
$dbname = "question_bank";  // Database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data from the POST request
    if (isset($_POST['branch'], $_POST['semester'], $_POST['subject'])) {
        $branch = $_POST['branch'];   // Branch (e.g., MCA, BCA)
        $semester = $_POST['semester']; // Semester (e.g., 1, 2)
        $subject = $_POST['subject'];  // Subject (e.g., Programming, Maths)

        // Prepare and bind the SQL query
        $stmt = $conn->prepare("INSERT INTO uploads (branch, semester, subject) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $branch, $semester, $subject);

        // Execute the statement
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Data saved successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save data to the database']);
        }

        // Close the statement
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    }
}

// Close the database connection
$conn->close();
?>



</body>
</html>
