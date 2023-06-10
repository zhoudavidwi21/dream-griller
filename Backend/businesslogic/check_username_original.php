<?php require_once('./db/dbaccess.php'); ?>

<?php
if (isset($_POST['username'])) {
  $username = $_POST['username'];
  
  // Funktion zur Überprüfung der Benutzername-Eindeutigkeit
  function isUsernameUnique($username, $db_obj)
  {
    // Überprüfung, ob der Benutzername eindeutig ist, mit prepared statement
    $sql = "SELECT * FROM `customers` WHERE BINARY `username` = ?";
    $stmt = $db_obj->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Wenn es einen Eintrag gibt, dann ist der Benutzername nicht eindeutig
    if ($result->num_rows > 0) {
      $stmt->close();
      $db_obj->close();
      return false;
    } else {
      $stmt->close();
      $db_obj->close();
      return true;
    }
  }

  // Datenbankverbindung erstellen
  $db_obj = new mysqli($host, $dbUser, $dbPassword, $database);
  if ($db_obj->connect_error) {
    die('Connection error: ' . $db_obj->connect_error);
  }

  // Benutzername-Eindeutigkeit überprüfen
  $isUnique = isUsernameUnique($username, $db_obj);

  // Ergebnis als JSON zurückgeben
  echo json_encode(['unique' => $isUnique]);
}
?>






<?php
// Serverseitige Überprüfung der Benutzername-Eindeutigkeit

// Datenbank- und Abfragecode, um den Benutzernamen mit der Datenbank abzugleichen

$username = $_GET['username'];

// Erstellen der DB-Verbindung
$db_obj = new mysqli($servername, $username, $password, $dbname);

if ($db_obj->connect_error) {
    echo 'Connection error: ' . $db_obj->connect_error;
    exit();
  }

// Überprüfen der Verbindung auf Fehler (alternativer Ansatz)
//if ($db_obj->connect_error) {
//    die("Verbindung zur Datenbank fehlgeschlagen: " . $db_obj->connect_error);
//}

// Funktion zur Überprüfung der Benutzername-Eindeutigkeit
function isUsernameUnique($username, $db_obj)
{
  // Überprüfung ob Username unique mittels prepared statement
  $sql = "SELECT * FROM `customers` WHERE BINARY `username` = ?";
  $stmt = $db_obj->prepare($sql);
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  // Wenn es einen Eintrag gibt, dann ist der Username nicht unique
  if ($result->num_rows > 0) {
    $stmt->close();
    return false;
  } else {
    $stmt->close();
    return true;
  }
}

// Überprüfen des übergebenen Benutzernamen auf Eindeutigkeit
if (isset($_GET['username'])) {
  $username = $_GET['username'];
  $unique = isUsernameUnique($username, $db_obj);

  // Simulieren einer Rückgabe, ob der Benutzername eindeutig ist oder nicht
  $response = array(
    'unique' => $unique
  );

  // JSON-Antwort zurückgeben
  header('Content-Type: application/json');
  echo json_encode($response);
}

// Schließen der Datenbankverbindung
$db_obj->close();
?>
