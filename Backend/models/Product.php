<?php

class Product {
    public int $id;
    public string $name;
    public string $description;
    public float $price;
    public ?string $image;
    public float $rating;
    public bool $gas;
    public bool $charcoal;
    public bool $pellet;
    public bool $sale;

    public function __construct(int $id, string $name, string $description, float $price, ?string $image, float $rating, bool $gas, bool $charcoal, bool $pellet, bool $sale) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->image = $image;
        $this->rating = $rating;
        $this->gas = $gas;
        $this->charcoal = $charcoal;
        $this->pellet = $pellet;
        $this->sale = $sale;
    }
}

?>