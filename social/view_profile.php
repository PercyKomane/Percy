<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$profile_user_id = intval($_GET['user_id']); // The ID of the profile being viewed

// Check if the users are friends
$sql = "SELECT * FROM friends WHERE (user_id = $user_id AND friend_id = $profile_user_id AND status = 'accepted') 
        OR (user_id = $profile_user_id AND friend_id = $user_id AND status = 'accepted')";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    echo "You are not friends with this user.";
    exit();
}

// Fetch the profile user information
$sql = "SELECT name, email, profile_picture FROM users WHERE id = $profile_user_id";
$profile_result = mysqli_query($conn, $sql);
$profile_data = mysqli_fetch_assoc($profile_result);

// Fetch the profile user's posts
$sql = "SELECT content, created_at FROM posts WHERE user_id = $profile_user_id ORDER BY created_at DESC";
$posts_result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($profile_data['name']); ?>'s Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2><?php echo htmlspecialchars($profile_data['name']); ?>'s Profile</h2>
    <p>Email: <?php echo htmlspecialchars($profile_data['email']); ?></p>
    <img src="uploads/<?php echo htmlspecialchars($profile_data['profile_picture']); ?>" alt="Profile Picture" width="150">

    <h3>Posts</h3>
    <?php while ($post = mysqli_fetch_assoc($posts_result)): ?>
        <div class="post">
            <p><?php echo htmlspecialchars($post['content']); ?></p>
            <small>Posted on: <?php echo htmlspecialchars($post['created_at']); ?></small>
        </div>
    <?php endwhile; ?>
</body>
</html>
