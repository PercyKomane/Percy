<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'social_media');

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle sending a message
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $receiver_id = $_POST['receiver_id'];
    $message = $_POST['message'];
    
    // Insert message into the database
    $sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES ('{$_SESSION['user_id']}', '$receiver_id', '$message')";
    $conn->query($sql);
}

// Fetch messages for the logged-in user
$sql = "SELECT messages.*, 
               sender.username AS sender_name, 
               receiver.username AS receiver_name 
        FROM messages 
        JOIN users AS sender ON messages.sender_id = sender.id 
        JOIN users AS receiver ON messages.receiver_id = receiver.id 
        WHERE messages.receiver_id = '{$_SESSION['user_id']}' OR messages.sender_id = '{$_SESSION['user_id']}'
        ORDER BY timestamp DESC";
$message_result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Messages</title>
</head>

<nav>
    <a href="index.php">Home</a>
    <a href="messages.php">Messages</a>
    <a href="profile.php?id=<?php echo $_SESSION['user_id']; ?>">My Profile</a>
    <a href="logout.php">Logout</a>
</nav>

<body>
    <div class="container">
        <h2>Messages</h2>
        
        <form action="" method="POST">
            <label for="receiver_id">Select User:</label>
            <select name="receiver_id" id="receiver_id" required>
                <?php
                // Fetch all users to populate the receiver dropdown
                $user_result = $conn->query("SELECT * FROM users WHERE id != '{$_SESSION['user_id']}'");
                while ($user = $user_result->fetch_assoc()) {
                    echo "<option value='{$user['id']}'>" . htmlspecialchars($user['username']) . "</option>";
                }
                ?>
            </select>
            <label for="message">Message:</label>
            <textarea name="message" id="message" rows="4" required></textarea>
            <button type="submit">Send Message</button>
        </form>

        <h3>Conversation</h3>
        <div class="message-container">
            <?php while ($message = $message_result->fetch_assoc()): ?>
                <div class="message">
                    <strong><?php echo htmlspecialchars($message['sender_name']); ?>:</strong>
                    <p><?php echo htmlspecialchars($message['message']); ?></p>
                    <small><?php echo htmlspecialchars($message['timestamp']); ?></small>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
