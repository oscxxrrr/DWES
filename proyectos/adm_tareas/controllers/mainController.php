<?php
// cargar mdoelos:
require_once("models/User.php");
require_once("models/UserRepository.php");
require_once("models/Task.php");
require_once("models/TaskRepository.php");
require_once("models/Mark.php");
require_once("models/MarkRepository.php");

session_start();

// acciones
if(isset($_GET['c'])){
    require_once("controllers/".$_GET['c']."Controller.php");
}

if(isset($_GET['markTask'])){
    header("Location: index.php?c=task&edit=".$_GET['markTask']);
    exit;
}

// login
if(isset($_GET['login'])){
    require_once('views/login.phtml');
    exit;
}

//register
if(isset($_GET['register'])){
    require_once('views/register.phtml');
    exit;
}

//filtrar
if(isset($_POST['filter']) || isset($_GET['filter'])){
    require_once("controllers/filterController.php");
    exit;
}

// listar tareas

require_once("views/mainView.phtml");


?>