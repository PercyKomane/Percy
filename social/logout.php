<?php
// Start the session
session_start();

// Destroy the session
session_destroy();

// Unset all session variables (optional but recommended)
$_SESSION = array();

// Redirect the user to the login page after logout
header("Location: login.php");
exit();
?>
