<?php

//cargar modelos
require_once("models/User.php");
require_once("models/Product.php");
require_once("models/Order.php");
require_once("models/OrderLine.php");
require_once("models/Cart.php");
require_once("models/ProductRepository.php");
require_once("models/OrderRepository.php");
require_once("models/OrderLineRepository.php");
require_once("models/UserRepository.php");

session_start();

if(isset($_GET['c'])){
    require_once("controllers/".$_GET['c']."Controller.php");
}

//hacer login
if(isset($_POST['login'])){
    $db = DB::connect();
    $result = $db->query("SELECT * FROM users WHERE username='".$_POST['username']."'");
    if($row = $result->fetch_assoc()){
        if($row['password'] == md5($_POST['password'])){
            $_SESSION['user'] = new User($row['id'], $row['username']);
        }
    }
    header('location:index.php');
    exit;
}

//hacer register
if(isset($_POST['register'])){
    if($_POST['password'] == $_POST['password2']){
        $db = DB::connect();
        $db->query("INSERT INTO users VALUES (NULL, '".$_POST['username']."', '".md5($_POST['password'])."')");
    }
    header('location:index.php?login=1');
    exit;
}

//ver login
if(isset($_GET['login'])){
    require_once('views/login.phtml');
    exit;
}

//logout
if(isset($_GET['logout'])){
    session_destroy();
    header('location:index.php');
    exit;
}

//register
if(isset($_GET['register'])){
    require_once('views/register.phtml');
    exit;
}

//ver carrito
if(isset($_GET['cart'])){
    require_once('views/cart.phtml');
    exit;
}

//vista por defecto
$products = ProductRepository::getProducts();
require_once("views/mainView.phtml");

?>
