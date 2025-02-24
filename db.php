<?php
$servername = "localhost";  // Your MySQL server name (usually localhost)
$username = "root";         // Your MySQL username (default is usually 'root')
$password = "";             // Your MySQL password (default is usually empty)
$dbname = "paperfinder";    // Your database name

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
