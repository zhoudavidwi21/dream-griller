<?php

class OrderService{

    private Database $database;

    public function __construct(){
        require_once "./config/Database.php";
        $this->database = new Database();
    }

    public function createOrder($post){
        $totalSum = $post['total'];
        $cartitems = $post['cart'];
        $date = date('Y-m-d');
        $coupon = NULL;

        $query = "INSERT INTO orders (total, date, fk_customerId, fk_couponId) 
            VALUES (:total, :date, :customer, :coupon)";

        $params = array(
            ':total' => $totalSum,
            ':date' => $date,
            ':customer' => $_SESSION["id"],
            ':coupon' => $coupon
        );

        $this->database->executeQuery($query, $params);

        $orderId = $this->database->getLastInsertedId();
        foreach ($cartitems as $item) {
            $productId = $item['id'];
            $quantity = $item['quantity'];
        
            $query = "INSERT INTO products_orders (fk_orderId, fk_productId, quantity) 
                VALUES (:order_id, :product_id, :quantity)";
            
            $params = array(
                ':order_id' => $orderId,
                ':product_id' => $productId,
                ':quantity' => $quantity
            );
            
            $this->database->executeQuery($query, $params);
        }
    }

    public function getAllOrders(){

    }

    public function getOrderById($id){

    }
}