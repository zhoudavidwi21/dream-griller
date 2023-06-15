<?php
include "./models/Order.php";

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

    public function getOrderDetailsById($orderId){
        $query = "
SELECT
  CONCAT(o.id, c.id) AS invoice_number,
  o.date AS order_date,
  c.id AS customer_id,
  c.firstname AS customer_firstname,
  c.lastname AS customer_lastname,
  c.adress AS customer_address,
  c.city AS customer_city,
  c.postcode AS customer_postcode,
  po.fk_productId AS product_id,
  p.name AS product_name,
  po.quantity,
  p.price,
  po.quantity * p.price AS subtotal,
  o.total AS invoice_total
FROM
  orders o
  INNER JOIN customers c ON o.fk_customerId = c.id
  INNER JOIN products_orders po ON o.id = po.fk_orderId
  INNER JOIN products p ON po.fk_productId = p.id
WHERE
  o.id = :orderId -- Replace <order_id> with the specific order ID you want to generate the invoice for
";
        $params = array(
            ':orderId' => $orderId
        );

        $res = $this->database->executeQuery($query, $params);

        $orderItems = [];

        foreach ($res as $row) {
            $orderLine = array(
                'productId' => $row['product_id'],
                'productName' => $row['product_name'],
                'productQuantity' => $row['quantity'],
                'productPrice' => $row['price'],
                'productSubtotal' => $row['subtotal']
            );
            $orderItems[] = $orderLine;
        }

        $row = $res[0];

        $invoiceInfo = array(
            'invoiceNumber' => $row['invoice_number'],
            'orderDate' =>  $row['order_date'],
            'customerId' =>  $row['customer_id'],
            'customerFirstname' =>  $row['customer_firstname'],
            'customerLastname' =>  $row['customer_lastname'],
            'customerAddress' =>  $row['customer_address'],
            'customerCity' =>  $row['customer_city'],
            'customerPostcode' =>  $row['customer_postcode'],
            'invoiceTotal' =>  $row['invoice_total'],
            'orderItems' =>  $orderItems
        );

        return $invoiceInfo;
    }

    public function getOrderByCustomerId($customerId) {
        $query = "SELECT * FROM orders WHERE fk_customerId = :customerId";
        $params = array(
            ':customerId' => $customerId
        );

        $res = $this->database->executeQuery($query, $params);

        $orders = [];

        foreach ($res as $row) {
            $order = new Order(
                $row['id'],
                $row['total'],
                $row['date'],
                $row['fk_customerId'],
                $row['fk_couponId']
            );
            $orders[] = $order;
        }
        return $orders;
    }
}