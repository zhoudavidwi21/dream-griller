<?php include "./res/templates/sessions.php"; ?>

<?php require_once('../Backend/db/dbaccess.php'); ?>

<?php
//Only logged in person can manage coupons
if (isset($_SESSION['role']) && $_SESSION['role'] === "guest") {
  header('Refresh:1; url=index.php?site=error');
  exit();
}
?>

<div class="text-center container-fluid">

  <h1 class="h1 mb-3 fw-normal">Gutscheine Übersicht</h1>

  <div class="row justify-content-md-center">
    <div class="col-lg-2 col-md-3">

      <img class="mb-4" src="./res/img/logo/Logo_Basis_transparent_Schrift_groß_KLEIN_500x260.png" alt="Dreamgriller Logo" width="144" height="114">

    </div>
  </div>
</div>

<div class="row container-fluid justify-content-center mt-4">
    <table class="table table-fit">
        <thead>
        <tr>
            <th>ID</th>
            <th>Code</th>
            <th>Wert</th>
            <th>Restwert</th>
            <th>Ablaufdatum</th>
            <th>Abgelaufen</th>
        </tr>
        </thead>
        <tbody id="couponTable">

        </tbody>
    </table>
</div>