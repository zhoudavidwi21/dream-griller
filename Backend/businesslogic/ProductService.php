<?php
include "./models/Product.php";

/**
 * TODO: Implement Product Service Class
 *  - implements CRUD operations
 *  - GET products .... get all products
 *  - GET product ..... get all products by category
 *  - POST product .... save product (= create new one)
 *  - DELETE product .. delete existing product
 */
class ProductService {

    

    private Database $database;

    public function __construct(){
        include "./config/Database.php";
        $this->database = new Database();
    }



    public function getAllProducts(): ?array {
        $query = "SELECT * FROM products";
        print_r($this->database->executeQuery($query));
        return $this->database->executeQuery($query);
    }

    public function getProductByCategory($category): ?array {
        $products = [];
        $sql = "SELECT * FROM `products` WHERE $category = 1";
        $res = $this->database->executeQuery($sql);

        foreach ($res as $row) {
            $product = new Product(
                $row['id'],
                $row['name'],
                $row['description'],
                $row['price'],
                $row['image'],
                $row['rating'],
                boolval($row['gas']),
                boolval($row['charcoal']),
                boolval($row['pellet']),
                boolval($row['sale'])
            );
            $this->debug_to_console($product);
            $products[] = $product;
        }
        return $products;
    }

    public function saveProduct($requestData): mixed {
        $product = new Product($requestData);

        return $product;
    }

    function debug_to_console($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);

        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }
}