<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$friend_id = intval($_GET['friend_id']); // The ID of the user to be added

// Check if a friend request already exists
$sql = "SELECT * FROM friends WHERE user_id = $user_id AND friend_id = $friend_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    // Insert a new friend request with status 'pending'
    $sql = "INSERT INTO friends (user_id, friend_id, status) VALUES ($user_id, $friend_id, 'pending')";
    mysqli_query($conn, $sql);
    echo "Friend request sent!";
} else {
    echo "Friend request already sent or you're already friends.";
}

// Redirect back to the search page or user's profile
header("Location: search.php");
exit();
?>
