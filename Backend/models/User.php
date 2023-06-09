<?php

class User {
    public int $id;
    public string $username;
    public string $email;
    public string $password;
    public string $firstname;
    public string $lastname;
    public string $gender;
    public string $adress;
    public string $postcode;
    public string $city;
    public bool $enabled;
    public string $role;

    public function __construct(int $id, string $username, string $email, string $password, string $firstname,
        string $lastname, string $gender, string $adress, string $postcode, string $city, bool $enabled, string $role) {

        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->gender = $gender;
        $this->adress = $adress;
        $this->postcode = $postcode;
        $this->city = $city;
        $this->enabled = $enabled;
        $this->role = $role;
    }
}

?>