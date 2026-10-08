<?php

if(isset($_GET['new'])){
    require_once("views/newProduct.phtml");
    exit;
}

if(isset($_GET['add'])){
    if(isset($_POST['name']) && isset($_POST['description']) && isset($_POST['price']) && isset($_POST['stock'])){
        $q = "INSERT INTO products (name, description, price, stock) VALUES ('" . $_POST["name"] . "', '" . $_POST["description"] . "', '" . $_POST["price"] . "', '" . $_POST["stock"] . "')";
        $db->query($q);
        if($db->insert_id){
            header("Location: index.php");
            exit;
        }
    }
}
 
