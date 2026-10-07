<?php

class Cart{

    private $items=[];

    public function addItem($product_id, $quantity){
        if(isset($this->items[$product_id])){
            $this->items[$product_id] += $quantity;
        } else {
            $this->items[$product_id] = $quantity;
        }
    }

    public function removeItem($product_id){
        unset($this->items[$product_id]);
    }

    public function getItems(){
        return $this->items;
    }

    public function isEmpty(){
        return count($this->items) == 0;
    }

    public function getTotal(){
        $total=0;
        foreach($this->items as $product_id => $quantity){
            $product=ProductRepository::getProductById($product_id);
            $total += $product->getPrice() * $quantity;
        }
        return $total;
    }
}
