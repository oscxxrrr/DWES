<?php

class OrderLine{

    private $id;
    private $product;
    private $quantity;
    private $price;

    public function __construct($id, $product, $quantity, $price) {
        $this->id = $id;
        $this->product = $product;
        $this->quantity = $quantity;
        $this->price = $price;
    }

    public function getId() {
        return $this->id;
    }

    public function getProduct() {
        return $this->product;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getPrice() {
        return $this->price;
    }
}