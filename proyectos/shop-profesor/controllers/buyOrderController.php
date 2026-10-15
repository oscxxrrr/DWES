<?php

if(isset($_POST['makeOrder'])){   
    $order=OrderRepository::getOrderById($_POST['id']);

    // comprobar si hay stock suficiente
    foreach($order->getOrderLines() as $ol){
        if($ol->getQuantity() > $ol->getProduct()->getStock()){
            echo "producto sin stock";
            exit;
        }
    }

    $db=DB::connect();
    
    $q = "UPDATE orders SET status = 1 WHERE id = ".$order->getId();
    $db->query($q);

    // restar stock de los productos comprados
    foreach($order->getOrderLines() as $ol){
        $db->query("UPDATE products SET stock = stock - ".$ol->getQuantity()." WHERE id = ".$ol->getProduct()->getId());
    }

    // crear carrito nuevo
    if(isset($_SESSION['user'])){
        OrderRepository::createCarrito($_SESSION['user']->getId());
    }   
    
    // ir a la vista de la compra
    require_once('views/orderCompleteView.phtml');  
    exit;
}

if(isset($_GET['show'])){
    $order=OrderRepository::getOrderById($_POST['id']);
    require_once('views/showBuyOrderView.phtml');
    exit;
}   