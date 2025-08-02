<?php
$host = "localhost";
$user = "root";
$pass = ""; // no password by default in XAMPP
$dbname = "Event-management";

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Optional: Confirm it's connected
// echo "Connected successfully";
?>
