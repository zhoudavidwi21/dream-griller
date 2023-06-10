<?php include "./res/templates/sessions.php"; ?>

<?php // include "./res/templates/register_validation.php"; ?>

<?php require_once('../Backend/db/dbaccess.php'); ?>

<?php
if (isset($_POST["submit"])) {
    //function only comes in here when no errors have occurred
    //database connection created
    $db_obj = new mysqli($host, $dbUser, $dbPassword, $database);
    if ($db_obj->connect_error) {
      echo 'Connection error: ' . $db_obj->connect_error;
      exit();
    }
    $sql = "INSERT INTO `users`(`username`, `email`, `password`) VALUES (?, ?, ?)";

    //hashing passwor
    $password = password_hash($password, PASSWORD_DEFAULT);

    //create SQL-statement
    $stmt = $db_obj->prepare($sql);

    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
      //close the statement
      $stmt->close();
      //close the connection
      $db_obj->close();
      header('Refresh:0; url=index.php?site=register_confirmed');
      exit();
    } else {
      echo '<p class="red"> Registrierung fehlgeschlagen! </p>';
    }
  } else {


  }

?>

<div class="text-center container-fluid">
  <div class="row justify-content-md-center">

    <div class="col-sm-6 col-md-5 col-lg-4">

      <main class="form-signin w-100 m-auto">

        <img class="mb-4" src="./res/img/logo/Logo_Basis_transparent_Schrift_groß_KLEIN_500x260.png" alt="Dream Griller Logo" width="250" height="130">

        <h1 class="h3 mb-3 fw-normal">Bitte hier registrieren ...</h1>
        <p>* Eingabe erforderlich</p>

        <hr class="featurette-divider">

        <form method="POST">
          <div class="mb-1">
            <label for="anrede" hidden>Anrede *</label>
            <select class="form-select has-validation" aria-label="Default select example" id="anrede" name="gender" aria-describedby="validationGender">
              <option value="" ?>Anrede auswählen *
              </option>
              <option value="firma" >Firma</option>
              <option value="herr" >Herr</option>
              <option value="frau" >Frau</option>
              <option value="divers" >Divers</option>
            </select>
          </div>

          <div class="form-floating">
            <input type="text" class="form-control has-validation" id="firmenname" placeholder="xyz GmbH" name="company" aria-describedby="validationCompany" value="">
            <label for="firmenname">Firmenname (optional)</label>
          </div>

          <div class="form-floating">
            <input type="text" class="form-control has-validation" id="vorname" placeholder="Vorname" name="firstname" aria-describedby="validationFirstname" value="" >
            <label for="vorname">Vorname *</label>
          </div>

          <div class="form-floating">
            <input type="text" class="form-control has-validation" id="nachname" placeholder="Nachname" name="lastname" aria-describedby="validationLastname" value="" >
            <label for="nachname">Nachname *</label>
          </div>

          <div class="form-floating">
            <input type="text" class="form-control has-validation" id="adresse" placeholder="Adresse" name="adress" aria-describedby="validationAdress" value="" >
            <label for="adresse">Adresse *</label>
          </div>

          <div class="form-floating">
            <input type="text" class="form-control has-validation" id="postleitzahl" placeholder="Postleitzahl" name="postcode" aria-describedby="validationPostcode" value="" >
            <label for="postleitzahl">Postleitzahl *</label>
          </div>

          <div class="form-floating">
            <input type="text" class="form-control has-validation" id="ort" placeholder="Ort" name="city" aria-describedby="validationCity" value="" >
            <label for="ort">Ort *</label>
          </div>

          <div class="form-floating">
            <input type="email" class="form-control has-validation" id="email" placeholder="E-Mail Adresse" name="email" aria-describedby="validationEmail" required>
            <label for="email">E-Mail Adresse *</label>
          </div>

          <div class="form-floating">
            <input type="text" class="form-control has-validation" id="benutzername" placeholder="Benutzername" name="username" aria-describedby="validationUsername" value="" required>
            <label for="benutzername">Benutzername *</label>
          </div>

          <br>

          <div class="mb-1">
          <label for="zahlungsmethode" hidden>Zahlungsinformationen *</label>
            <select class="form-select has-validation" aria-label="Default select example" id="zahlungsmethode" name="method_of_payment" aria-describedby="validationMethod_of_payment">
              <option value="" ?>Zahlungsmethode auswählen *
              </option>
              <option value="kreditkarte" >Kreditkarte</option>
              <option value="vorkasse" >Vorkasse</option>
              <option value="bar" >Bar</option>
            </select>
          </div>

          <br>

          <div class="form-floating">
            <input type="password" class="form-control has-validation" id="password" placeholder="Passwort" name="password" aria-describedby="validationPassword" required>
            <label for="password">Passwort *</label>
          </div>

          <div class="form-floating">
            <input type="password" class="form-control has-validation" id="passwortWiederholen" placeholder="Passwort wiederholen" name="passwordCheck" aria-describedby="validationPasswordCheck" required>
            <label for="passwortWiederholen">Passwort wiederholen *</label>
          </div>

          <div class="checkbox mt-3 mb-3">
            <input type="checkbox" class="form-check-input has-validation" name="data_security" id="data_security" value="checked" aria-describedby="validationDataSecurity" required>
            <label class="form-check-label" for="data_security"><a href="index.php?site=/sites/data_security" target="_blank">Datenschutz</a> akzeptieren *</label>

            <br>

            <input type="checkbox" class="form-check-input has-validation" name="terms_and_conditions" id="terms_and_conditions" value="checked" aria-describedby="validationTermsAndConditions" required>
            <label class="form-check-label" for="terms_and_conditions"><a href="index.php?site=/sites/terms_and_conditions" target="_blank">AGBs</a>
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