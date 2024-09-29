<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle accepting friend requests
if (isset($_POST['action']) && $_POST['action'] == 'accept') {
    $friend_id = intval($_POST['friend_id']);
    $sql = "UPDATE friends SET status = 'accepted' WHERE user_id = $friend_id AND friend_id = $user_id AND status = 'pending'";
    mysqli_query($conn, $sql);
}

// Handle rejecting friend requests
if (isset($_POST['action']) && $_POST['action'] == 'reject') {
    $friend_id = intval($_POST['friend_id']);
    $sql = "DELETE FROM friends WHERE user_id = $friend_id AND friend_id = $user_id AND status = 'pending'";
    mysqli_query($conn, $sql);
}

// Fetch pending friend requests
$sql = "SELECT users.id, users.name, users.email 
        FROM friends 
        JOIN users ON friends.user_id = users.id 
        WHERE friends.friend_id = $user_id AND friends.status = 'pending'";
$result = mysqli_query($conn, $sql);
$requests = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friend Requests</title>
    <link rel="stylesheet" href="style.css">

    <style>
        /* General page styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f8ff; /* Light blue background */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Container for content */
        .container {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        /* Header */
        h2 {
            text-align: center;
            color: #0073e6; /* Dark blue text */
        }

        /* Friend request list */
        .request-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .request-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #e6f7ff; /* Lighter blue background */
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Buttons */
        button {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }

        .accept-btn {
            background-color: #0073e6;
            color: white;
            margin-right: 5px;
            transition: background-color 0.3s;
        }

        .accept-btn:hover {
            background-color: #005bb5;
        }

        .reject-btn {
            background-color: #ff4d4d;
            color: white;
            transition: background-color 0.3s;
        }

        .reject-btn:hover {
            background-color: #e60000;
        }

        /* Empty state message */
        p {
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Friend Requests</h2>
        <?php if (count($requests) > 0): ?>
            <ul class="request-list">
                <?php foreach ($requests as $request): ?>
                    <li class="request-item">
                        <strong><?php echo htmlspecialchars($request['name']); ?></strong> (<?php echo htmlspecialchars($request['email']); ?>)
                        <form method="POST" action="accept_friend.php">
                            <input type="hidden" name="friend_id" value="<?php echo $request['id']; ?>">
                            <button type="submit" name="action" value="accept" class="accept-btn">Accept</button>
                            <button type="submit" name="action" value="reject" class="reject-btn">Reject</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No pending friend requests.</p>
        <?php endif; ?>
    </div>
</body>
</html>
