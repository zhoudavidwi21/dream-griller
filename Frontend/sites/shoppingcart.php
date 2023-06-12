<?php include "./res/templates/sessions.php"; ?>

<?php require_once('../Backend/db/dbaccess.php'); ?>

<?php
//Only logged in person can view shoppingcart
if (isset($_SESSION['role']) && $_SESSION['role'] === "guest") {
  header('Refresh:1; url=index.php?site=error');
  exit();
}
?>