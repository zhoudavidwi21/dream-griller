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

    public function getAllProducts(): array {
        $products = [];

        return $products;
    }

    public function getProductByCategory($category): ?array {
        $products = [];

        return $products;
    }

    public function saveProduct($requestData): mixed {
        $product = new Product($requestData);

        return $product;
    }
}