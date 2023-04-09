<?php
include_once("bin/app_code/DataHelper.php");
include_once("bin/app_code/Snackbar.php");

// Start the session
session_start();

// Check if user is authenticated
if (!isset($_SESSION['user_id'])) {
  Snackbar::redirectAlert('Sorry, session expired! Please login again!', 'login.php', 'top-center');
  exit;
}

function bindPublications($data_access) {
  $publications = $data_access->returnAsList('SELECT * FROM ');
}
