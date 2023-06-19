<?php include "./res/templates/sessions.php"; ?>

<?php
//Only logged in person can administrate profiles
if (isset($_SESSION['role']) && $_SESSION['role'] === "guest") {
  header('Refresh:1; url=index.php?site=error');
  exit();
}
?>

<div class="text-center container-fluid">

  <h1 class="h1 mb-3 fw-normal">Passwort ändern</h1>

</div>

<div class="custom-container mt-5">
    <h1>Hallo <?php echo $_SESSION["username"]; ?>!</h1>

    <form id="passwordform" method="POST">
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="old_pw" class="form-label">Altes Passwort</label>
                <input type="password" class="form-control" id="old_pw" name="old_pw">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="new-pw" class="form-label">Neues Passwort</label>
                <input type="password" class="form-control" id="new-pw"  name="new-pw">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="new-pw-validate" class="form-label">Passwort bestätigen</label>
                <input type="password" class="form-control" id="new-pw-validate"  name="new-pw-validate">
            </div>
        </div>
        <div class="row" id="pwChangeSuccess" style="display: none">
            <div class="col-md-6 mb-3">
                <div class="alert alert-success">
                Änderungen erfolgreich gespeichert!
                </div>
            </div>
        </div>
        <div class="row" id="pwChangeFail" style="display: none">
            <div class="col-md-12 mb-3">
                <div class="alert alert-danger">
                Die Passwörter müssen übereinstimmen und das alte Passwort muss korrekt eingegeben werden!
                </div>
            </div>
        </div>
        <button id="changePwButton" type="submit" class="btn btn-registrieren">Änderungen speichern</button>
       
    </form>
  </div>

