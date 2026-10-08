<?php

if(isset($_POST['makeOrder'])){
    echo "comprando...";
    
    $order=OrderRepository::getOrderById($_POST['id']);
    $q = "UPDATE orders SET status = 1 WHERE id = ".$order->getId();
    $db=DB::connect();
    $db->query($q);
    // crear carrito nuevo
    if(isset($_SESSION['user'])){
        OrderRepository::createCarrito($_SESSION['user']->getId());
    }   
    // ir a la vista de la compra
    header('location: index.php');
    exit;
}

if(isset($_GET['show'])){
    $order=OrderRepository::getOrderById($_POST['id']);
    require_once('views/showBuyOrderView.phtml');
    exit;
}   