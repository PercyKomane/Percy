<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'social_media');

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the profile ID from the URL or default to the logged-in user
$profile_id = isset($_GET['id']) ? $_GET['id'] : $_SESSION['user_id'];

// Fetch user info
$sql = "SELECT * FROM users WHERE id = '$profile_id'";
$user_result = $conn->query($sql);
$user = $user_result->fetch_assoc();

// Fetch user's posts
$sql = "SELECT * FROM posts WHERE user_id = '$profile_id' ORDER BY timestamp DESC";
$post_result = $conn->query($sql);

// Handle profile picture upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_picture'])) {
    $file = $_FILES['profile_picture'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($file["name"]);
    
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        // Update profile picture path in the database
        $sql = "UPDATE users SET profile_picture = '{$file["name"]}' WHERE id = '$profile_id'";
        $conn->query($sql);
        header("Location: profile.php?id=$profile_id"); // Refresh the profile page
        exit();
    } else {
        $error = "Error uploading file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title><?php echo htmlspecialchars($user['username']); ?>'s Profile</title>
</head>
<body>
    <div class="container">
        <div class="profile-header">
            <img src="uploads/<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" class="profile-pic">
            <h2><?php echo htmlspecialchars($user['username']); ?></h2>
        </div>

        <!-- Profile Picture Upload Form -->
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="profile_picture">Change Profile Picture:</label>
            <input type="file" name="profile_picture" id="profile_picture" required>
            <button type="submit">Upload</button>
        </form>

        <div class="timeline-container">
            <h3>Posts</h3>
            <?php while ($post = $post_result->fetch_assoc()): ?>
                <div class="post">
                    <p><?php echo htmlspecialchars($post['content']); ?></p>
                    <p><small><?php echo htmlspecialchars($post['timestamp']); ?></small></p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
