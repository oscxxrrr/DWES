<?php

if(isset($_GET['post_id'])){
    Likes::alternar($_SESSION['user']->getId(), $_GET['post_id']);
    header("Location: index.php");
    exit;
}

if(isset($_GET['coment_id'])){
    Likes::alternarComment($_SESSION['user']->getId(), $_GET['coment_id']);
    header("Location: index.php");
    exit;
}

?>
