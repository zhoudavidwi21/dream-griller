<?php include "./res/templates/sessions.php"; ?>

<?php
//if (isset($_POST["submit"])) {
//    //function only comes in here when no errors have occurred
//    //database connection created
//    $db_obj = new mysqli($host, $dbUser, $dbPassword, $database);
//    if ($db_obj->connect_error) {
//      echo 'Connection error: ' . $db_obj->connect_error;
//      exit();
//    }
//
//    $sql = "INSERT INTO `customers`(`gender`, `company`, `firstname`, `lastname`, `adress`, `postcode`, `city`, `email`, `username`, `paymethod`, `password`)
//      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
//
//    //create SQL-statement
//    $stmt = $db_obj->prepare($sql);
//
//    $gender = $_POST['gender'];
//    $company = $_POST['company'];
//    $firstname = $_POST['firstname'];
//    $lastname = $_POST['lastname'];
//    $adress = $_POST['adress'];
//    $postcode = $_POST['postcode'];
//    $city = $_POST['city'];
//    $email = $_POST['email'];
//    $username = $_POST['username'];
//    $paymethod = $_POST['paymethod'];
//    $password = $_POST['password'];
//    //hashing password
//    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
//
//    $stmt->bind_param("sssssssssss", $gender, $company, $firstname, $lastname, $adress, $postcode, $city, $email, $username, $paymethod, $hashedPassword);
//
//    if ($stmt->execute()) {
//      //close the statement
//      $stmt->close();
//      //close the connection
//      $db_obj->close();
//      header('Refresh:0; url=index.php?site=register_confirmed');
//      exit();
//    } else {
//      echo '<p class="red"> Registrierung fehlgeschlagen! </p>';
//    }
//  }

?>

<div class="text-center container-fluid">
  <div class="row justify-content-md-center">

    <div class="col-sm-6 col-md-5 col-lg-4">

      <main class="form-signin w-100 m-auto">

        <img class="mb-4" src="./res/img/logo/Logo_Basis_transparent_Schrift_groß_KLEIN_500x260.png" alt="Dream Griller Logo" width="250" height="130">

        <h1 class="h3 mb-3 fw-normal">Bitte hier registrieren ...</h1>
        <p>* Eingabe erforderlich</p>

        <hr class="featurette-divider">

        <form id="registrationForm" method="POST" action="">
          <div class="mb-1">
            <label for="anrede" hidden>Anrede *</label>
            <select class="form-select" aria-label="Default select example" id="anrede" name="gender" required>
              <option ?>Anrede auswählen *
              </option>
              <option value="firma" >Firma</option>
              <option value="herr" >Herr</option>
              <option value="frau" >Frau</option>
              <option value="divers" >Divers</option>
            </select>
          </div>

          <div class="form-floating">
            <input type="text" class="form-control" id="firmenname" placeholder="xyz GmbH" name="company">
            <label for="firmenname">Firmenname (optional)</label>
          </div>

          <div class="form-floating">
            <input type="text" class="form-control " id="vorname" placeholder="Vorname" name="firstname" required>
            <label for="vorname">Vorname *</label>
          </div>

          <div class="form-floating">
            <input type="text" class="form-control" id="nachname" placeholder="Nachname" name="lastname" required>
            <label for="nachname">Nachname *</label>
          </div>

          <div class="form-floating">
            <input type="text" class="form-control" id="adresse" placeholder="Adresse" name="adress" required>
            <label for="adresse">Adresse *</label>
          </div>

          <div class="form-floating">
            <input type="text" class="form-control" id="postleitzahl" placeholder="Postleitzahl" name="postcode" required>
            <label for="postleitzahl">Postleitzahl *</label>
          </div>

          <div class="form-floating">
            <input type="text" class="form-control" id="ort" placeholder="Ort" name="city" required>
            <label for="ort">Ort *</label>
          </div>

          <div class="form-floating">
            <input type="email" class="form-control" id="email" placeholder="E-Mail Adresse" name="email" required>
            <label for="email">E-Mail Adresse *</label>
          </div>

          <div class="form-floating">
            <input type="text" class="form-control" id="benutzername" placeholder="Benutzername" name="username" required>
            <label for="benutzername">Benutzername *</label>
          </div>

          <br>

          <div class="mb-1">
          <label for="zahlungsmethode" hidden>Zahlungsinformationen *</label>
            <select class="form-select" aria-label="Default select example" id="zahlungsmethode" name="paymethod" required>
              <option ?>Zahlungsmethode auswählen *
              </option>
              <option value="kreditkarte" >Kreditkarte</option>
              <option value="vorkasse" >Vorkasse</option>
              <option value="bar" >Bar</option>
            </select>
          </div>

          <br>

          <div class="form-floating">
            <input type="password" class="form-control" id="passwort" placeholder="Passwort" name="password" required>
            <label for="password">Passwort *</label>
          </div>

          <div class="form-floating">
            <input type="password" class="form-control" id="passwortWiederholen" placeholder="Passwort wiederholen" name="passwordCheck" required>
            <label for="passwortWiederholen">Passwort wiederholen *</label>
          </div>

          <div class="checkbox mt-3 mb-3">
            <input type="checkbox" class="form-check-input" name="data_security" id="data_security" value="accepted" required>
            <label class="form-check-label" for="data_security"><a href="index.php?site=data_security" target="_blank">Datenschutz</a> akzeptieren *</label>

            <br>

            <input type="checkbox" class="form-check-input" name="terms_and_conditions" id="terms_and_conditions" value="accepted" required>
            <label class="form-check-label" for="terms_and_conditions"><a href="index.php?site=terms_and_conditions" target="_blank">AGBs</a>
              akzeptieren *</label>
          </div>

          <div class="d-grid gap-1">
            <!-- <div class="d-grid gap-1 col-6 mx-auto"> - kleiner und zentriert, geht auch mit m-auto -->
            <button class="w-100 btn btn-lg btn-registrieren" type="submit" name="submit" value="true">registrieren</button>
          </div>

        </form>


      </main>
    </div>
  </div>
</div>

<script src="./js/register_validation.js"></script>
