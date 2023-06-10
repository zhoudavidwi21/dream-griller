<?php require_once('../Backend/config/dbaccess.php'); ?>

<?php
//must be on every page before the HTML
if (!isset($_SESSION)) {
  session_start(); //must be at the beginning of each session 
}

//if you are not logged in yet you do not have a role --> you will get the role guest
if (!isset($_SESSION["role"])) {
  $_SESSION["role"] = "guest";
}

if (isset($_COOKIE['loginCookie'])) {
  $sessionDuration = $_COOKIE['loginCookie'];
} else {
  $sessionDuration = 2628000; // 1 month
}

if (isset($_COOKIE['loginCookie']) && isset($_COOKIE['id'])) {
  $_SESSION['id'] = $_COOKIE['id'];

  $db_obj = new mysqli($host, $dbUser, $dbPassword, $database);

  //error message in case of DB connection error
  if ($db_obj->connect_error) {
    echo 'Connection error: ' . $db_obj->connect_error;
    exit();
  }

  $sql = "SELECT * FROM `customers` WHERE `username` = ? AND `enabled` = 1";
  $stmt = $db_obj->prepare($sql);
  $stmt->bind_param("s", $_SESSION['id']);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 0) {
    $stmt->close();
    $db_obj->close();
    header('Refresh: 1; url=logout.php');
  } else {
    //fetch_assoc returns an array as key-value-pair, 
    //fetch_array returns potentially an array with numeric keys
    $row = $result->fetch_assoc();
    $_SESSION["id"] = $row["id"];
    $_SESSION["username"] = $row["username"];
    $_SESSION["role"] = $row["role"];
    $_SESSION['loginTime'] = time();
    $stmt->close();
    $db_obj->close();
  }
}

if (isset($_SESSION['loginTime']) && time() >= $_SESSION['loginTime'] + $sessionDuration) {
  header('Refresh: 1; url=logout.php');
}
?>