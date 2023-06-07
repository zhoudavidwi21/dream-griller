<?php include "./res/templates/sessions.php"; ?>

<?php // include "./res/templates/register_validation.php"; ?>

<?php require_once('../Backend/db/dbaccess.php'); ?>

<?php
if (isset($_POST["submit"])) {
  if (
    $genderErr == "" && $companyErr == "" && $firstnameErr == "" && $lastnameErr == "" && $emailErr == "" && $usernameErr == ""
    && $passwordErr == "" && $passwordCheckErr == "" && $agreeDatenschutzErr == "" && $agreeAgbsErr == ""
  ) {
    //function only comes in here when no errors have occurred
    //database connection created
    $db_obj = new mysqli($host, $dbUser, $dbPassword, $database);
    if ($db_obj->connect_error) {
      echo 'Connection error: ' . $db_obj->connect_error;
      exit();
    }
    $sql = "INSERT INTO `users`
    (`username`, `email`, `password`, `gender`, `companyName`, `firstName`, `lastName`) 
    VALUES (?, ?, ?, ?, ?, ?, ?)";

    //hashing passwor
    $password = password_hash($password, PASSWORD_DEFAULT);

    //create SQL-statement
    $stmt = $db_obj->prepare($sql);

    $stmt->bind_param("sssssss", $username, $email, $password, $gender, $company, $firstname, $lastname);

    if ($stmt->execute()) {
      //close the statement
      $stmt->close();
      //close the connection
      $db_obj->close();
      header('Refresh:0; url=index.php?site=/sites/register_confirmed');
      exit();
    } else {
      echo '<p class="red"> Registrierung fehlgeschlagen! </p>';
    }
  } else {
    $_SESSION['regGender'] = $gender;
    $_SESSION['regCompany'] = $company;
    $_SESSION['regFirstname'] = $firstname;
    $_SESSION['regLastname'] = $lastname;
    $_SESSION['regUsername'] = $username;
  }
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
            <input type="text" class="form-control has-validation" id="vorname" placeholder="Vorname" name="firstname" aria-describedby="validationFirstname" value="" required>
            <label for="vorname">Vorname *</label>
          </div>

          <div class="form-floating">
            <input type="text" class="form-control has-validation" id="nachname" placeholder="Nachname" name="lastname" aria-describedby="validationLastname" value="" required>
            <label for="nachname">Nachname *</label>
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