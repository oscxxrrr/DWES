<?php

if(isset($_GET['add'])){

    //sacar el producto de la base de datos
    if(isset($_POST['id']) && isset($_POST['quantity'])){
    $product=ProductRepository::getProductById($_POST['id']);

    //tener el pedido en estado carrito del usuario
    // Si no existe (devuelve false/vacío), lo creamos en la base de datos
    $order = OrderRepository::getCarritoByUserId($_SESSION['user']->getId());
    if (!$order) {
        OrderRepository::createCarrito($_SESSION['user']->getId());    
        // Volvemos a buscarlo para obtener el objeto orden recién creado con su ID
        $order = OrderRepository::getCarritoByUserId($_SESSION['user']->getId());
    }

    // crear un orderline en pedido de usuario con producto
    if(OrderLineRepository::addOrderLineToOrder($order,$product,$_POST['quantity'])){
        //actualizar total del pedido
        $newTotal= $order->getTotal()+($product->getPrice()*$_POST['quantity']);
        $db=DB::connect();
        $q="UPDATE orders SET total_price=".$newTotal." WHERE id=".$order->getId();
        $db->query($q);

        header('location: index.php');
        exit;
    }
}

//devolviendo a la vista del carrito
   header('location: index.php');
   exit; 
}

// ELIMINAR PRODUCTO)
if(isset($_POST['delete'])){
        OrderLineRepository::removeOrderLineById($_POST['id']);
        header('location:index.php?c=order&show');
        exit;
}

if(isset($_GET['show'])){
       $order=OrderRepository::getCarritoByUserId($_SESSION['user']->getId());
    require_once('views/showOrderView.phtml');
    exit;
}