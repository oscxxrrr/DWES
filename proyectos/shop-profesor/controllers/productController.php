<?php

require_once("helpers/fileHelper.php");

if(isset($_GET['new'])){
    require_once("views/newProduct.phtml");
    exit;
}

if(isset($_GET['add'])){
    if(!isset($_SESSION['user']) || ($_SESSION['user']->getRol()) !== "admin"){
        echo "no puedes acceder a esta funcion";
        exit;
    }

    if(isset($_POST['name'])){
        if(FileHelper::uploadFile($_FILES['image'], "public/uploads/" . $_FILES['image']['name'])){
            $name =  $_FILES['image']['name'];
        }
        $db=DB::connect();
        $q = "INSERT INTO products VALUES (NULL, '".$_POST['name']."', '".$_POST['description']."', ".$_POST['price'].", ".$_POST['stock'].", '".$_FILES['image']['name']."')";
        $db->query($q);

        header("Location: index.php?c=adminPanel&showProducts");
        exit;
    }
}

if(isset($_GET['edit'])){
    $product = ProductRepository::getProductById($_GET['edit']);
    $id = $product->getId();
    $name = $product->getName();
    $description = $product->getDescription();
    $price = $product->getPrice();
    $stock = $product->getStock();
    $image = $product->getImage();
    require_once("views/editProduct.phtml");
    exit;
}

if(isset($_GET['save'])){
    $db = DB::connect();
    if(!empty($_FILES['image']['name'])){
        FileHelper::uploadFile($_FILES['image'], "public/uploads/" . $_FILES['image']['name']);
        $q = "UPDATE products SET name='".$_POST['name']."', description='".$_POST['description']."', price=".$_POST['price'].", stock=".$_POST['stock'].", image='".$_FILES['image']['name']."' WHERE id=".$_POST['id'];
    } else {
        $q = "UPDATE products SET name='".$_POST['name']."', description='".$_POST['description']."', price=".$_POST['price'].", stock=".$_POST['stock']." WHERE id=".$_POST['id'];
    }
    $db->query($q);
    header("Location: index.php?c=adminPanel&showProducts");
    exit;
}

if(isset($_GET['delete'])){
    $db = DB::connect();
    $db->query("DELETE FROM products WHERE id=".$_GET['delete']);
    header("Location: index.php?c=adminPanel&showProducts");
    exit;
}