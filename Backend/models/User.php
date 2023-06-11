<?php

class User {
    public int $id;
    public string $username;
    public string $email;
//    public string $password;
    public string $firstname;
    public string $lastname;
    public string $company;
    public string $gender;
    public string $adress;
    public string $postcode;
    public string $city;
    public string $paymethod;
    public bool $enabled;
    public string $role;

    public function __construct(int $id, string $username, string $email, string $firstname,
        string $lastname, string $company, string $gender, string $adress, string $postcode, string $city, 
        string $paymethod, bool $enabled, string $role) {

        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
 //       $this->password = $password;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->company = $company;
        $this->gender = $gender;
        $this->adress = $adress;
        $this->postcode = $postcode;
        $this->city = $city;
        $this->paymethod = $paymethod;
        $this->enabled = $enabled;
        $this->role = $role;
    }
}

?>