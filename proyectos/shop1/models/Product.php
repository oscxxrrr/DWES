<?php

class Product{

    private $id;
    private $name;
    private $description;
    private $price;
    private $stock;

    public function __construct($id, $name, $description, $price, $stock) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->precio = $precio;
        $this->stock = $stock;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getStock() {
        return $this->stock;
    }
}