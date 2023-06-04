<?php

class Product {
    public int $id;
    public string $name;
    public string $description;
    public float $price;
    public string $picture;
    public float $rating;
    public bool $gas;
    public bool $charcoal;
    public bool $pellet;
    public bool $sale;

    public function __construct(int $id, string $name, string $description, float $price, string $picture, float $rating, bool $gas, bool $charcoal, bool $pellet, bool $sale) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->picture = $picture;
        $this->rating = $rating;
        $this->gas = $gas;
        $this->charcoal = $charcoal;
        $this->pellet = $pellet;
        $this->sale = $sale;
    }
}