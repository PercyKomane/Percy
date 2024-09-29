<?php
session_start();
include 'db.php'; // Include the database connection

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$logged_in_user_id = $_SESSION['user_id'];
$profile_user_id = intval($_GET['user_id']); // ID of the profile being viewed

// Check if the logged-in user is friends with the profile user
$sql = "SELECT * FROM friends 
        WHERE (user_id = $logged_in_user_id AND friend_id = $profile_user_id AND status = 'accepted')
        OR (user_id = $profile_user_id AND friend_id = $logged_in_user_id AND status = 'accepted')";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0 && $logged_in_user_id != $profile_user_id) {
    echo "You are not friends with this user.";
    exit();
}

// Fetch the profile user's information
$sql = "SELECT name, email, profile_picture FROM users WHERE id = $profile_user_id";
$profile_result = mysqli_query($conn, $sql);
$profile_data = mysqli_fetch_assoc($profile_result);

// Fetch the profile user's posts
$sql = "SELECT post_content, created_at FROM posts WHERE user_id = $profile_user_id ORDER BY created_at DESC";
$posts_result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($profile_data['name']); ?>'s Profile</title>
    <link rel="stylesheet" href="style.css">

    <style>
        /* General page styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f8ff; /* Light blue background */
            margin: 0;
            padding: 0;
        }

        /* Container */
        .container {
            width: 80%;
            max-width: 900px;
            margin: 40px auto;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Profile Header */
        .profile-header {
            display: flex;
            align-items: center;
            padding: 20px;
            border-bottom: 2px solid #e6f7ff;
        }

        .profile-picture img {
            border-radius: 50%;
            margin-right: 20px;
        }

        .profile-info h1 {
            color: #0073e6; /* Dark blue text */
            font-size: 24px;
            margin-bottom: 10px;
        }

        .profile-info p {
            color: #555;
        }

        /* Posts Section */
        .posts-section {
            margin-top: 20px;
        }

        .posts-section h2 {
            color: #0073e6;
            font-size: 22px;
            border-bottom: 2px solid #0073e6;
            padding-bottom: 10px;
        }

        .post {
            background-color: #e6f7ff; /* Light blue post background */
            margin-bottom: 15px;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .post p {
            font-size: 16px;
            color: #333;
        }

        .post small {
            font-size: 12px;
            color: #666;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                width: 95%;
            }

            .profile-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .profile-picture img {
                margin-right: 0;
                margin-bottom: 20px;
            }

            .posts-section h2 {
                font-size: 18px;
            }

            .post p {
                font-size: 14px;
            }
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="profile-header">
            <div class="profile-picture">
                <img src="uploads/<?php echo htmlspecialchars($profile_data['profile_picture']); ?>" alt="Profile Picture" width="150">
            </div>
            <div class="profile-info">
                <h1><?php echo htmlspecialchars($profile_data['name']); ?></h1>
                <p><?php echo htmlspecialchars($profile_data['email']); ?></p>
            </div>
        </div>

        <div class="posts-section">
            <h2><?php echo htmlspecialchars($profile_data['name']); ?>'s Posts</h2>
            <?php if (mysqli_num_rows($posts_result) > 0): ?>
                <?php while ($post = mysqli_fetch_assoc($posts_result)): ?>
                    <div class="post">
                        <p><?php echo htmlspecialchars($post['content']); ?></p>
                        <small>Posted on: <?php echo htmlspecialchars($post['created_at']); ?></small>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No posts available.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
