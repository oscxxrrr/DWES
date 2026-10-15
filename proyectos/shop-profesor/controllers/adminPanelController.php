<?php

if (!isset($_SESSION['user']) || $_SESSION['user']->getRol() !== 'admin') {
    header("Location: index.php");
    exit;
}

if (isset($_GET['showOrders'])) {
    $q = "SELECT orders.id, users.username, orders.date, orders.total_price FROM orders JOIN users ON orders.buyer_id = users.id WHERE orders.total_price > 0 ORDER BY id ASC";
    $db = DB::connect();
    $result = $db->query($q);
    
    echo "<h1>Listado de Pedidos</h1>";
    while ($row = $result->fetch_object()) {
        echo "ID Pedido: " . $row->id . " | Usuario: " . $row->username . " | Fecha: " . $row->date . " | Total: " . $row->total_price . "€ <a href='index.php?c=orderDetails&details=".$row->id."'>Ver detalles</a><br><br>";
    }
    echo "<br><a href='index.php?c=adminPanel'>Volver al panel admin</a>";  
    exit;
}

if (isset($_GET['showProducts'])) {     
    $q = "SELECT id, name, description, price, stock, image FROM products ORDER BY id ASC";
    $db = DB::connect();
    $result = $db->query($q);
    
    echo "<h1>Listado de Productos</h1>";
    while ($row = $result->fetch_object()) {
        
        echo "ID: " . $row->id . " | Nombre: " . $row->name . " | Descripcion: " . $row->description . " | Precio: " . $row->price . "€ | Stock: " . $row->stock . "<br>" ;
        echo "<a href='index.php?c=product&edit=".$row->id."'>Editar</a> | ";
        echo "<a href='index.php?c=product&delete=".$row->id."'>Eliminar</a><br><br>";
        if ($row->image) {
            echo '<img src="public/uploads/' . $row->image . '" style="width:200px;height:200px;object-fit:cover;vertical-align:middle;margin-right:8px;"><br><br>';
        }
    }
    echo "<br><a href='index.php?c=adminPanel'>Volver al panel admin</a>";
    exit;   
}   

require_once("views/adminView.phtml");
exit;   
