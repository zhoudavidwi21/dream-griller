<?php include "./res/templates/sessions.php"; ?>

<?php
// Verbindung zur Datenbank herstellen und Konfiguration einbinden
require_once('../Backend/config/dbaccess.php');

//only unlogged users can access login
if ($_SESSION['role'] !== "guest") {
  header('location: error.php');
  exit();
}

// POST-Daten abrufen
$username = $_POST['username'];
$password = $_POST['password'];

// Datenbankabfrage durchführen (z. B. über MySQLi oder PDO)
// Benutzernamen und Passwörter überprüfen
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (
    isset($_POST["username"])
    && isset($_POST["password"])
  ) {
    //clean up the input if the user has registered with any special characters registered
    $_POST["username"] = trim(htmlspecialchars($_POST["username"]));

    //database connection
    $db_obj = new mysqli($host, $dbUser, $dbPassword, $database);

    //error message in case of DB connection error
    if ($db_obj->connect_error) {
      echo 'Connection error: ' . $db_obj->connect_error;
      exit();
    }

 //   $sql = "SELECT * FROM `users` WHERE `username` = ? AND `enabled` = 1";
    $sql = "SELECT * FROM `users` WHERE `username` = ?";
    $stmt = $db_obj->prepare($sql);
    $stmt->bind_param("s", $_POST["username"]);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
      echo "<div class='alert alert-danger' role='alert'>
       Dein Benutzername oder Passwort ist falsch.";
      $stmt->close();
      $db_obj->close();
    } else {
      //fetch_assoc returns an array as key-value-pair, 
      //fetch_array potentially returns an array with numeric keys
      $row = $result->fetch_assoc();
      if (password_verify(trim($_POST["password"]), $row["password"])) {
        $_SESSION["id"] = $row["id"];
        $_SESSION["username"] = $row["username"];
        $_SESSION["role"] = $row["role"];
        $_SESSION['loginTime'] = time();
        $stmt->close();
        $db_obj->close();
        header('Location: ./index.php');
        exit();
      } else {
        echo "<div class='alert alert-danger' role='alert'>
        Dein Benutzername oder Passwort ist falsch.";
        $stmt->close();
        $db_obj->close();
      }
    }
  }
}

if (isset($_POST['remember']) && $_POST['remember'] == true) {
  $cookieDuration = 31536000; //valid for 1 year
  setcookie('userId', $_SESSION['userId'], time() + $cookieDuration, "/");
  setcookie('loginCookie', $cookieDuration, time() + $cookieDuration, "/");
}


// Erfolgs- oder Fehlermeldung zurückgeben
if ($valid) {
  $response = array('success' => true);
} else {
  $response = array('success' => false, 'message' => 'Anmeldung fehlgeschlagen');
}

// JSON-Antwort zurückgeben
header('Content-Type: application/json');
echo json_encode($response);
?>
