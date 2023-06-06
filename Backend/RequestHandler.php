<?php

$requestHandler = new RequestHandler();
$requestHandler->handleRequest();

class RequestHandler {

    private $userService;
    private $productService;
    private $orderService;
    private $cartService;
    //...

    public function __construct() {
        include "./businesslogic/UserService.php";
        include "./businesslogic/ProductService.php";
        include "./businesslogic/OrderService.php";
        include "./businesslogic/CartService.php";
        $this->userService = new UserService();
        $this->productService = new ProductService();
        $this->orderService = new OrderService();
        $this->cartService = new CartService();
    }

    public function handleRequest() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = $_SERVER['REQUEST_URI'];

        // Extract the resource and additional parameters from the request URI
//        $resource = $this->getResourceFromUri($requestUri);
//        $params = $this->getParamsFromUri($requestUri);

        $resource = $_GET['resource'] ?? '';
        $params = $_GET['params'] ?? [];
        // Map the HTTP method and resource to the appropriate handler
        switch ($requestMethod) {
            case 'GET':
                $this->handleGetRequest($resource, $params);
                break;
            case 'POST':
                $this->handlePostRequest($resource, $params);
                break;
            case 'PUT':
                $this->handlePutRequest($resource, $params);
                break;
            case 'DELETE':
                $this->handleDeleteRequest($resource, $params);
                break;
            default:
                $this->error(405, "Method not allowed");
                break;
        }
    }

    private function handleGetRequest(string $resource, array $params) {
        switch ($resource) {
            case 'users':
                $this->success($this->userService->getAllUsers());
                break;
            case 'user':
                $this->success($this->userService->getUserByName($params['name']));
                break;
            case 'products':
                $this->success($this->productService->getAllProducts());
                break;
            case 'product':
                $this->success($this->productService->getProductByCategory($params['category']));
                break;
            case 'orders':
                $this->success($this->orderService->getAllOrders());
                break;
            case 'order':
                $this->success($this->orderService->getOrderById($params['id']));
                break;
            default:
                $this->error(404, "Resource not found");
                break;
        }
    }

    private function handlePostRequest(string $resource) {
        // Get the request body
        $requestBody = file_get_contents('php://input');
        $requestData = json_decode($requestBody, true);

        // Check if the request body is valid JSON
        if ($requestData.json_last_error() != JSON_ERROR_NONE) {
            $this->error(400, "Invalid request body");
        }

        switch ($resource) {
            case 'user':
                // Handle creating a new user
                break;
            case 'product':
                // Handle creating a new product
                $this->success($this->productService->saveProduct($requestData));
                break;
            case 'order':
                // Handle creating a new order
                break;
            default:
                $this->error(404, "Resource not found");
                break;
        }
    }

    private function handlePutRequest(string $resource, array $params) {
        switch ($resource) {
            case 'user':
                // Handle updating a user
                break;
            case 'product':
                // Handle updating a product
                break;
            case 'order':
                // Handle updating an order
                break;
            default:
                $this->error(404, "Resource not found");
                break;
        }
    }

    private function handleDeleteRequest(string $resource, array $params) {
        switch ($resource) {
            case 'user':
                // Handle deleting a user
                break;
            case 'product':
                // Handle deleting a product
                break;
            case 'order':
                // Handle deleting an order
                break;
            default:
                $this->error(404, "Resource not found");
                break;
        }
    }

    /** format success response and exit
     * @param mixed $data object, could be "anything"
     */
    private function success(mixed $data) {
        header('Content-Type: application/json');
        echo(json_encode($data));
        exit;
    }

    /** format error (with headers) and exit
     * @param int $code HTTP response code (4xx or 5xx)
     * @param string $msg
     */
    private function error(int $code, $msg) {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode(['error' => $msg]);
        exit;
    }

    private function getResourceFromUri($uri): string {
        $uriParts = explode('/', $uri);
        // Resource has to be the first part of uri
        return $uriParts[1];
    }

    private function getParamsFromUri($uri): array
    {
        $uriParts = explode('/', $uri);
        $params = [];

        // Extract the parameters from the URI
        for ($i = 2; $i < count($uriParts); $i += 2) {
            $params[$uriParts[$i]] = $uriParts[$i + 1];
        }

        return $params;
    }
}
