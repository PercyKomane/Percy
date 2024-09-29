<?php
// Database connection settings
$servername = "localhost"; // or 127.0.0.1
$username = "root"; // default XAMPP username
$password = ""; // default XAMPP password is empty
$dbname = "social"; // Your database name

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
