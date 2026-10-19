<?php
// cargar mdoelos:
require_once("models/User.php");
require_once("models/UserRepository.php");
require_once("models/Task.php");
require_once("models/TaskRepository.php");

session_start();

// acciones
if(isset($_GET['c'])){
    require_once("controllers/".$_GET['c']."Controller.php");
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

//share task
if(isset($_GET['shareTask'])){
    $tarea= TaskRepository::getTaskById($_GET['shareTask']);
    require_once('views/shareTask.phtml');
    exit;
}

// listar tareas

require_once("views/mainView.phtml");


?>