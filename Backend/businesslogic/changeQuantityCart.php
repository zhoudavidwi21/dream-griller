<?php
    require_once('../db/dbaccess.php');

    $id = $_POST["id"];
    $method = $_POST["method"];

    $db_obj = new mysqli($host, $dbUser, $dbPassword, $database);
    $sql = "UPDATE `cartitems` SET quantity = quantity $method 1 WHERE id = $id";           //change quantity +1 or -1
    $result = $db_obj->prepare($sql);

    if ($result->execute()){
        echo "Produktanzahl erfolgreich verändert";
    }else{
        echo "Error";
    }
?>