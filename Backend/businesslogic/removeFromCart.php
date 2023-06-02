<?php
    require_once('../db/dbaccess.php');

    $id = $_POST["id"];

    $db_obj = new mysqli($host, $dbUser, $dbPassword, $database);           //related cart items is deleted
    $sql = "DELETE FROM `cartitems` WHERE `id` = $id";
    $result = $db_obj->prepare($sql);

    if ($result->execute()){
        echo "Produkt gelöscht";
    }else{
        echo "Error";
    }
?>