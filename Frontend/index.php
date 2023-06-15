<?php include "./res/templates/sessions.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>Dream Griller</title>
  <link rel="icon" type="image/x-icon" href="./res/img/logo/Logo_Basis_transparent_Schrift_klein_KLEIN_500x260.png">

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
</head>

<body>
  <!-- Header Area --->
  <?php include "./res/templates/header.php"; ?>

  <main>

    <?php

    $path = './sites/*.php';

    $validSites = glob($path);

    if (!isset($_GET['site'])) {
      include "./sites/homepage.php";
    } else {
      if (!in_array("./sites/". $_GET['site'] . '.php', $validSites)) {
        include "./sites/error.php";
      } else {
        $site = $_GET['site'];
        include "./sites/$site.php";        
      }
    }


    ?>

  </main>

  <!-- Footer Area --->
  <?php include "./res/templates/footer.php"; ?>

  <script src="js/cart.js"></script>
  <script src="js/user.js"></script>
  <script src="js/product.js"></script>
  <script src="js/coupon.js"></script>
  <script src="js/login.js"></script>
  <script src="js/order.js"></script>
  <!--  <script src="./js/logout.js"></script>  -->

</body>

</html>