<!-- HTML form for forgot password -->
<form action="" method="POST">
    <h3>Reset Password</h3>

    <label for="email">Email</label>
    <input type="email" name="email" placeholder="Enter your email" id="email" required>

    <input type="submit" value="Send Reset Link">
</form>


<?php
// Database connection
$host = 'localhost';
$dbname = 'social';
$username_db = 'root';
$password_db = '';

$conn = new mysqli($host, $username_db, $password_db, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, generate reset token
        $token = bin2hex(random_bytes(50)); // Generate a random token
        $sql_update = "UPDATE users SET reset_token = ? WHERE email = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ss", $token, $email);
        $stmt_update->execute();

        // Prepare the reset link
        $reset_link = "http://localhost/reset_password.php?token=$token";

        // Send the reset link via email (using mail() in real applications, here just displaying it)
        echo "<p style='color:green;'>A password reset link has been sent to your email.</p>";
        echo "<p><a href='$reset_link'>Click here to reset your password</a></p>"; // For testing, we display the link

    } else {
        echo "<p style='color:red;'>No account found with this email.</p>";
    }

    $stmt->close();
}
$conn->close();
?>

