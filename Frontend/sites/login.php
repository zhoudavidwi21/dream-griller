<?php include "./res/templates/sessions.php"; ?>

<?php require_once('../Backend/config/dbaccess.php'); ?>

<?php
if (isset($_SESSION['role']) && $_SESSION['role'] !== "guest") {
  header('location: ?site=error');
  exit();
}
?>

<div class="text-center container-fluid">
  <div class="row">
    <div class="col">
    </div>
    <div class="col-sm-6 col-md-5 col-lg-3">
      <main class="form-signin w-100 m-auto">
        <?php if (!isset($_SESSION["username"])) { ?>
          <form method="POST" id="loginForm" action="">
            <img class="mb-4" src="./res/img/logo/Logo_Basis_transparent_Schrift_groß_KLEIN_500x260.png" alt="Dream Griller Logo" width="250" height="130">
            <h1 class="h3 mb-3 fw-normal">Bitte hier anmelden ...</h1>
            <div class="form-floating">
              <input type="text" class="form-control has-validation
                        <?php if (isset($_POST['username']) && $_SESSION['role'] === 'guest') {
                          echo "is-invalid";
                        } ?>" id="floatingInput" placeholder="Benutzername oder E-Mail" name="username">
              <label for="floatingInput">Benutzername oder E-Mail</label>
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
                <input type="checkbox" name="remember" value="true"> Eingeloggt bleiben
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
