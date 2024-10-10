<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'social_media');

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle profile updates
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    
    // Update user information
    $sql = "UPDATE users SET username='$username', email='$email' WHERE id='{$_SESSION['user_id']}'";
    $conn->query($sql);
    echo '<div class="success">Profile updated successfully!</div>';
}

// Fetch current user data
$user_result = $conn->query("SELECT * FROM users WHERE id='{$_SESSION['user_id']}'");
$user = $user_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>User Settings</title>
</head>
<body>
    <div class="container">
        <h2>User Settings</h2>
        <form action="" method="POST">
            <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            <button type="submit">Update Profile</button>
        </form>
    </div>
</body>
</html>
