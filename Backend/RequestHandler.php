<?php

$requestHandler = new RequestHandler();
$requestHandler->handleRequest();

class RequestHandler {

    private $userService;
    private $productService;
    private $orderService;
    private $cartService;
    private $couponService;
    private $loginService;

    public function __construct() {
        include "./businesslogic/UserService.php";
        include "./businesslogic/ProductService.php";
        include "./businesslogic/OrderService.php";
        include "./businesslogic/CouponService.php";
        include "./businesslogic/LoginService.php";
        $this->userService = new UserService();
        $this->productService = new ProductService();
        $this->orderService = new OrderService();
        $this->couponService = new CouponService();
        $this->loginService = new LoginService();
    }

    public function handleRequest() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        $resource = $_GET['resource'] ?? '';
        $params = $_GET['params'] ?? [];
        // Map the HTTP method and resource to the appropriate handler
        switch ($requestMethod) {
            case 'GET':
                $this->handleGetRequest($resource, $params);
                break;
            case 'POST':
                $this->handlePostRequest($resource);
                break;
            case 'PUT':
                $this->handlePutRequest($resource, $params);
                break;
            case 'DELETE':
                $this->handleDeleteRequest($resource, $params);
                break;
            default:
                $this->error(501, "Method not implemented");
                break;
        }
    }

    private function handleGetRequest(string $resource, array $params) {
        switch ($resource) {
            case 'users':
                $this->success(200, $this->userService->getAllUsers());
                break;
            case 'user':
                $this->success(200, $this->userService->getUserById($params['id']));
                break;
            case 'products':
                $this->success(200, $this->productService->getAllProducts());
                break;
            case 'productCat':
                $this->success(200, $this->productService->getProductsByCategory($params['category'], $params['input']));
                break;
            case 'product':
                $this->success(200, $this->productService->getProductById($params['id']));
                break;
            case 'orders':
                $this->success(200, $this->orderService->getAllOrders());
                break;
            case 'order':
                $this->success(200, $this->orderService->getOrderDetailsById($params['orderId']));
                break;
            case 'orderByCustomer':
                $this->success(200, $this->orderService->getOrderByCustomerId($params['customerId']));
                break;
            case 'coupons':
                $this->success(200, $this->couponService->getAllCoupons());
                break;
            default:
                $this->error(404, "Resource not found");
                break;
        }
    }

    private function handlePostRequest(string $resource) {

        switch ($resource) {
            case 'login':
                // Handle creating a new user
                $requestData = $this->getTheRequestBody();
                $this->success(201, $this->loginService->login($requestData));
            case 'user':
                // Handle creating a new user
                $requestData = $this->getTheRequestBody();
                $this->success(201, $this->userService->saveUser($requestData));
                break;
            case 'userprofile':
                $this->success(201, $this->userService->changeUserProfile($_POST));
                break;
            case 'userpw':
                $this->success(201, $this->userService->checkPassword($_POST));
                break;
            case 'newpw':
                $this->success(201, $this->userService->validatePassword($_POST));
                break;
            case 'product':
                // Handle creating a new product
                $this->success(201, $this->productService->saveProduct($_POST, $_FILES));
                break;
            case 'changeproduct':
                // Handle creating a new product
                $this->success(201, $this->productService->changeProduct($_POST));
                break;
            case 'order':
                // Handle creating a new order
                $this->success(201, $this->orderService->createOrder($_POST));
                break;
            case 'coupon':
                $requestData = $this->getTheRequestBody();
                $this->success(201, $this->couponService->saveCoupon($requestData));
            default:
                $this->error(500, "Post request failed");
                break;
        }
    }

    private function handlePutRequest(string $resource, array $params) {
        switch ($resource) {
            case 'user':
                $this->success(204, $this->userService->changeUserStatus($params['id'], $params['newValue']));
                break;
            case 'product':
                $this->success(204, $this->productService->changeProductStatus($params['id'], $params['newValue']));
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
    private function success(int $code, mixed $data) {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data);
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

    /** gets the post request body if it was json and returns it as json decoded
     * @return mixed
     */
    private function getTheRequestBody(): mixed
    {
        // Get the request body
        $requestBody = file_get_contents('php://input');
        $requestData = json_decode($requestBody, true);
        // Check if the request body is valid JSON
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error(400, "Invalid request body");
        }
        return $requestData;
    }

}
