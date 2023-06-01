<?php include "./res/templates/sessions.php"; ?>

<?php require_once('../../Backend/db/dbaccess.php'); ?>

<?php
//Nur Admins können Benutzer verwalten
if (isset($_SESSION['role']) && $_SESSION['role'] !== "admin") {
  header('Refresh:0; url=index.php?site=error');
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
?>

<!-- Reservierungen anzeigen -->
<div class="text-center container-fluid">

  <h1 class="h1 mb-3 fw-normal">Reservierungen verwalten</h1>

  <div class="row justify-content-md-center">
    <div class="col-sm-3 col-md-7 col-lg-10">
      <img class="mb-4" src="./Images/Kastanie_transparent.png" alt="Kastanien Logo" width="144" height="114">

      <!-- Reservierungsstatus auswählen -->
      <form class="row row-cols-lg-auto g-3 align-items-center" method="GET">
        <input type="hidden" name="site" value="admin_zimmer_reservieren_Verwaltung">
        <div class="col-12">
          <label class="visually-hidden" for="inlineFormSelectPref">Filter</label>
          <select class="form-select" name="reservationStatus" id="inlineFormSelectPref">
            <option selected>Filter auswählen</option>
            <option value="neu">Neu</option>
            <option value="bestätigt">Bestätigt</option>
            <option value="storniert">Storniert</option>
          </select>
        </div>
        <div class="col-12">
          <button type="submit" class="btn btn-sonstige">Submit</button>
        </div>
        <div class="col-12">
          <button type="submit" name="reset" value="true" class="btn btn-secondary">Filter zurücksetzen</button>
        </div>
      </form>

      <div class="table-responsive">
        <div class="table-wrapper">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Reservierungs ID</th>
                <th scope="col">Zimmer</th>
                <th scope="col">Firmenname</th>
                <th scope="col">Vorname</th>
                <th scope="col">Nachname</th>
                <th scope="col">Von</th>
                <th scope="col">Bis</th>
                <th scope="col">Gesamtpreis</th>
                <th scope="col">Reservierungsdatum</th>
                <th scope="col">Reservierungsstatus</th>
                <th scope="col">Funktionen</th>
              </tr>
            </thead>
            <tbody>

              <?php
              $sql = "SELECT * FROM reservations";


              //Falls bestimme Filterparameter gesetzt sind --> anderes Query
              if (isset($_GET['userId']) && !empty($_GET['userId'])) {
                $userId = $_GET['userId'];

                //Alle Reservierungen eines Benutzers auslesen
                $sql = "SELECT * FROM reservations WHERE fk_userId = $userId";
              } elseif (
                isset($_GET['reservationStatus'])
                && ($_GET['reservationStatus'] == 'neu' || $_GET['reservationStatus'] == 'bestätigt' || $_GET['reservationStatus'] == 'storniert')
              ) {
                $reservationStatus = $_GET['reservationStatus'];

                //Alle Reservierungen eines bestimmten Reservierungsstatus auslesen
                $sql = "SELECT * FROM reservations WHERE reservationStatus = '$reservationStatus'";
              } elseif (isset($_GET['reset']) && $_GET['reset'] == 'true') {
                //Alle Reservierungen auslesen
                header('Refresh:0; url=index.php?site=admin_zimmer_reservieren_Verwaltung');
              }
              $result = $db_obj->query($sql);

              while ($row = $result->fetch_assoc()) {

                //Reservierungsdaten auslesen
                $reservationId = $row['reservationId'];
                $roomId = $row['fk_roomId'];
                $userId = $row['fk_userId'];
                $reservationStatus = $row['reservationStatus'];
                $gesamtPreis = $row['totalPrice'];

                //Datum auslesen
                $date_arr = date_create($row["arrivalDate"]);
                $date_dep = date_create($row["departureDate"]);
                $date_res = date_create($row["reservationDate"]);

                //Zimmernummer auslesen
                $roomId = $row["fk_roomId"];
                $sqlRooms = "SELECT * FROM `rooms` WHERE `roomId` = $roomId";
                $stmtRooms = $db_obj->prepare($sqlRooms);
                $stmtRooms->execute();
                $resultRooms = $stmtRooms->get_result()->fetch_assoc();
                $zimmerNummer = $resultRooms["roomNumber"];
                $stmtRooms->close();

                //Benutzer auslesen
                $userId = $row["fk_userId"];
                $sqlUsers = "SELECT * FROM `users` WHERE `userId` = $userId";
                $stmtUsers = $db_obj->prepare($sqlUsers);
                $stmtUsers->execute();
                $resultUsers = $stmtUsers->get_result()->fetch_assoc();
                $userGender = $resultUsers['gender'];
                $firmenname = $resultUsers['companyName'];
                $vorname = $resultUsers["firstName"];
                $nachname = $resultUsers["lastName"];
                $stmtUsers->close();

                echo "<tr>";
                echo "<th scope='row'>$reservationId</th>";
                echo "<td>$zimmerNummer</td>";
                echo "<td>$firmenname</td>";
                echo "<td>$vorname</td>";
                echo "<td>$nachname</td>";
                echo "<td>" . date_format($date_arr, "d.m.Y") . "</td>";
                echo "<td>" . date_format($date_dep, "d.m.Y") . "</td>";
                echo "<td>" . number_format($row['totalPrice'], 2, ",", ".") . " €</td>";
                echo "<td>" . date_format($date_res, "d.m.Y H:i") . "</td>";
                echo "<td>$reservationStatus</td>";
                echo "<td>";
                echo "<a href='index.php?site=admin_zimmer_reservierung_details&reservationId=$reservationId' class='btn btn-sonstige'>Details</a>";
                echo "</td>";
                echo "</tr>";
              }
              $result->close();
              $db_obj->close();
              ?>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
</div>