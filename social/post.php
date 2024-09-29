<?php
// Start session to access user session data
session_start();

// Include database connection
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User not logged in");
}

$user_id = $_SESSION['user_id'];  // Get the logged-in user's ID from the session

// Check if the form is submitted and post_content is provided
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['post_content'])) {
    $post_content = mysqli_real_escape_string($conn, $_POST['post_content']);

    // Insert post into the database
    $sql = "INSERT INTO posts (user_id, post_content) VALUES ('$user_id', '$post_content')";
    
    if (mysqli_query($conn, $sql)) {
        // Redirect to home page after successful post
        header("Location: home.php");
    } else {
        echo "Error: " . mysqli_error($conn);  // Display any SQL errors
    }
} else {
    echo "Post content is required";
}

echo "User ID: " . $_SESSION['user_id'];
?>
