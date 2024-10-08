<?php
// Always place this at the top of your script, before any HTML or output
session_start();

// Include your database connection file
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

// The logged-in user's ID can be accessed as $_SESSION['user_id']
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Media Home</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
/* Global styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
            color: #333;
        }

        /* Navbar */
        .navbar {
            background-color: #3b5998;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            flex-wrap: wrap;
        }

        .navbar-logo a {
            color: white;
            font-size: 24px;
            text-decoration: none;
            font-weight: bold;
        }

        .navbar-links, .navbar-profile {
            display: flex;
            align-items: center;
        }

        .navbar-links a, .navbar-profile a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-size: 18px;
        }

        .navbar-links a:hover, .navbar-profile a:hover {
            text-decoration: underline;
        }

        /* Main container */
        .main-container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            flex-wrap: wrap;
        }

        /* Search feature */
        .search-box {
            width: 25%;
        }

        /* Sidebar */
        .sidebar {
            width: 25%;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin-bottom: 20px;
        }

        .sidebar ul li a {
            color: #3b5998;
            text-decoration: none;
            font-size: 18px;
        }

        .sidebar ul li a:hover {
            color: #1e2f5d;
        }

        /* Feed */
        .feed {
            width: 70%;
        }

        .post-box {
            background-color: white;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .post-box textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: none;
            outline: none;
            resize: none;
            border-radius: 4px;
            background-color: #f0f2f5;
        }

        .post-box button {
            margin-top: 10px;
            background-color: #3b5998;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 4px;
        }

        .post-box button:hover {
            background-color: #1e2f5d;
        }

        /* Posts */
        .posts .post {
            background-color: white;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .post-header {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .post-header img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
        }

        .post-header h3 {
            font-size: 18px;
            margin: 0;
        }

        .post-content p {
            font-size: 16px;
            margin: 0;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 20px;
            background-color: #3b5998;
            color: white;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        footer p {
            margin: 0;
        }

        /* Media Queries for Responsiveness */

        /* For tablets and smaller screens */
        @media (max-width: 992px) {
            .main-container {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                margin-bottom: 20px;
            }
            
            .feed {
                width: 100%;
            }
            
            .navbar-links a, .navbar-profile a {
                font-size: 16px;
                margin-left: 10px;
            }
        }

        /* For mobile screens */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .navbar-links, .navbar-profile {
                flex-direction: column;
                width: 100%;
                margin-top: 10px;
            }
            
            .navbar-links a, .navbar-profile a {
                font-size: 16px;
                margin: 5px 0;
            }
            
            .sidebar {
                width: 100%;
                margin-bottom: 20px;
            }
            
            .feed {
                width: 100%;
            }
            
            .post-box textarea {
                font-size: 14px;
            }
            
            .post-box button {
                width: 100%;
            }
            
            .post-header h3 {
                font-size: 16px;
            }
            
            .post-content p {
                font-size: 14px;
            }
        }

        /* For extra small screens */
        @media (max-width: 480px) {
            .navbar-logo a {
                font-size: 20px;
            }
            
            .navbar-links a, .navbar-profile a {
                font-size: 14px;
            }
            
            .post-box textarea {
                font-size: 12px;
            }
            
            .post-box button {
                padding: 8px 10px;
            }
            
            .post-header img {
                width: 40px;
                height: 40px;
            }
            
            .post-header h3 {
                font-size: 14px;
            }
            
            .post-content p {
                font-size: 12px;
            }
        }

    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-logo">
            <a href="#">Richfield</a>
        </div>
        <div class="navbar-links">
            <a href="home.php">Home</a>
            <a href="friends.php">Friends</a>
            <a href="messages.php">Messages</a>
            <a href="notifications.php">Notifications</a>
        </div>
        <div class="navbar-profile">
            <a href="user_profile.php">Profile</a>
            <a href="logout.php">Logout</a>
        </div>
    </nav>

    <!-- Main content -->
    <div class="main-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <ul>
                <li><a href="friends.php"><i class="fas fa-user-friends"></i> Friends</a></li>
                <li><a href="messages.php"><i class="fas fa-envelope"></i> Messages</a></li>
                <li><a href="notifications.php"><i class="fas fa-bell"></i> Notifications</a></li>
                <li><a href="groups.php"><i class="fas fa-users"></i> Groups</a></li>
            </ul>
        </div>

        <!-- Search Feature -->
        <div class="search-box">
            <h3>Search for Users</h3>
            <form method="POST" action="home.php">
                <input type="text" name="search_query" placeholder="Enter name or email" required>
                <input type="submit" value="Search">
            </form>

            <!-- Display Search Results -->
            <?php
            // Handle search functionality
            $search_results = [];

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search_query'])) {
                $search_query = mysqli_real_escape_string($conn, $_POST['search_query']);
                
                // SQL query to search users by name or email
                $sql_search = "SELECT id, name, email FROM users WHERE email LIKE '%$search_query%' OR name LIKE '%$search_query%'";
                $result_search = mysqli_query($conn, $sql_search);
                
                while ($row_search = mysqli_fetch_assoc($result_search)) {
                    $search_results[] = $row_search;
                }
            }

            if (!empty($search_results)) {
                echo '<h4>Search Results:</h4>';
                echo '<ul>';
                foreach ($search_results as $user) {
                    echo '<li>';
                    echo '<strong>' . htmlspecialchars($user['name']) . '</strong> (' . htmlspecialchars($user['email']) . ') ';
                    echo '<a href="view_profile.php?user_id=' . $user['id'] . '">View Profile</a>';
                    echo ' | <a href="add_friend.php?friend_id=' . $user['id'] . '">Add Friend</a>';
                    echo '</li>';
                }
                echo '</ul>';
            }
            ?>
        </div>

        <!-- Feed Section -->
        <div class="feed">
            <!-- Post Box -->
            <div class="post-box">
                <form action="post.php" method="POST">
                    <textarea name="post_content" placeholder="What's on your mind?" required></textarea>
                    <button type="submit">Post</button>
                </form>
            </div>

            <!-- Display Posts -->
            <?php
            //session_start();
            include 'db.php';

            // Assuming user is logged in
            $user_id = $_SESSION['user_id'];

            // Fetch all posts from the logged-in user
            $sql = "SELECT p.post_content, p.post_time, u.email FROM posts p
                    JOIN users u ON p.user_id = u.id
                    WHERE p.user_id = '$user_id'
                    ORDER BY p.post_time DESC";
            $result = mysqli_query($conn, $sql);

            // Display the posts
            if (mysqli_num_rows($result) > 0) {
                echo '<div class="posts">';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="post">';
                    echo '<div class="post-header">';
                    echo '<img src="profile.jpg" alt="User Image">';  // Placeholder for user image
                    echo '<h3>' . htmlspecialchars($row['email']) . '</h3>';
                    echo '</div>';
                    echo '<div class="post-content">';
                    echo '<p>' . htmlspecialchars($row['post_content']) . '</p>';
                    echo '</div>';
                    echo '<div class="post-time">';
                    echo '<small>' . date('F j, Y, g:i a', strtotime($row['post_time'])) . '</small>';
                    echo '</div>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo "<p>No posts yet.</p>";
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Richfield. All rights reserved.</p>
    </footer>
</body>
</html>
