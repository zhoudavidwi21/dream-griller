<?php require_once('./db/dbaccess.php'); ?>

<?php
// Serverseitige Überprüfung der Benutzername-Eindeutigkeit
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

