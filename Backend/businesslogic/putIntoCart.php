<?php
    require_once('../db/dbaccess.php');

    $db_obj = new mysqli($host, $dbUser, $dbPassword, $database);
    $sql = "INSERT INTO `cartitems`(`quantity`, `cart_id`, `product_id`) VALUES (?, ?, ?)";
    $stmt = $db_obj->prepare($sql);

    $quantity = 1;
    $cartId = 1; // von der Session holen!!
    $prodId = $_POST["id"];

    $stmt -> bind_param("iii", $quantity, $cartId, $prodId);

    if ($stmt->execute()){
        echo "Produkt hinzugefügt";
    }else{
        echo "Error";
    }
?>