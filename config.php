<?php
// config.php
$servername = "localhost";
$username = "root";
$password = ""; // leave blank if you haven't set a password
$dbname = "maintgcbdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>