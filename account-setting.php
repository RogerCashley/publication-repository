<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="app-assets/img/favicon.ico">
  <title>Profile - Publication Repository</title>

  <!-- VENDOR CSS: Bootstrap -->
  <link href="app-assets/vendors/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <!-- VENDOR JS: jQuery -->
  <script src="app-assets/vendors/jquery/jquery-3.6.3.min.js"></script>
  <!-- VENDOR CSS: Snackbar -->
  <link rel="stylesheet" href="app-assets/vendors/snackbar/snackbar.min.css">
  <!-- VENDOR JS: Snackbar -->
  <script src="app-assets/vendors/snackbar/snackbar.min.js"></script>
  <!-- VENDOR CSS: Select2 -->
  <link rel="stylesheet" href="app-assets/vendors/select2/select2-bootstrap-5-theme.min.css" />
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

  bindNavigationBar();

  function getRandomString($length = 16)
  {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';

    for ($i = 0; $i < $length; $i++) {
      $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }

    return $string;
  }

  // check if form is submitted
  if (isset($_POST["submit"])) {
    // get form data
    $current_password = $_POST["current-password"];
    $new_password = $_POST["new-password"];
    $confirm_password = $_POST["confirm-password"];

    // validate form data
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
      Snackbar::showAlert("All fields are required.");
    } elseif ($new_password !== $confirm_password) {
      Snackbar::showAlert("New password and confirm password do not match.");
    } else {
      $user_id = $_SESSION['user_id'];
      $app_user = $data_access->returnAsObject('SELECT * FROM app_user WHERE user_id = ?;', array($user_id));

      // Check if user exists
      if ($app_user != null) {
        $password_hash = $app_user->password_salt . $current_password . $app_user->password_pepper;
        if (password_verify($password_hash, $app_user->password_hash)) {
          $password_salt = getRandomString();
          $password_pepper = getRandomString();
          $new_password_hash = password_hash("$password_salt$new_password$password_pepper", PASSWORD_BCRYPT);

          $data_access->executeNonQuery('UPDATE app_user SET password_salt = ?, password_pepper = ?, password_hash = ? WHERE user_id = ?;', array(
            $password_salt,
            $password_pepper,
            $new_password_hash,
            $_SESSION['user_id']
          ));

          Snackbar::showAlert('Password updated successfully.');
        } else {
          Snackbar::showAlert("Current password is incorrect.");
        }
      }
    }
  }
  ?>

  <div class="container container-fluid">
    <div class="row">
      <div class="col-12">
        <h4 id="countHeader">Change Password</h4>
      </div>
    </div>

    <hr>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <div class="mb-3">
        <label for="current-password" class="form-label">Current Password</label>
        <input type="password" class="form-control" id="current-password" name="current-password" required>
      </div>
      <div class="mb-3">
        <label for="new-password" class="form-label">New Password</label>
        <input type="password" class="form-control" id="new-password" name="new-password" required>
      </div>
      <div class="mb-3">
        <label for="confirm-password" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="confirm-password" name="confirm-password" required>
      </div>
      <input type="submit" name="submit" value="Change" class="btn btn-primary" tabindex="4">
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