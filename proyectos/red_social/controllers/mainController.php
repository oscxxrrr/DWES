<?php
// cargar modelos
require_once("models/User.php");
require_once("models/Post.php");
require_once("models/Coments.php");
require_once("models/Likes.php");
require_once("helpers/fileHelper.php");

session_start();

if(isset($_GET['c'])){
    require_once("controllers/".$_GET['c']."Controller.php");
}

if(isset($_GET['login'])){
    require_once("views/loginView.phtml");
    exit;
}

if(isset($_GET['register'])){
    require_once("views/registerView.phtml");
    exit;
}

require_once("views/mainView.phtml");

?>