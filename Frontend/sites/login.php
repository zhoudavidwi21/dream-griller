<?php include "./res/templates/sessions.php"; ?>

<?php require_once('../Backend/config/dbaccess.php'); ?>

<?php

// Checking the 'role' variable - only unlogged users can access login
/*
if ($_SESSION['role'] !== "guest") {
  header('location: error.php');
  exit();
}  */
if (isset($_SESSION['role']) && $_SESSION['role'] !== "guest") {
  header('location: error.php');
  exit();
}

// Login with database query
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (isset($_POST["username"]) && isset($_POST["password"])) {
    // Clean up the input if the user has registered with any special characters registered
    $_POST["username"] = trim(htmlspecialchars($_POST["username"]));

    // Database connection
    $db_obj = new mysqli($host, $dbUser, $dbPassword, $database);

    // Error message in case of DB connection error
    if ($db_obj->connect_error) {
      echo 'Connection error: ' . $db_obj->connect_error;
      exit();
    }

    $sql = "SELECT * FROM `customers` WHERE `username` = ? AND `enabled` = 1";
    $stmt = $db_obj->prepare($sql);
    $stmt->bind_param("s", $_POST["username"]);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
      echo "<div class='alert alert-danger' role='alert'>
       Dein Benutzername oder Passwort ist falsch.";
      $stmt->close();
      $db_obj->close();
    } else {
      // Fetch_assoc returns an array as key-value-pair, 
      $row = $result->fetch_assoc();
      if (password_verify(trim($_POST["password"]), $row["password"])) {
        $_SESSION["id"] = $row["id"];
        $_SESSION["username"] = $row["username"];
        $_SESSION["role"] = $row["role"];
        $_SESSION['loginTime'] = time();

        $sql = "UPDATE `customers` SET `logintime` = CURRENT_TIMESTAMP WHERE `id` = ?";
        $stmt = $db_obj->prepare($sql);
        $stmt->bind_param("s", $_SESSION["id"]);
        $stmt->execute();
        $stmt->close();

        $db_obj->close();

        // Set cookies if "Eingeloggt bleiben" is checked
        if (isset($_POST['remember']) && $_POST['remember'] == true) {
          $cookieDuration = 31536000; // Valid for 1 year
          setcookie('id', $_SESSION['id'], time() + $cookieDuration, "/");
          setcookie('loginCookie', $cookieDuration, time() + $cookieDuration, "/");
        } 

        header('Location: ./index.php');
        exit();
      } else {
        echo "<div class='alert alert-danger' role='alert'>
        Dein Benutzername oder Passwort ist falsch.";
        $stmt->close();
        $db_obj->close();
      }
    }
  }
}
/*
// Set cookies if "Eingeloggt bleiben" is checked
if (isset($_POST['remember']) && $_POST['remember'] == true) {
  $cookieDuration = 31536000; // Valid for 1 year
  setcookie('id', $_SESSION['id'], time() + $cookieDuration, "/");
  setcookie('loginCookie', $cookieDuration, time() + $cookieDuration, "/");
} */

?>

<div class="text-center container-fluid">
  <div class="row">
    <div class="col">
    </div>
    <div class="col-sm-6 col-md-5 col-lg-3">
      <main class="form-signin w-100 m-auto">
        <?php if (!isset($_SESSION["username"])) { ?>
          <form method="POST">
            <img class="mb-4" src="./res/img/logo/Logo_Basis_transparent_Schrift_groß_KLEIN_500x260.png" alt="Dream Griller Logo" width="250" height="130">
            <h1 class="h3 mb-3 fw-normal">Bitte hier anmelden ...</h1>
            <div class="form-floating">
              <input type="text" class="form-control has-validation
                        <?php if (isset($_POST['username']) && $_SESSION['role'] === 'guest') {
                          echo "is-invalid";
                        } ?>" id="floatingInput" placeholder="Benutzername" name="username">
              <label for="floatingInput">Benutzername</label>
            </div>
            <div class="form-floating">
              <input type="password" class="form-control has-validation
                    <?php if (isset($_POST['username']) && $_SESSION['role'] === 'guest') {
                      echo "is-invalid";
                    } ?>" id="floatingPassword" placeholder="Passwort" name="password" aria-describedby="validationLogin">
              <label for="floatingPassword">Passwort</label>
              <div id="validationLogin" class="invalid-feedback">
                Benutzername und Passwort stimmen nicht überein.
              </div>
            </div>
            <div class="checkbox mt-3 mb-3">
              <label>
                <input type="checkbox" name="remember" value=true> Eingeloggt bleiben
              </label>
            </div>
            <div class="d-grid gap-1">
              <button class="w-100 btn btn-lg btn-anmelden" type="submit">anmelden</button>
              <a class="w-100 btn btn-lg btn-registrieren" href="index.php?site=register" role="button">registrieren</a>
            </div>
          </form>
        <?php } ?>
      </main>
    </div>
    <div class="col">
    </div>
  </div>
</div>
