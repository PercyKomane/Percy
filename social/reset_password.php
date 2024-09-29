<!-- HTML form for resetting password -->
<!DOCTYPE html>
<form action="" method="POST">
    <h3>Reset Password</h3>

    <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>" />

    <label for="new_password">New Password</label>
    <input type="password" name="new_password" placeholder="Enter your new password" id="new_password" required>

    <input type="submit" value="Reset Password">
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
    $token = $_POST['token'];
    $new_password = $_POST['new_password'];

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Verify the token and update the password
    $sql = "UPDATE users SET hashed_password = ?, reset_token = NULL WHERE reset_token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $hashed_password, $token);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "<p style='color:green;'>Password has been reset successfully. You can now <a href='login.php'>log in</a>.</p>";
        } else {
            echo "<p style='color:red;'>Invalid or expired token. Please request a new password reset.</p>";
        }
    } else {
        echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

$conn->close();
?>

