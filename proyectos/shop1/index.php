<?php
session_start();

// Cargar conexión y modelos
require_once("db.php");
require_once("models/User.php");
require_once("models/Product.php");
require_once("models/Order.php");
require_once("models/OrderLine.php");
require_once("models/Cart.php");
require_once("models/ProductRepository.php");
require_once("models/OrderRepository.php");
require_once("models/OrderLineRepository.php");
require_once("models/UserRepository.php");

// Inicializar carrito siempre
if (!isset($_SESSION['cart']) || !is_object($_SESSION['cart'])) {
    $_SESSION['cart'] = new Cart();
}

// ---------------------------------------------------------
// LOGIN
// ---------------------------------------------------------
if (isset($_POST['login'])) {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = trim($_POST['username']);
        $password = md5(trim($_POST['password']));
        
        $db = DB::connect();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            // Comparamos el hash MD5 almacenado con el introducido
            if ($row['password'] === $password) {
                $_SESSION['user'] = new User($row['id'], $row['username']);
                $_SESSION['username'] = $row['username'];
            }
        }
        $stmt->close();
    }
    header('Location: index.php');
    exit();
}

// ---------------------------------------------------------
// REGISTRO
// ---------------------------------------------------------
if (isset($_POST['register'])) {
    if (!empty($_POST['username']) && !empty($_POST['password']) && $_POST['password'] === $_POST['password2']) {
        $username = trim($_POST['username']);
        $password = md5(trim($_POST['password']));
        
        $db = DB::connect();
        
        // Verificar si ya existe
        $stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows === 0) {
            $stmt->close();
            // Insertar nuevo usuario
            $insert = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $insert->bind_param("ss", $username, $password);
            if ($insert->execute()) {
                $insert->close();
                header('Location: index.php?login=1');
                exit();
            }
        } else {
            $stmt->close();
        }
    }
    header('Location: index.php?register=1');
    exit();
}

// ---------------------------------------------------------
// LOGOUT
// ---------------------------------------------------------
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit();
}

// ---------------------------------------------------------
// ENRUTAMIENTO DE CONTROLADORES (Ej: Carrito)
// ---------------------------------------------------------
if (isset($_GET['c'])) {
    $controllerFile = "controllers/" . $_GET['c'] . "Controller.php";
    if (file_exists($controllerFile)) {
        require_once($controllerFile);
        exit();
    }
}

// ---------------------------------------------------------
// ENRUTAMIENTO DE VISTAS
// ---------------------------------------------------------
if (isset($_GET['login'])) {
    require_once('views/login.phtml');
    exit();
}

if (isset($_GET['register'])) {
    require_once('views/register.phtml');
    exit();
}

if (isset($_GET['cart'])) {
    require_once('views/cart.phtml');
    exit();
}

// Vista por defecto: Catálogo
$products = ProductRepository::getProducts();
require_once("views/mainView.phtml");
?>