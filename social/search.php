<?php
session_start();
include 'db.php'; // Database connection

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$search_results = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $search_query = mysqli_real_escape_string($conn, $_POST['search_query']);
    
    // SQL query to search users by name or email
    $sql = "SELECT id, name, email FROM users WHERE email LIKE '%$search_query%' OR name LIKE '%$search_query%'";
    $result = mysqli_query($conn, $sql);
    
    while ($row = mysqli_fetch_assoc($result)) {
        $search_results[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Users</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h3>Search for Users</h3>
    <form method="POST" action="search.php">
        <input type="text" name="search_query" placeholder="Enter name or email" required>
        <input type="submit" value="Search">
    </form>

    <h4>Search Results:</h4>
    <ul>
        <?php foreach ($search_results as $user): ?>
            <li>
                <strong><?php echo htmlspecialchars($user['name']); ?></strong> (<?php echo htmlspecialchars($user['email']); ?>)
                <a href="view_profile.php?user_id=<?php echo $user['id']; ?>">View Profile</a> 
                | <a href="add_friend.php?friend_id=<?php echo $user['id']; ?>">Add Friend</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
