<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="app-assets/img/favicon.ico">
  <title>Create Repository</title>

  <!-- VENDOR CSS: Bootstrap -->
  <link href="app-assets/vendors/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <!-- VENDOR JS: jQuery -->
  <script src="app-assets/vendors/jquery/jquery-3.6.3.min.js"></script>
  <!-- VENDOR CSS: Snackbar -->
  <link rel="stylesheet" href="app-assets/vendors/snackbar/snackbar.min.css">
  <!-- VENDOR JS: Snackbar -->
  <script src="app-assets/vendors/snackbar/snackbar.min.js"></script>
  <!-- VENDOR CSS: Select2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
  <link rel="stylesheet" href="app-assets/vendors/select2/select2.min.css">
  <!-- VENDOR JS: Select2 -->
  <script src="app-assets/vendors/select2/select2.min.js"></script>
  <!-- CUSTOM CSS -->
  <link href="assets/css/master-styles.css" rel="stylesheet">
</head>

<body>
  <?php
  // !IMPORTANT: Always call master page for navigation binding and authentication
  require_once("master-page.php");
  require_once("bin/app_code/ClassLibrary.php");

  // render navigation bar
  bindNavigationBar();

  if (!isset($_GET['publication_id'])) {
    header("Location: home.php");
    exit;
  }

  $publication_id = $_GET['publication_id'];
  $publication = $data_access->returnAsObject('SELECT * FROM vw_publication WHERE publication_id = ?;', array($publication_id));
  ?>

  <!-- Page Content -->
  <div class="container container-fluid">
    <div class="row">
      <div class="col-12">
        <h4>Create a new repository</h4>
      </div>
    </div>

    <hr>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" required>
      </div>
      <div class="mb-3">
        <label for="date" class="form-label">Publication Date</label>
        <input type="date" class="form-control" id="date" name="date" required value="<?php echo date('Y-m-d'); ?>">
      </div>
      <div class="mb-3">
        <label for="lang" class="form-label">Language</label>
        <select name="language" id="language" class="select2 form-select">
          <option value="English">English</option>
          <option value="Indonesia">Indonesia</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="abstract" class="form-label">Abstract</label>
        <textarea class="form-control" id="abstract" name="abstract" required></textarea>
      </div>
      <div class="mb-3">
        <label for="doi" class="form-label">DOI</label>
        <input type="text" class="form-control" id="doi" name="doi">
      </div>
      <div class="mb-3">
        <label for="type" class="form-label">Type</label>
        <select class="form-select select2" id="type" name="type" required>
          <option value="" disabled selected>Select Type</option>
          <?php
          $publication_types = $data_access->returnAsList('SELECT * FROM publication_type ORDER BY type_name ASC;');
          foreach ($publication_types as $publication_type) {
            $type_id = $publication_type['type_id'];
            $type_name = $publication_type['type_name'];
            echo "<option value=\"$type_id\">$type_name</option>";
          }
          ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="area" class="form-label">Area</label>
        <select class="form-select select2" id="area" name="area" required>
          <option value="" disabled selected>Select Area</option>
          <?php
          $areas = $data_access->returnAsList('SELECT * FROM area_type ORDER BY area_name ASC;');
          foreach ($areas as $area) {
            $area_id = $area['area_id'];
            $area_name = $area['area_name'];
            echo "<option value=\"$area_id\">$area_name</option>";
          }
          ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="ref" class="form-label">Reference</label>
        <textarea class="form-control" id="ref" name="ref" required></textarea>
      </div>
      <div class="mb-3">
        <label for="volume" class="form-label">Volume</label>
        <input type="number" class="form-control" id="volume" name="volume">
      </div>
      <div class="mb-3">
        <label for="issue" class="form-label">Issue</label>
        <input type="number" class="form-control" id="issue" name="issue">
      </div>
      <div class="mb-3">
        <label for="pages" class="form-label">Pages</label>
        <input type="text" class="form-control" id="pages" name="pages">
      </div>
      <div class="mb-3">
        <label for="pages" class="form-label">Series</label>
        <input type="text" class="form-control" id="series" name="series">
      </div>
      <div class="mb-3">
        <div class="form-group">
          <label for="authors">Authors</label>
          <select class="form-select" id="authors" name="authors[]" multiple>
            <?php
            $authors = $data_access->returnAsList('SELECT * FROM app_user WHERE user_id <> ? ORDER BY full_name ASC;', array($_SESSION['user_id']));
            foreach ($authors as $author) {
              $user_id = $author['user_id'];
              $full_name = $author['full_name'];
              echo "<option value=\"$user_id\">$full_name</option>";
            }
            ?>
          </select>
        </div>
      </div>
      <div class="mb-3">
        <label for="content_file" class="form-label">Content File</label>
        <input type="file" class="form-control" id="content_file" name="content_file" required>
      </div>
      <div class="mb-3">
        <button type="submit" class="btn btn-primary" id="submit" name="submit">Create</button>
      </div>
    </form>
  </div>

  <!-- VENDOR JS: Feather Icon -->
  <script src="app-assets/vendors/feathericons/feather.min.js"></script>
  <!-- VENDOR JS: Bootstrap -->
  <script src="app-assets/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- CUSTOM JS -->
  <script src="assets/js/master-scripts.js"></script>
</body>

</html>