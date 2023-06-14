<?php

$currentDirectory = dirname(__FILE__);
include "./models/Product.php";

/**
 * TODO: Implement Product Service Class
 *  - implements CRUD operations
 *  - DELETE product .. delete existing product
 */
class ProductService {

    private Database $database;

    public function __construct(){
        require_once "./config/Database.php";
        $this->database = new Database();
    }

    public function getAllProducts(): ?array {
        $query = "SELECT * FROM products";
        $res = $this->database->executeQuery($query);

        $products = [];

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
            $products[] = $product;
        }
        return $products;
    }

    public function changeProductStatus($id, $newValue){
        $query = "UPDATE products SET `sale` = $newValue WHERE `id` = $id";
        $res = $this->database->executeQuery($query);
    }

    public function getProductsByCategory($category, $input): ?array {
        $saleFilter = '';
        if ($input === 'active') {
            $saleFilter = 'AND `sale` = 1';
        } else if ($input === 'inactive') {
            $saleFilter = 'AND `sale` = 0';
        }

        $query = "SELECT * FROM products WHERE `name` LIKE '%$input%' AND $category = 1 AND $saleFilter = 'active'";
        $res = $this->database->executeQuery($query);

        $products = [];

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
            $products[] = $product;
        }
        return $products;
    }

    /**
     * @throws Exception
     */
    public function getProductById($productId): ?Product {
        $query = "SELECT * FROM products WHERE id = :id";
        $params = array(':id' => $productId);
        $productData = $this->database->executeQuery($query, $params);

        if (!empty($productData)) {
            $row = $productData[0];
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

            return $product;
        }

        return null;
    }

    /**
     * @throws Exception
     */
    public function saveProduct($requestData, $files): ?Product {
        // Extract data
        $name = $requestData['productName'] ?? '';
        $description = $requestData['productDescription'] ?? '';
        $price = $requestData['productPrice'] ?? 0;
        $rating = $requestData['productRating'] ?? 0;
        $gas = isset($requestData['productCategoriesGas']);
        $charcoal = isset($requestData['productCategoriesCharcoal']);
        $pellet = isset($requestData['productCategoriesPellet']);
        $sale = isset($requestData['productCategoriesSale']);
        $image = null;

        // Handle image upload/saving
        if (isset($files['productImage']) && $files['productImage']['error'] === UPLOAD_ERR_OK) {
            $imageFileName = $files['productImage']['name'];
            $imageTmpPath = $files['productImage']['tmp_name'];

            $uploadDirectory = "../Frontend/res/img/products/";

            // Generate a unique file name for the image
            $imageFilePath = $uploadDirectory . uniqid() . '_' . $imageFileName;



            // Move the uploaded image to the desired location
            if (move_uploaded_file($imageTmpPath, $imageFilePath)) {
                // Image saved successfully, update the $image property of the product
                $image = $imageFilePath;
            }
        }

        // Insert extracted Data
        $query = "INSERT INTO products (name, description, price, rating, image, gas, charcoal, pellet, sale) 
              VALUES (:name, :description, :price, :rating, :image, :gas, :charcoal, :pellet, :sale)";

        $params = array(
            ':name' => $name,
            ':description' => $description,
            ':price' => $price,
            ':rating' => $rating,
            ':image' => $image,
            ':gas' => $gas,
            ':charcoal' => $charcoal,
            ':pellet' => $pellet,
            ':sale' => $sale
        );
        $this->database->executeQuery($query, $params);

        // Get ProductId
        $productId = $this->database->getLastInsertedId();

        if ($productId) {
            return $this->getProductById($productId);
        }

        return null;
    }

}