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

  <title>Delete Repository - Publication Repository</title>
</head>

<body>
  <?php
  require_once("master-page.php");
  require_once("bin/app_code/ClassLibrary.php");

  $publication_id = ClassLibrary::decrypt($_GET['publication_id'], $_SESSION['user_id']);
  $publication = $data_access->returnAsObject('SELECT * FROM vw_publication WHERE publication_id = ?;', array($publication_id));

  if ($publication == null || !(array)$publication) {
    Snackbar::redirectAlert('Publication id verification failed!', 'home.php');
    exit;
  }

  if ($publication->publication_owner == $_SESSION['user_id']) {
    $data_access->executeNonQuery('DELETE FROM publication_authors WHERE publication_id = ?;', array($publication_id));
    $data_access->executeNonQuery('DELETE FROM publication_content WHERE publication_id = ?;', array($publication_id));
    $data_access->executeNonQuery('DELETE FROM publication WHERE publication_id = ?;', array($publication_id));

    Snackbar::redirectAlert('Repository deleted!', 'home.php');
    exit;
  } else {
    Snackbar::redirectAlert('Publication id verification failed!', 'home.php');
    exit;
  } ?>

  <!-- VENDOR JS: Feather Icon -->
  <script src="app-assets/vendors/feathericons/feather.min.js"></script>
  <!-- VENDOR JS: Bootstrap -->
  <script src="app-assets/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- CUSTOM JS -->
  <script src="assets/js/master-scripts.js"></script>
</body>

</html>