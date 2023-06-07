<?php include "../res/templates/sessions.php"; ?>

<?php require_once('../Backend/db/dbaccess.php'); ?>

<?php
//Only logged in person can view orders
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

  <h1 class="h1 mb-3 fw-normal">Bestellungen ansehen</h1>

  <div class="row justify-content-md-center">
    <div class="col-lg-2 col-md-3">

      <img class="mb-4" src="./res/img/logo/Logo_Basis_transparent_Schrift_groß_KLEIN_500x260.png" alt="Kastanien Logo" width="144" height="114">

    </div>
  </div>


  <h2 class="mt-5">Hallo
    <?php echo $_SESSION["username"]; ?>! <br>
    <h4>Hier sehen Sie Ihre aktuellen Bestellungen ...</h4>
  </h2>

</div>