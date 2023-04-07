<?php
include_once("bin/app_code/DataHelper.php");
include_once("bin/app_code/Snackbar.php");

// Start the session
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="app-assets/img/favicon.ico">
  <title>Login - Publication Repository</title>

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
  if (isset($_POST['login'])) {
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];
    $remember_me = isset($_POST['chk_remember_me']);

    // Check for login field
    if (isset($_POST['login'])) {
      $user_id = $_POST['user_id'];
      $password = $_POST['password'];
      $remember_me = isset($_POST['chk_remember_me']);

      // Check for login field
      if (!empty($user_id) && !empty($password)) {
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
            }
            else {
              setcookie("user_id", $user_id, time() - (86400), "/");
              setcookie("password", $password, time() - (86400), "/");
            }

            // Redirect to home page
            header("Location: home.php");
            exit;
          }
        }

        Snackbar::showAlert('Username or password incorrect!');
      } else {
        Snackbar::showAlert('Username and password field must be filled!');
      }
    }
  }
  ?>

  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <div class="d-flex align-items-center justify-content-center vh-100">
      <div class="row justify-content-md-center">
        <div class="col-12 col-md-6 px-0 px-md-1">
          <div class="card border-sm-0">
            <img src="app-assets/img/sampoerna-university-logo.png" class="img-fluid rounded-start m-auto pt-5" style="width: 180px;" alt="..." />
            <div class="card-body p-5">
              <h3 class="card-title text-center pb-3">Login</h3>

              <div class="row">
                <div class="col-12 mb-2">
                  <label>User Id</label>

                  <input name="user_id" id="user_id" type="text" class="form-control" autofocus="true" tabindex="1" value="<?php echo isset($_COOKIE['user_id']) ? $_COOKIE['user_id'] : ""; ?>">
                </div>
                <div class="col-12 mb-2">
                  <label>Password</label>
                  <input name="password" id="password" type="password" class="form-control" tabindex="2" value="<?php echo isset($_COOKIE['password']) ? $_COOKIE['password'] : ""; ?>">
                </div>
                <div class="col-12 mb-5">
                  <input type="checkbox" class="form-check-input cursor-pointer" id="chk_remember_me" name="chk_remember_me" tabindex="3" <?php echo (isset($_COOKIE['password']) && isset($_COOKIE['password'])) ? "checked" : ""; ?>>
                  <label class="form-check-label cursor-pointer" for="chk_remember_me">Remember Me</label>
                </div>
                <div class="col-12 mb-2 d-grid gap-2">
                  <input type="submit" name="login" value="Login" class="btn btn-primary" tabindex="4">
                </div>

                <div class="col-12 mb-2">
                  <hr />
                </div>

                <div class="col-12 mb-2 text-center">
                  Login to start your adventure! 🚀
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- VENDOR JS: Bootstrap -->
  <script src="app-assets/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>