<?php

if(isset($_GET['post_id'])){
    Likes::alternar($_SESSION['user']->getId(), $_GET['post_id']);
    header("Location: index.php");
    exit;
}

?>
