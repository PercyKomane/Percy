<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'social_media');

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the search query from the URL
$query = isset($_GET['query']) ? $conn->real_escape_string($_GET['query']) : '';

// Search for users
$user_result = $conn->query("SELECT * FROM users WHERE username LIKE '%$query%'");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Search Results</title>
</head>
<body>
    <div class="container">
        <h2>Search Results for "<?php echo htmlspecialchars($query); ?>"</h2>
        <?php if ($user_result->num_rows > 0): ?>
            <ul>
                <?php while ($user = $user_result->fetch_assoc()): ?>
                    <li>
                        <a href="profile.php?id=<?php echo $user['id']; ?>">
                            <?php echo htmlspecialchars($user['username']); ?>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No users found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
