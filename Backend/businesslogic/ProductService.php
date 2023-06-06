<?php

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
        $this->database = new Database();
    }



    public function getAllProducts(): array {
        $products = [];

        return $products;
    }

    public function getProductByCategory($category): ?array {
        $products = [];
        $sql = "SELECT * FROM `products` WHERE `name` LIKE '%$input%' AND $category = 1";
        $res = $this->database->executeQuery($sql);

        foreach ($res as $row) {
            $product = new Product(
                $row['id'],
                $row['name'],
                $row['description'],
                $row['price'],
                $row['image'],
                $row['rating'],
                $row['gas'],
                $row['charcoal'],
                $row['pellet'],
                $row['sale'],
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