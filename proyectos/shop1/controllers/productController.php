<?php

if(isset($_GET['new'])){
    require_once("views/newProduct.phtml");
    exit;
}

if(isset($_GET['add'])){
    if(isset($_POST['name']) && isset($_POST['price'])){
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        $q="INSERT INTO products VALUES (NULL, '$name', '$description', '$price', '$stock')";
        $db=DB::connect();
        $db->query($q);
    }
    header('location:index.php');
    exit;
}
