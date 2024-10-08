<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'social_media');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Handle new post submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['content'])) {
    $user_id = $_SESSION['user_id'];
    $content = $_POST['content'];
    
    $sql = "INSERT INTO posts (user_id, content) VALUES ('$user_id', '$content')";
    $conn->query($sql);
}

// Fetch posts from the database
$sql = "SELECT posts.*, users.username, users.profile_picture 
        FROM posts 
        JOIN users ON posts.user_id = users.id 
        ORDER BY timestamp DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>User Timeline</title>
</head>
<body>
    <div class="container">
        <h2>Welcome to Your Timeline</h2>

        <form action="search.php" method="GET">
            <input type="text" name="query" placeholder="Search users..." required>
            <button type="submit">Search</button>
        </form>

        
        <form action="" method="POST">
            <input type="text" name="content" placeholder="What's on your mind?" required>
            <button type="submit">Post</button>
        </form>

        <div class="timeline-container">
        <?php while ($post = $result->fetch_assoc()): ?>
            <div class="post">
                <h4>
                    <a href="profile.php?id=<?php echo $post['user_id']; ?>">
                        <?php echo htmlspecialchars($post['username']); ?>
                    </a>
                </h4>
                <p><?php echo htmlspecialchars($post['content']); ?></p>
                <p><small><?php echo htmlspecialchars($post['timestamp']); ?></small></p>
            </div>
        <?php endwhile; ?>
</div>

    </div>
</body>
</html>
