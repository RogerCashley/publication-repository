<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="app-assets/img/favicon.ico">
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
        <h4 id="countHeader">Your Repositories</h4>
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
        <input id="search-input" type="text" class="form-control bg-transparent px-3" placeholder="Search Repository Name" aria-label="Search" aria-describedby="search-bar">
      </div>

      <div class="col-12 mb-2 d-flex flex-row justify-content-start">
        <div class="btn-group">
          <select id="filter-select" class="form-select border border-primary" aria-label="Filter by type">
            <option value="" data-filter-type="">All Type</option>
            <?php
            $publication_types = $data_access->returnAsList('SELECT * FROM publication_type ORDER BY type_name ASC;');
            foreach ($publication_types as $publication_type) {
              $type_name = $publication_type['type_name'];
              echo "<option value=\"$type_name\">$type_name</option>";
            }
            ?>
          </select>
        </div>

        <div class="btn-group ms-2">
          <select id="filter-area" class="form-select border border-info" aria-label="Filter by type">
            <option value="" data-filter-type="">All Area</option>
            <?php
            $area_types = $data_access->returnAsList('SELECT * FROM area_type ORDER BY area_name ASC; ');
            foreach ($area_types as $area_type) {
              $area_name = $area_type['area_name'];
              echo "<option value=\"$area_name\">$area_name</option>";
            }
            ?>
          </select>
        </div>
        <div class="btn-group ms-auto">
          <select id="filter-sort" class="form-select border border-secondary" aria-label="Filter by type">
            <option value="DESC" data-filter-type="">Latest</option>
            <option value="ASC" data-filter-type="">Oldest</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Publication content -->
    <div id="repository-container">
      <?php
      // Allow higher roles to view lower roles, but need to be in same faculty
      $publications = $data_access->returnAsList('CALL get_publications(?);', array($_SESSION['user_id']));
      foreach ($publications as $publication) {
        $shrt_abstract = substr($publication['publication_abstract'], 0, 128) . "...";
        $datetime = new DateTime($publication['publication_date']);
        echo renderRepositoryCard(
          $publication['publication_id'],
          $publication['publication_title'],
          $publication['type_name'],
          $publication['area_name'],
          $shrt_abstract,
          $datetime->format('Y-m-d')
        );
      }

      $cnt = count($publications);
      echo "<script>document.getElementById('countHeader').innerHTML = 'Your Repositories ($cnt)';</script>";
      ?>
    </div>
  </div>

  <!-- VENDOR JS: Feather Icon -->
  <script src="app-assets/vendors/feathericons/feather.min.js"></script>
  <!-- VENDOR JS: Bootstrap -->
  <script src="app-assets/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- CUSTOM JS -->
  <script src="assets/js/master-scripts.js"></script>

  <script>
    // Get references to both select elements
    const typeSelect = document.getElementById('filter-select');
    const areaSelect = document.getElementById('filter-area');
    const selectSort = document.getElementById('filter-sort');
    const searchInput = document.querySelector('#search-input');

    // Add event listeners to both select elements
    typeSelect.addEventListener('change', filterCards);
    areaSelect.addEventListener('change', filterCards);
    selectSort.addEventListener('change', filterCards);
    searchInput.addEventListener('input', filterRepositories);

    function filterCards() {
      // Get the selected option values
      const selectedType = typeSelect.value;
      const selectedArea = areaSelect.value;
      const sortOption = selectSort.value;

      // Get references to all cards
      const cards = document.querySelectorAll('.repository-card');

      // Loop through all cards and push them to the array if they match the selected options
      cards.forEach(card => {
        const cardType = card.getAttribute('data-filter-type');
        const cardArea = card.getAttribute('data-filter-area');

        if ((selectedType === '' || cardType === selectedType) && (selectedArea === '' || cardArea === selectedArea)) {
          card.classList.remove('d-none');
          card.classList.add('d-block');
        } else {
          card.classList.add('d-none');
          card.classList.remove('d-block');
        }
      });

      // Sort the array based on the selected sorting option
      const cardArray = Array.from(cards);
      if (sortOption === 'ASC') {
        cardArray.sort((a, b) => new Date(a.getAttribute('data-filter-date')).getTime() - new Date(b.getAttribute('data-filter-date')).getTime());
      } else if (sortOption === 'DESC') {
        cardArray.sort((a, b) => new Date(b.getAttribute('data-filter-date')).getTime() - new Date(a.getAttribute('data-filter-date')).getTime());
      }

      // Get a reference to the container element
      const container = document.getElementById('repository-container');

      // Remove all child nodes from the container element
      while (container.firstChild) {
        container.removeChild(container.firstChild);
      }

      // Append each card in the sorted array to the container element
      cardArray.forEach(card => {
        container.appendChild(card);
      });

      const cntBlock = document.querySelectorAll('.repository-card.d-block').length;
      document.getElementById('countHeader').innerHTML = 'Your Repositories (' + cntBlock + ')';
    }

    function filterRepositories() {
      filterCards();

      // Get the search input value
      const searchString = searchInput.value.trim().toLowerCase();

      // Get references to all repository cards
      const cards = document.querySelectorAll('.repository-card.d-block');

      // Loop through all repository cards and filter them based on the search input value
      cards.forEach(card => {
        const id = card.getAttribute('data-filter-id').toString().trim().toLocaleLowerCase();
        const title = card.querySelector('.card-title').textContent.trim().toLowerCase();
        const type = card.getAttribute('data-filter-type').toString().trim().toLocaleLowerCase();
        const area = card.getAttribute('data-filter-area').toString().trim().toLocaleLowerCase();

        if (id.includes(searchString) || title.includes(searchString) || type.includes(searchString) || area.includes(searchString)) {
          card.classList.remove('d-none');
          card.classList.add('d-block');
        } else {
          card.classList.add('d-none');
          card.classList.remove('d-block');
        }
      });

      const cntBlock = document.querySelectorAll('.repository-card.d-block').length;
      document.getElementById('countHeader').innerHTML = 'Your Repositories (' + cntBlock + ')';
    }
  </script>
</body>

</html>