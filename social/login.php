<?php
// Start session
session_start();

// Include database connection
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the input from the form
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];  // Do not escape the password as it will be hashed

    // Check if the email exists in the database
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Fetch the user's data
        $user = mysqli_fetch_assoc($result);
        
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Password is correct, log the user in
            $_SESSION['user_id'] = $user['id']; // Store the user's ID in the session
            $_SESSION['email'] = $user['email']; // Optional: Store email in the session

            // Redirect to the home page
            header("Location: home.php");
            exit();
        } else {
            // Password is incorrect
            $error = "Incorrect password. Please try again or reset your password.";
        }
    } else {
        // Email does not exist
        $error = "No account found with that email. Please register.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            text-align: center;
        }

        h3 {
            margin-bottom: 20px;
            color: #1877f2;
        }

        label {
            display: block;
            text-align: left;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #1877f2;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #145dbf;
        }

        a {
            color: #1877f2;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        p {
            margin-top: 10px;
        }

    </style>
</head>
<body>
    <div class="login-container">
        <form action="login.php" method="POST">
            <h3>Login Here</h3>
            
            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>

            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Enter your email" required>

            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Enter your password" required>

            <input type="submit" value="Log In">

            <p>Forgot your password? <a href="reset_password.php">Click here</a></p>
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </form>
    </div>
</body>
</html>
