<?php include "./Commons/sessions.php"; ?>

<?php require_once('db/dbaccess.php'); ?>

<?php
//Nur Admins können Benutzer verwalten
if (isset($_SESSION['role']) && $_SESSION['role'] !== "admin") {
  header('Refresh:1; url=index.php?site=error');
  exit();
}
?>

<?php
$db_obj = new mysqli($host, $dbUser, $dbPassword, $database);

//Überprüfung ob Verbindung erfolgreich
if ($db_obj->connect_error) {
  echo 'Connection error: ' . $db_obj->connect_error;
  exit();
}

//Benutzer deaktivieren
if (isset($_POST['deactivateUser']) && !empty($_POST['deactivateUser'])) {
  $userId = $_POST['deactivateUser'];
  $sql = "UPDATE users SET deleted = 1 WHERE userId = $userId";
  $db_obj->query($sql);
}

//Benutzer aktivieren
if (isset($_POST['activateUser']) && !empty($_POST['activateUser'])) {
  $userId = $_POST['activateUser'];
  $sql = "UPDATE users SET deleted = 0 WHERE userId = $userId";
  $db_obj->query($sql);
}
?>

<!-- Benutzer anzeigen -->
<div class="text-center container-fluid">

  <h1 class="h1 mb-3 fw-normal">Benutzer verwalten</h1>

  <div class="row justify-content-md-center">
    <div class="col-sm-3 col-md-7 col-lg-10">
      <img class="mb-4" src="./Images/Kastanie_transparent.png" alt="Kastanien Logo" width="144" height="114">

      <div class="table-responsive">
        <div class="table-wrapper">
          <form method="POST" id="userManagement">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">User ID</th>
                  <th scope="col">Anrede</th>
                  <th scope="col">Firmenname</th>
                  <th scope="col">Vorname</th>
                  <th scope="col">Nachname</th>
                  <th scope="col">Benutzername</th>
                  <th scope="col">Email</th>
                  <th scope="col">Rolle</th>
                  <th scope="col">Status</th>
                  <th scope="col">Funktionen</th>
                </tr>
              </thead>
              <tbody>
                <?php

                $sql = "SELECT * FROM users";
                $result = $db_obj->query($sql);

                while ($row = $result->fetch_assoc()) {
                  $userId = $row['userId'];
                  $anrede = $row['gender'];
                  $firmenname = $row['companyName'];
                  $vorname = $row['firstName'];
                  $nachname = $row['lastName'];
                  $benutzername = $row['username'];
                  $email = $row['email'];
                  $role = getRole($row['role']);
                  $status = getStatus($row['deleted']);

                  echo "<tr>";
                  echo "<th scope='row'>$userId</th>";
                  echo "<td>$anrede</td>";
                  echo "<td>$firmenname</td>";
                  echo "<td>$vorname</td>";
                  echo "<td>$nachname</td>";
                  echo "<td>$benutzername</td>";
                  echo "<td>$email</td>";
                  echo "<td>$role</td>";
                  echo "<td>$status</td>";
                  echo "<td>";
                  echo "<a href='index.php?site=admin_benutzer_bearbeiten&userId=$userId' class='btn btn-sonstige'>Bearbeiten</a>";
                  echo "</td>";
                  echo "<td>";
                  if ($status == "Aktiv") {

                    echo " 
              <button type='button' class='btn btn-sonstige' data-bs-toggle='modal' data-bs-target='#deactivateUserModal'
                data-bs-deactivateUser='$userId' data-bs-deactivateUsername='$benutzername'>Deaktivieren</button>
              ";
                  } else {
                    echo " 
                    <button type='button' class='btn btn-sonstige' data-bs-toggle='modal' data-bs-target='#activateUserModal'
                      data-bs-activateUser='$userId' data-bs-activateUsername='$benutzername'>Aktivieren</button>
                    ";
                  }
                  echo "</td>";
                  echo "<td>";
                  echo "<a href='index.php?site=admin_zimmer_reservieren_Verwaltung&userId=$userId' class='btn btn-sonstige'>Reservierungen anzeigen</a>";
                  echo "</td>";
                  echo "</tr>";
                }

                function getRole($role)
                {
                  switch ($role) {
                    case "user":
                      return "Benutzer";
                    case "admin":
                      return "Admin";
                    default:
                      return "unknown";
                  }
                }

                function getStatus($deleted)
                {
                  switch ($deleted) {
                    case 0:
                      return "Aktiv";
                    case 1:
                      return "Inaktiv";
                    default:
                      return "unknown";
                  }
                }
                ?>
              </tbody>
            </table>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deactivateUserModal" tabindex="-1" aria-labelledby="deactivateUserModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="deactivateUserModal">Benutzer deaktivieren</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p></p>
      </div>
      <div class="modal-footer">
        <form method="POST">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Nein</button>
          <input type="hidden" name="deactivateUser">
          <button type="submit" class="btn btn-primary">Ja</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="activateUserModal" tabindex="-1" aria-labelledby="activateUserModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="activateUserModal">Benutzer aktivieren</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p></p>
      </div>
      <div class="modal-footer">
        <form method="POST">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Nein</button>
          <input type="hidden" name="activateUser">
          <button type="submit" class="btn btn-primary">Ja</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  const deactivateUserModal = document.getElementById('deactivateUserModal')
  deactivateUserModal.addEventListener('show.bs.modal', event => {
    // Button that triggered the modal
    const button = event.relatedTarget
    // Extract info from data-bs-* attributes
    const userId = button.getAttribute('data-bs-deactivateUser')
    const username = button.getAttribute('data-bs-deactivateUsername')

    // Update the modal's content.
    const modalBodyParagraph = deactivateUserModal.querySelector('.modal-body p')
    const deactivateUser = deactivateUserModal.querySelector('input[name="deactivateUser"]')
    deactivateUser.value = userId
    modalBodyParagraph.textContent = `Sind Sie sich sicher, dass Sie den Benutzer ${username} deaktivieren möchten?`

  })
</script>

<script>
  const activateUserModal = document.getElementById('activateUserModal')
  activateUserModal.addEventListener('show.bs.modal', event => {
    // Button that triggered the modal
    const button = event.relatedTarget
    // Extract info from data-bs-* attributes
    const userId = button.getAttribute('data-bs-activateUser')
    const username = button.getAttribute('data-bs-activateUsername')

    // Update the modal's content.
    const modalBodyParagraph = activateUserModal.querySelector('.modal-body p')
    const activateUser = activateUserModal.querySelector('input[name="activateUser"]')
    activateUser.value = userId
    modalBodyParagraph.textContent = `Sind Sie sich sicher, dass Sie den Benutzer ${username} aktivieren möchten?`

  })
</script>