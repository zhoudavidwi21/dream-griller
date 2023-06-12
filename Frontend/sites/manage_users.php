<?php include "./res/templates/sessions.php"; ?>

<?php require_once('../Backend/db/dbaccess.php'); ?>

<?php
//Only logged in person can manage users
if (isset($_SESSION['role']) && $_SESSION['role'] === "guest") {
  header('Refresh:1; url=index.php?site=error');
  exit();
}
?>

<div class="text-center container-fluid">

  <h1 class="h1 mb-3 fw-normal">Kunden verwalten</h1>

  <div class="row justify-content-md-center">
    <div class="col-lg-2 col-md-3">

      <img class="mb-4" src="./res/img/logo/Logo_Basis_transparent_Schrift_groß_KLEIN_500x260.png" alt="Dreamgriller Logo" width="144" height="114">

    </div>
  </div>
</div>

<div class="container"  style="margin-top: 25px">       
  <table class="table table-fit">
    <thead>
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
<!--        <th>Passwort</th> -->
        <th>Vorname</th>
        <th>Nachname</th>
        <th>Firma</th>
        <th>Anrede</th>
        <th>Adresse</th>
        <th>Postleitzahl</th>
        <th>Ort</th>
        <th>Zahlmethode</th>
        <th>Aktiviert</th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody id="userTable">
      
    </tbody>
  </table>
</div>