<?php
// Controlador para la gestión del carrito y pedidos

// Asegurar que la sesión del carrito existe y es una instancia válida de Cart
if(!isset($_SESSION['cart']) || !is_object($_SESSION['cart']) || !method_exists($_SESSION['cart'], 'addItem')){
    $_SESSION['cart'] = new Cart();
}

if(isset($_POST['addcart'])){
    if(isset($_POST['product_id']) && isset($_POST['quantity'])){
        $_SESSION['cart']->addItem($_POST['product_id'], (int)$_POST['quantity']);
    }
    header('location:index.php');
    exit;
}

if(isset($_POST['remove'])){
    if(isset($_POST['product_id']) && isset($_SESSION['cart']) && is_object($_SESSION['cart']) && method_exists($_SESSION['cart'], 'removeItem')){
        $_SESSION['cart']->removeItem($_POST['product_id']);
    }
    header('location:index.php?cart=1');
    exit;
}

if(isset($_GET['checkout'])){
    if(isset($_SESSION['user']) && isset($_SESSION['cart']) && is_object($_SESSION['cart']) && !$_SESSION['cart']->isEmpty()){
        $db = DB::connect();
        $total = $_SESSION['cart']->getTotal();
        
        // Obtener el ID del usuario de forma segura (tanto si es objeto como string)
        $user_id = is_object($_SESSION['user']) && method_exists($_SESSION['user'], 'getId') 
            ? $_SESSION['user']->getId() 
            : 1; // Fallback seguro
        
        $q = "INSERT INTO orders VALUES (NULL, $user_id, $total, NOW(), 'pending')";
        $db->query($q);
        $order_id = $db->insert_id;
        
        foreach($_SESSION['cart']->getItems() as $product_id => $quantity){
            $product = ProductRepository::getProductById($product_id);
            if($product){
                $price = $product->getPrice();
                $q = "INSERT INTO order_lines VALUES (NULL, $order_id, $product_id, $quantity, $price)";
                $db->query($q);
            }
        }
        $_SESSION['cart'] = new Cart(); // Reiniciar el carrito limpio tras la compra
    }
    header('location:index.php');
    exit;
}