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
        $res = $this->database->executeQuery($query);
        foreach ($res as $row) {
            $product = new Product(
                $row['id'],
                $row['name'],
                $row['description'],
                $row['price'],
                null,
                $row['rating'],
                boolval($row['gas']),
                boolval($row['charcoal']),
                boolval($row['pellet']),
                boolval($row['sale'])
            );
            $products[] = $product;
        }
        //print_r($products);
        return $products;
    }

    public function getProductsByCategory($category): ?array {
        $query = "SELECT * FROM products WHERE $category = 1";
        $res = $this->database->executeQuery($query);

        $products = [];

        foreach ($res as $row) {
            $product = new Product(
                $row['id'],
                $row['name'],
                $row['description'],
                $row['price'],
                null, // CHANGE THIS LINE
                $row['rating'],
                boolval($row['gas']),
                boolval($row['charcoal']),
                boolval($row['pellet']),
                boolval($row['sale'])
            );
            $products[] = $product;
        }
        return $products;
    }

    public function saveProduct($requestData): mixed {
        $product = new Product($requestData);

        return $product;
    }

}