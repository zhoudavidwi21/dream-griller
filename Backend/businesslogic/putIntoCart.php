<?php
    require_once('../db/dbaccess.php');

    

    $db_obj = new mysqli($host, $dbUser, $dbPassword, $database);
    //$sql = "DELETE FROM `cartitems` WHERE `id` = $id";
    //$result = $db_obj->prepare($sql);

    $sql = "INSERT INTO `cartitems`(`quantity`, `price`, `cart_id`, `product_id`) VALUES (?, ?, ?, ?)";
    $stmt = $db_obj->prepare($sql);

    $prodId = $_POST["id"];
    $quantity = 1;
    $price = 80; // DummyWert noch zu ändern!!!
    $cartId = 1; // von der Session holen!!


    $stmt -> bind_param("iiii", $quantity, $price, $cartId, $prodId);

    if ($stmt->execute()){
        echo "Produkt hinzugefügt";
    }else{
        echo "Error";
    }
?>