<?php

class Order{

    private $id;
    private $buyer;
    private $total_price;
    private $date;
    private $status;
    private $orderLines = [];

    public function __construct($id, $buyer, $total_price, $date, $status) {
        $this->id = $id;
        $this->buyer = $buyer;
        $this->total_price = $total_price;
        $this->date = $date;
        $this->status = $status;
        $this->orderLines = [];
    }

    public function getId() {
        return $this->id;
    }

    public function getBuyer() {
        return $this->buyer;
    }

    public function getTotal() {
        return $this->total_price;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getDate() {
        return $this->date;
    }

    public function getOrderLines() {
        return $this->orderLines;
    }
}