<?php
include_once("bin/app_code/DataHelper.php");
include_once("bin/app_code/Sackbar.php");
include_once("bin/app_code/ClassLibrary.php");
// Start the session
session_start();

// index.php functions to check remember me
if (isset($_COOKIE['user_id']) && isset($_COOKIE['password'])) {
  $user_id = $_COOKIE['user_id'];
  $password = $_COOKIE['password'];
  $remember_me = true;

  $app_user = $data_access->returnAsObject('SELECT * FROM app_user WHERE user_id = ?;', array($user_id));

  // Check if user exists
  if ($app_user != null) {
    $password_hash = $app_user->password_salt . $password . $app_user->password_pepper;
    if (password_verify($password_hash, $app_user->password_hash)) {
      // Get user role
      $role = $data_access->returnAsObject('SELECT * FROM app_role WHERE role_id IN (SELECT role_id FROM app_user_role WHERE user_id = ?);', array($user_id));

      // Save to session
      $_SESSION['user_id'] = $user_id;
      $_SESSION['role'] = serialize($role);

      // Check for remember me and cookie
      if ($remember_me) {
        setcookie("user_id", $user_id, time() + (86400 * 30), "/");
        setcookie("password", $password, time() + (86400 * 30), "/");
      } else {
        setcookie("user_id", $user_id, time() - (86400), "/");
        setcookie("password", $password, time() - (86400), "/");
      }

      // Redirect to home page
      header("Location: home.php");
      exit;
    }
  }
}

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to login page if everything else fails
header("Location: login.php");
exit;
