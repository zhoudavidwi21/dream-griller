<?php require_once('../Backend/config/dbaccess.php'); ?>

<?php
// Must be on every page before the HTML
if (!isset($_SESSION)) {
  session_start(); // Must be at the beginning of each session 
}

// If you are not logged in yet, you do not have a role --> you will get the role "guest"
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

  // Error message in case of DB connection error
  if ($db_obj->connect_error) {
    echo 'Connection error: ' . $db_obj->connect_error;
    exit();
  }

  $sql = "SELECT * FROM `customers` WHERE `id` = ? AND `enabled` = 1";
  $stmt = $db_obj->prepare($sql);
  $stmt->bind_param("i", $_SESSION['id']);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 0) {
    $stmt->close();
    $db_obj->close();
    header('Refresh: 1; url=templates/logout.php');
    exit();
  } else {
    // Fetch_assoc returns an array as key-value-pair, 
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
  header('Refresh: 1; url=templates/logout.php');
} 

/*

// Check if the 'loginTime' session variable is set
if (isset($_SESSION['loginTime'])) {
  $lastLoginTime = strtotime($_SESSION['loginTime']);
  $currentTime = time();

  // Check if the time duration since the last login has exceeded the session duration
  if ($currentTime >= $lastLoginTime + $sessionDuration) {
    // User is no longer logged in, redirect them to the logout page
    header('Refresh: 1; url=logout.php');
    exit();
  } else {
    // Update the 'logintime' in the database
    $sql = "UPDATE `customers` SET `logintime` = CURRENT_TIMESTAMP WHERE `id` = ?";
    $stmt = $db_obj->prepare($sql);
    $stmt->bind_param("s", $_SESSION["id"]);
    $stmt->execute();
    $stmt->close();

    // Update the session time to the current time
    $_SESSION['loginTime'] = date('Y-m-d H:i:s', $currentTime);
  }
}


// Check if the 'loginTime' session variable is set
if (isset($_SESSION['loginTime'])) {
  $lastLoginTime = strtotime($_SESSION['loginTime']);
  $currentTime = time();

  // Check if the time duration since the last login has exceeded the session duration
  if ($currentTime >= $lastLoginTime + $sessionDuration) {
    // User is no longer logged in, redirect them to the logout page after a delay
    echo '<meta http-equiv="refresh" content="1;url=logout.php">';
    exit();
  } else {
    $db_obj = new mysqli($host, $dbUser, $dbPassword, $database);

    // Error message in case of DB connection error
    if ($db_obj->connect_error) {
      echo 'Connection error: ' . $db_obj->connect_error;
      exit();
    }

    // Update the 'logintime' in the database
    $sql = "UPDATE `customers` SET `logintime` = CURRENT_TIMESTAMP WHERE `id` = ?";
    $stmt = $db_obj->prepare($sql);
    $stmt->bind_param("s", $_SESSION["id"]);
    $stmt->execute();
    $stmt->close();

    // Update the session time to the current time
    $_SESSION['loginTime'] = date('Y-m-d H:i:s', $currentTime);

    $db_obj->close();
  }
}

*/



?>