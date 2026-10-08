<?php

if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = new Cart();
}

if(isset($_POST['addcart'])){
    $_SESSION['cart']->addItem($_POST['product_id'], $_POST['quantity']);
    header('location:index.php');
    exit;
}

if(isset($_POST['remove'])){
    $_SESSION['cart']->removeItem($_POST['product_id']);
    header('location:index.php?cart=1');
    exit;
}

if(isset($_GET['checkout'])){
    $db = DB::connect();
    $user_id = $_SESSION['user']->getId();
    $total = $_SESSION['cart']->getTotal();
    $db->query("INSERT INTO orders VALUES (NULL, $user_id, $total, NOW(), 'pending')");
    $order_id = $db->insert_id;
    foreach($_SESSION['cart']->getItems() as $product_id => $quantity){
        $product = ProductRepository::getProductById($product_id);
        $price = $product->getPrice();
        $db->query("INSERT INTO order_lines VALUES (NULL, $order_id, $product_id, $quantity, $price)");
    }
    $_SESSION['cart'] = new Cart();
    header('location:index.php');
    exit;
}