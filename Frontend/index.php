<?php include "./general/sessions.php"; ?>

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

</head>

<body>

  <?php include "./general/header.php"; ?>

  <main>

    <?php

    $path = '*.php';

    $validSites = glob($path);

    if (!isset($_GET['site'])) {
      include "homepage.php";
    } else {
      if (!in_array($_GET['site'] . '.php', $validSites)) {
        include "error.php";
      } else {
        $site = $_GET['site'];
        include "$site.php";
      }
    }


    ?>

  </main>

  <?php include "./general/footer.php"; ?>

  <script src="./js/getdata.js"></script>

</body>

</html>