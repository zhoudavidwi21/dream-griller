<?php
include "./models/User.php";
session_start();

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
//                $row['password'],
                $row['firstname'],
                $row['lastname'],
                $row['company'],
                $row['gender'],
                $row['adress'],
                $row['postcode'],
                $row['city'],
                $row['paymethod'],
                boolval($row['enabled']),
                $row['role']
            );
            $users[] = $user;
        }
        return $users;

    }

    public function changeUserStatus($id, $newValue){
        $query = "UPDATE customers SET `enabled` = $newValue WHERE `id` = $id";
        $res = $this->database->executeQuery($query);
    }

    public function changeUserProfile($formdata){
        $id = $formdata['profile_id'];
        $firstname = $formdata['profile_firstname'];
        $lastname = $formdata['profile_lastname'];
        $email = $formdata['profile_email'];
        $company = $formdata['profile_company'];
        $postcode = $formdata['profile_postcode'];
        $city = $formdata['profile_city'];
        $adress = $formdata['profile_adress'];
        $paymethod = $formdata['profile_paymethod'];

        $query = "UPDATE customers SET email = :email, firstname = :firstname, lastname = :lastname,
            company = :company, adress = :adress, postcode = :postcode, city = :city, paymethod = :paymethod
            WHERE id = :id";

        $params = array(
            ':email' => $email,
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':company' => $company,
            ':adress' => $adress,
            ':postcode' => $postcode,
            ':city' => $city,
            ':paymethod' => $paymethod,
            ':id' => $id
        );

        $this->database->executeQuery($query, $params);
        
    }

    public function getUserById($id){

        $query = "SELECT * FROM customers WHERE id = :userId";
        $params = ['userId' => $id];
        $res = $this->database->executeQuery($query, $params);

        $row = $res[0];
        $user = new User(
            $row['id'],
            $row['username'],
            $row['email'],
            // $row['password'],
            $row['firstname'],
            $row['lastname'],
            $row['company'],
            $row['gender'],
            $row['adress'],
            $row['postcode'],
            $row['city'],
            $row['paymethod'],
            boolval($row['enabled']),
            $row['role']
        );

        return $user;
    }

    public function checkPassword($post){
        $plainPassword = $post['password'];
        $userId = $post['id'];

        $query = "SELECT `password` FROM customers WHERE id = :userId";
        $params = ['userId' => $userId];
        $res = $this->database->executeQuery($query, $params);

        $hashedPassword = $res[0]['password'];

        if (password_verify($plainPassword, $hashedPassword)) {
            return true;
        } else {
            return false;
        }

    }

    public function validatePassword($post){
        $old = $post['old'];
        $new = $post['new'];
        $newPwValidation = $post['newPwValidation'];
        $userId = $_SESSION['id'];

        $query = "SELECT `password` FROM customers WHERE id = :userId";
        $params = ['userId' => $userId];
        $res = $this->database->executeQuery($query, $params);

        $hashedPassword = $res[0]['password'];

        if(!password_verify($new, $hashedPassword)                      //neues Passwort != Passwort aus DB
        && $new === $newPwValidation                                    //neues Passwort == Passwort zum Bestätigen
        && password_verify($old, $hashedPassword)                       //altes Passwort == altes Passwort aus DB
        ){
            $dbPassword = password_hash($new, PASSWORD_DEFAULT);

            $query = "UPDATE customers SET `password` = :password  WHERE id = :userId";
            $params = array(
                ':userId' => $userId,
                ':password' => $dbPassword
            );
            $this->database->executeQuery($query, $params);

            return true;

        }else{
            
            return false;
        }

    }

}