<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>

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
</head>

<body>
  <?php
  // !IMPORTANT: Always call master page for navigation binding and authentication
  require_once("master-page.php");

  // render navigation bar
  bindNavigationBar();
  ?>

  <div class="container container-fluid">
    <div class="row">
      <div class="col-10 col-lg-6">
        <h4>Your Repositories</h4>
      </div>
      <div class="col-2 col-lg-6 text-end">
        <a class="btn btn-primary" href="create-repository.php">
          <i data-feather="file" class="text-sm"></i>
          <span class="d-inline-block align-middle d-none d-md-inline-block">Add New</span>
        </a>
      </div>
    </div>

    <hr>

    <div class="row">
      <div class="col-12 mb-2">
        <input type="text" class="form-control bg-transparent px-3" placeholder="Search Repository Name" aria-label="Search" aria-describedby="search-icon">
      </div>

      <div class="col-12 mb-2 d-flex flex-row justify-content-start">
        <div class="btn-group">
          <select class="form-select border border-primary" aria-label="Filter by type">
            <option value="" data-filter-type="">All Type</option>
            <?php
            $publication_types = $data_access->returnAsList('SELECT * FROM publication_type ORDER BY type_name ASC;');
            foreach ($publication_types as $publication_type) {
              $type_id = $publication_type['type_id'];
              $type_name = $publication_type['type_name'];
              echo "<option value=\"$type_id\" data-filter-type=\"$type_id\">$type_name</option>";
            }
            ?>
          </select>
        </div>


        <div class="btn-group ms-2">
          <select class="form-select border border-info" aria-label="Filter by type">
            <option value="" data-filter-type="">All Area</option>
            <?php
            $area_types = $data_access->returnAsList('SELECT * FROM area_type ORDER BY area_name ASC; ');
            foreach ($area_types as $area_type) {
              $area_id = $area_type['area_id'];
              $area_name = $area_type['area_name'];
              echo "<option value=\"$area_id\" data-filter-type=\"$area_id\">$area_name</option>";
            }
            ?>
          </select>
        </div>
        <div class="btn-group ms-auto">
          <button type="button" class="btn btn-outline-secondary">
            Sort
          </button>
          <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="visually-hidden">Toggle Dropdown</span>
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#" data-filter-sort="DESC">Newest</a></li>
            <li><a class="dropdown-item" href="#" data-filter-sort="ASC">Oldest</a></li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Publication content -->
    <div class="my-3">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title">Repository Name
              <span class="badge bg-primary rounded-pill">Type</span>
              <span class="badge bg-info rounded-pill">Area</span>
            </h5>
            <div class="circle rounded-circle bg-success status-circle"></div>
          </div>
          <p class="card-text">Repository description goes here.</p>
          <div class="d-flex justify-content-between align-items-center">
            <small>Uploaded on 2023-04-09</small>
            <small class="text-muted ms-2">Last updated 3 mins ago</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- VENDOR JS: Feather Icon -->
  <script src="app-assets/vendors/feathericons/feather.min.js"></script>
  <!-- VENDOR JS: Bootstrap -->
  <script src="app-assets/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- CUSTOM JS -->
  <script src="assets/js/master-scripts.js"></script>
</body>

</html>