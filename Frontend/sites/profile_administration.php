<?php include "./res/templates/sessions.php"; ?>

<?php
//Only logged in person can administrate profiles
if (isset($_SESSION['role']) && $_SESSION['role'] === "guest") {
  header('Refresh:1; url=index.php?site=error');
  exit();
}
?>
<div class="text-center container-fluid">

  <h1 class="h1 mb-3 fw-normal">Profil bearbeiten</h1>
<!--
  <div class="row justify-content-md-center">
    <div class="col-lg-2 col-md-3">

      <img class="mb-4" src="./res/img/logo/Logo_Basis_transparent_Schrift_groß_KLEIN_500x260.png" alt="Dreamgriller Logo" width="144" height="114">

    </div>
  </div>
-->

<!--
  <h2 class="mt-5">Hallo
    <?php //echo $_SESSION["username"]; ?>! <br>
    <h4>Hier können Sie Ihre Daten ändern ...</h4>
  </h2>
-->

</div>

<div class="custom-container mt-5">
    <h1>Hallo <?php echo $_SESSION["username"]; ?>!</h1>
    <form id="profileform" method="POST">
    <div class="row">
        <div class="col-md-6 mb-3">
          <label for="profile_id" class="form-label">User-ID (nicht änderbar)</label>
          <input type="text" class="form-control" id="profile_id" name="profile_id" value="<?php echo $_SESSION['id']?>" readonly>
        </div>
        <div class="col-md-6 mb-3">
          <label for="profile_username" class="form-label">User-Name (nicht änderbar)</label>
          <input type="text" class="form-control" id="profile_username"  name="profile_username" readonly>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="profile_firstname" class="form-label">Vorname</label>
          <input type="text" class="form-control" id="profile_firstname" name="profile_firstname" required>
        </div>
        <div class="col-md-6 mb-3">
          <label for="profile_lastname" class="form-label">Nachname</label>
          <input type="text" class="form-control" id="profile_lastname" name="profile_lastname" required>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="profile_email" class="form-label">E-Mail</label>
          <input type="email" class="form-control" id="profile_email" name="profile_email" required>
        </div>
        <div class="col-md-6 mb-3">
          <label for="profile_company" class="form-label">Firma</label>
          <input type="text" class="form-control" id="profile_company" name="profile_company">
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 mb-3">
          <label for="profile_postcode" class="form-label">Postleitzahl</label>
          <input type="number" class="form-control" id="profile_postcode" name="profile_postcode" required>
        </div>
        <div class="col-md-4 mb-3">
          <label for="profile_city" class="form-label">Stadt</label>
          <input type="text" class="form-control" id="profile_city" name="profile_city" required>
        </div>
        <div class="col-md-4 mb-3">
          <label for="profile_adress" class="form-label">Adresse</label>
          <input type="text" class="form-control" id="profile_adress" name="profile_adress" required>
        </div>
      </div>
      <div class="col-md-6 mb-3">
        <label for="profile_paymethod" class="form-label">Zahlungsmittel (als Dropdown)</label>
        <select class="form-control" id="profile_paymethod" name="profile_paymethod" required>
            <option value="Kreditkarte">Kreditkarte</option>
            <option value="Vorkasse">Vorkasse</option>
            <option value="Rechnung">Rechnung</option>
        </select>
      </div>

      <h4>Änderungen bestätigen</h4>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="profile_password" class="form-label">Bitte geben Sie hier Ihr Passwort ein</label>
          <input type="password" class="form-control" id="profile_password" name="profile_password" >
        </div>
      </div>
      <div class="row" id="userChangeSuccess" style="display: none">
        <div class="col-md-6 mb-3">
          <div class="alert alert-success">
          Änderungen erfolgreich gespeichert!
          </div>
        </div>
      </div>
      <div class="row" id="userChangeFail" style="display: none">
        <div class="col-md-6 mb-3">
          <div class="alert alert-danger">
          Das Passwort wurde falsch eingegeben!
          </div>
        </div>
      </div>
      
      <button id="changeProfilButton" type="submit" class="btn btn-registrieren">Änderungen speichern</button>
      <a class="btn btn-registrieren" href="index.php?site=change_password">Passwort ändern</a>
    </form>
  </div>