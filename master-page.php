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

function bindNavigationBar()
{
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

function renderRepositoryCard($id, $name, $type, $area, $description, $uploadedOn)
{
  return '
    <div class="my-3 repository-card d-block" data-filter-id="' . $id . '" data-filter-name="' . $name . '" data-filter-type="' . $type . '" data-filter-area="' . $area . '" data-filter-date="' . $uploadedOn . '">
      <div class="card">
        <div class="card-body">
          <div class="row mb-3">
            <div class="col-11">
              <h5 class="card-title"><a class="text-decoration-none" href="repository.php?publication_id=' . $id . '">' . $name . '</a></h5>
            </div>
            <div class="col-1">
              <div class="circle rounded-circle bg-success status-circle float-end"></div>
            </div>
          </div>
          <p class="card-text">' . $description . '</p>
          <div class="row d-flex justify-content-between align-items-center">
            <div class="col-12 col-lg-9">
              <small>
                <span class="badge bg-primary rounded-pill">' . $type . '</span>
                <span class="badge bg-info rounded-pill">' . $area . '</span>
              </small>
            </div>
            <div class="col-12 col-lg-3 text-lg-end">
              <small class="text-muted">Uploaded on ' . $uploadedOn . '</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  ';
}
