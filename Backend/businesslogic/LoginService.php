<?php

class LoginService {

    private Database $database;

    public function __construct(){
        require_once "./config/Database.php";
        $this->database = new Database();
    }

    public function login($requestData) {
        $username = $requestData['username'] ?? '';
        $password = $requestData['password'] ?? '';
        $remember = $requestData['remember'] ?? '';

        $query = "SELECT id, username, email, password, role FROM `customers` WHERE (`username` = :username OR `email` = :email) AND `enabled` = 1";
        $params = array(
            ':username' => $username,
            ':email' => $username,
        );
        $userData = $this->database->executeQuery($query, $params);

        if (!empty($userData)) {
            $row = $userData[0];

            if (password_verify(trim($password), $row["password"])) {
                $_SESSION["id"] = $row["id"];
                $_SESSION["username"] = $row["username"];
                $_SESSION["role"] = $row["role"];
                $_SESSION['loginTime'] = time();

                $this->updateLoginTime($row["id"]);

                if ($remember === 'true') {
                    $cookieDuration = 31536000; // Valid for 1 year
                    setcookie('id', $_SESSION['id'], time() + $cookieDuration, "/");
                    setcookie('loginCookie', $cookieDuration, time() + $cookieDuration, "/");
                }
                return array('loginStatus' => 'success');
            }
            return array('loginStatus' => 'failed', 'errorCode' => 1); // 1 is for wrong password
        }
        return array('loginStatus' => 'failed', 'errorCode' => 2); // 2 is for user not found
    }

    private function updateLoginTime(mixed $id) {
        $query = "UPDATE `customers` SET `logintime` = CURRENT_TIMESTAMP WHERE `id` = :userId";
        $params = array(
            ':userId' => $id,
        );
        $this->database->executeQuery($query, $params);
    }

}