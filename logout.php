<?php
// Start the session
session_start();
// Unset all session variables
session_unset();
// Destroy the session
session_destroy();

// Clear cookie too
setcookie("user_id", $user_id, time() - (86400), "/");
setcookie("password", $password, time() - (86400), "/");

// Redirect to login page if everything else fails
header("Location: login.php");
exit;
