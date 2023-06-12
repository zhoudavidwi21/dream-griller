<?php include "./res/templates/sessions.php"; ?>

<?php require_once('../Backend/db/dbaccess.php'); ?>

<?php
//Only logged in person can administrate profiles
if (isset($_SESSION['role']) && $_SESSION['role'] === "guest") {
  header('Refresh:1; url=index.php?site=error');
  exit();
}
?>

<?php
$db_obj = new mysqli($host, $dbUser, $dbPassword, $database);

//check if connection is successful
if ($db_obj->connect_error) {
  echo 'Connection error: ' . $db_obj->connect_error;
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
    <h2>Hallo <?php echo $_SESSION["username"]; ?>!</h2>
    <form>
    <div class="row">
        <div class="col-md-6 mb-3">
          <label for="profile_id" class="form-label">User-ID</label>
          <input type="text" class="form-control" id="profile_id" value="<?php echo $_SESSION['id']?>" disabled>
        </div>
        <div class="col-md-6 mb-3">
          <label for="profile_username" class="form-label">User-Name</label>
          <input type="text" class="form-control" id="profile_username" disabled>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="profile_firstname" class="form-label">Vorname</label>
          <input type="text" class="form-control" id="profile_firstname">
        </div>
        <div class="col-md-6 mb-3">
          <label for="profile_lastname" class="form-label">Nachname</label>
          <input type="text" class="form-control" id="profile_lastname">
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="profile_email" class="form-label">E-Mail</label>
          <input type="email" class="form-control" id="profile_email">
        </div>
        <div class="col-md-6 mb-3">
          <label for="profile_company" class="form-label">Firma</label>
          <input type="text" class="form-control" id="profile_company">
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 mb-3">
          <label for="profile_postcode" class="form-label">Postleitzahl</label>
          <input type="number" class="form-control" id="profile_postcode">
        </div>
        <div class="col-md-4 mb-3">
          <label for="profile_city" class="form-label">Stadt</label>
          <input type="text" class="form-control" id="profile_city">
        </div>
        <div class="col-md-4 mb-3">
          <label for="profile_adress" class="form-label">Adresse</label>
          <input type="text" class="form-control" id="profile_adress">
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="profile_paymethod" class="form-label">Zahlungsmittel</label>
          <input type="text" class="form-control" id="profile_paymethod">
        </div>
      </div>

      
      <button type="submit" class="btn btn-primary">Profil speichern</button>
    </form>
  </div>