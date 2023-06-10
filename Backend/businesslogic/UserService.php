<?php
include "./models/User.php";

class UserService{

    private Database $database;

    public function __construct(){
        require_once "./config/Database.php";
        $this->database = new Database();
    }

    public function getAllUsers(): ?array {
        $query = "SELECT * FROM customers";
        $res = $this->database->executeQuery($query);

        $users = [];

        foreach ($res as $row) {
            $user = new User(
                $row['id'],
                $row['username'],
                $row['email'],
                $row['password'],
                $row['firstname'],
                $row['lastname'],
                $row['gender'],
                $row['adress'],
                $row['postcode'],
                $row['city'],
                boolval($row['enabled']),
                $row['role']
            );
            $users[] = $user;
        }
        return $users;

    }

    public function getUserByName($name){
        
    }

    public function changeUserStatus($id, $newValue){
        $query = "UPDATE customers SET `enabled` = $newValue WHERE `id` = $id";
        $res = $this->database->executeQuery($query);
    }
}