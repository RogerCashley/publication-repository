<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="app-assets/img/favicon.ico">

  <!-- VENDOR CSS: Bootstrap -->
  <link href="app-assets/vendors/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <!-- VENDOR JS: jQuery -->
  <script src="app-assets/vendors/jquery/jquery-3.6.3.min.js"></script>
  <!-- VENDOR CSS: Snackbar -->
  <link rel="stylesheet" href="app-assets/vendors/snackbar/snackbar.min.css">
  <!-- VENDOR JS: Snackbar -->
  <script src="app-assets/vendors/snackbar/snackbar.min.js"></script>
  <!-- CUSTOM CSS -->
  <link href="assets/css/master-styles.css" rel="stylesheet">

  <title>Repository - Publication Repository</title>
</head>

<body>
  <?php
  // !IMPORTANT: Always call master page for navigation binding and authentication
  require_once("master-page.php");
  require_once("bin/app_code/ClassLibrary.php");

  if (!isset($_GET['publication_id'])) {
    header("Location: home.php");
    exit;
  }

  $publication_id = ClassLibrary::decrypt($_GET['publication_id'], $_SESSION['user_id']);
  $publication = $data_access->returnAsObject('SELECT * FROM vw_publication WHERE publication_id = ?;', array($publication_id));
  $is_author = $data_access->returnAsInt('SELECT COUNT(*) AS Cnt FROM publication_authors WHERE publication_id = ? AND user_id = ?;', array($publication_id, $_SESSION['user_id'])) > 0;

  if ($publication == null || !(array)$publication) {
    Snackbar::redirectAlert('You are not authorized to view this repository!', 'home.php');
    exit;
  } else {
    // render navigation bar
    bindNavigationBar();
  ?>

    <div class="container container-fluid">
      <div class="row">
        <div class="col-lg-9">
          <h4><?php echo $publication->publication_title; ?></h4>
        </div>
        <div class="col-lg-3 text-end">
          <div class="btn-group">
            <a class="btn btn-outline-secondary" href="home.php">
              <i data-feather="chevron-left" class="text-sm"></i>
              <span class="d-inline-block align-middle d-none d-md-inline-block">Return</span>
            </a>
            <?php
            if ($is_author) {
            ?>
              <a class="btn btn-outline-primary" href="edit-repository.php?publication_id=<?php echo $_GET['publication_id']; ?>">
                <i data-feather="edit" class="text-sm"></i>
                <span class="d-inline-block align-middle d-none d-md-inline-block">Edit</span>
              </a>
            <?php } ?>
          </div>
        </div>
      </div>

      <hr class="pb-1 mb-1">

      <?php

      // Display the publication date
      if (!empty($publication->publication_date)) {
        $date = new DateTime($publication->publication_date);
        echo '<p><small class="text-muted">' . $date->format('F j, Y') . '</small></p>';
      }

      // Display the authors
      if (!empty($publication->authors)) {
        echo '<p><strong>Authors:</strong> ' . htmlspecialchars($publication->authors) . '</p>';
      }

      // Display the publication abstract
      if (!empty($publication->publication_abstract)) {
        echo '<p class="mb-1"><strong>Abstract</strong></p>';
        echo '<p>' . htmlspecialchars($publication->publication_abstract) . '</p>';
      }

      // Display the publication language
      if (!empty($publication->lang)) {
        echo '<p><strong>Language:</strong> ' . htmlspecialchars($publication->lang) . '</p>';
      }

      // Display the publication type
      if (!empty($publication->type_name)) {
        echo '<p><strong>Type:</strong> ' . htmlspecialchars($publication->type_name) . '</p>';
      }

      // Display the publication area
      if (!empty($publication->area_name)) {
        echo '<p><strong>Area:</strong> ' . htmlspecialchars($publication->area_name) . '</p>';
      }

      // Display the publication DOI
      if (!empty($publication->doi)) {
        echo '<p><strong>DOI:</strong> ' . htmlspecialchars($publication->doi) . '</p>';
      }

      // Display the publication volume
      if (!empty($publication->volume)) {
        echo '<p><strong>Volume:</strong> ' . htmlspecialchars($publication->volume) . '</p>';
      }

      // Display the publication issue
      if (!empty($publication->issue)) {
        echo '<p><strong>Issue:</strong> ' . htmlspecialchars($publication->issue) . '</p>';
      }

      // Display the publication pages
      if (!empty($publication->pages)) {
        echo '<p><strong>Pages:</strong> ' . htmlspecialchars($publication->pages) . '</p>';
      }

      // Display the publication series
      if (!empty($publication->series)) {
        echo '<p><strong>Series:</strong> ' . htmlspecialchars($publication->series) . '</p>';
      }

      // Display the content
      if (!empty($publication->content_file)) {
        echo '<p><strong>Content:</strong> <a target="_blank" href="' . htmlspecialchars($publication->content_file) . '">View Content</a></p>';
      }

      // Display the publication reference
      if (!empty($publication->publication_ref)) {
        echo '<p class="mb-1"><strong>References:</strong></p>';
        echo '<p>' . htmlspecialchars($publication->publication_ref) . '</p>';
      }

      ?>

    </div>

  <?php } ?>

  <!-- VENDOR JS: Feather Icon -->
  <script src="app-assets/vendors/feathericons/feather.min.js"></script>
  <!-- VENDOR JS: Bootstrap -->
  <script src="app-assets/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- CUSTOM JS -->
  <script src="assets/js/master-scripts.js"></script>
</body>

</html>