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

function bindNavigationBar() {
  echo '
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-5">
      <div class="container container-fluid">
        <a class="navbar-brand" href="home.php">Sampoerna University</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">  
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="account-setting.php">Profile</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  ';
}

function bindPublications($data_access) {
  
}