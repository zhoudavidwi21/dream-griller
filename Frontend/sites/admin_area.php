<?php include "./res/templates/sessions.php"; ?>

<?php require_once('../Backend/db/dbaccess.php'); ?>

<?php
//Only logged in person can open admin area
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

  <h1 class="h1 mb-3 fw-normal">Administrator-Verwaltung</h1>

  <div class="row justify-content-md-center">
    <div class="col-lg-2 col-md-3">

      <img class="mb-4" src="./res/img/logo/Logo_Basis_transparent_Schrift_groß_KLEIN_500x260.png" alt="Dreamgriller Logo" width="144" height="114">

    </div>
  </div>
</div>

<div class="container">
    <div class="row justify-content-center">
    <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Produkte</h5>
                    <a class="btn btn-outline-dark" href="index.php?site=manage_products">Produkte verwalten</a>
                    <a class="btn btn-outline-dark" href="index.php?site=add_product">Produkt erstellen</a>

                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Kundenbereich</h5>
                    <a class="btn btn-outline-dark" href="index.php?site=manage_users">Benutzer verwalten</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Gutscheine</h5>
                    <a class="btn btn-outline-dark" href="index.php?site=manage_coupons">Gutscheine verwalten</a>
                    <a class="btn btn-outline-dark" href="index.php?site=add_coupon">Gutschein erstellen</a>
                </div>
            </div>
        </div>
    </div>
</div>



