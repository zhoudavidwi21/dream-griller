<?php
ob_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap implementation -->
  <?php include "bootstrap.php" ?>
  <!-- Template but./tons -->
  <link rel="stylesheet" href="./res/css/button.css">
  <!-- Template background -->
  <link href="./res/css/background.css" rel="stylesheet">
  <!-- Template shopping cart -->
  <link href="./res/css/shoppingcart.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <title>Header</title>
</head>

<body>

  <!-- Header - Navbar -->
  <nav class="navbar navbar-expand-sm">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">
        <img src="./res/img/logo/Logo_Basis_transparent_Schrift_groß_KLEIN_500x260.png" alt="Dream Griller Logo" width="125" height="65">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Homepage</a>
          </li>

          <!-- menu for all persons START -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Menü
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="index.php?site=history">Unsere Geschichte</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
             <li><a class="dropdown-item" href="index.php?site=data_security">Datenschutz</a></li>
              <li><a class="dropdown-item" href="index.php?site=terms_and_conditions">AGBs</a></li>
              <li><a class="dropdown-item" href="index.php?site=imprint">Impressum</a></li>
              <li><a class="dropdown-item" href="index.php?site=shoppingcart">Warenkorb (Test)</a></li>
            </ul>
          </li>

          <!-- menu for all persons END-->

      </div>
      <?php if (isset($_SESSION['role']) && ($_SESSION['role'] === "user" || $_SESSION['role'] === "admin")) { ?>

        <!-- menu for logged in person START-->
        <div class="d-flex gap-1 dropdown">
          <button class="btn btn-anmelden dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $_SESSION['username']; ?>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="index.php?site=profile_administration">Profil bearbeiten (In Arbeit)</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="index.php?site=view_orders">Meine Bestellungen ansehen(In Arbeit)</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <?php if ($_SESSION['role'] === "admin") { ?>
              <li><a class="dropdown-item" href="index.php?site=admin_area">Admin Bereich</a></li>
              <li><hr class="dropdown-divider"></li>
            <?php } ?>

            <li><a class="dropdown-item" href="logout.php">Logout</a></li>

          </ul>
        </div>
        <!-- menu for logged in person END-->
      <?php } else { ?>
        <div class="d-flex gap-1">
          <button id="cartbtn" type="button" data-container="body" data-toggle="popover" style="font-size:24px">
          <i class="fa fa-shopping-cart"></i><a id="quantity"></a></button>
          <a class="btn btn-anmelden" href="index.php?site=login" role="button">Login(In Arbeit)</a>
          <a class="btn btn-registrieren" href="index.php?site=register" role="button">Registration(In Arbeit)</a>
        </div>
      <?php } ?>

      <!-- Code for ShoppingCart -->
      <div id="popover_content" style="display: none">    

        <span id="cart_details"></span>
        <div id="htmltest"></div>

        <div align="right">
          <a href="#" class="btn btn-default" id="totalCart">
          <span class="glyphicon glyphicon-trash"></span>
          </a>
        </div>
        <div align="right">
          <a href="#" class="btn btn-primary" id="check_out_cart">
          <span class="glyphicon glyphicon-shopping-cart"></span> Zum Bezahlvorgang
          </a>
        </div>
      </div>
      <!-- End ShoppingCart -->

    </div>

  </nav>


</body>

</html>