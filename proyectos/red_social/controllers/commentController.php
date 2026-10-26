<?php

if(isset($_GET['add'])){
    $post_id = $_GET['post_id'];
    require_once("views/addComentView.phtml");
    exit;
}

if(isset($_POST['addComment'])){
    $newComment = new Coments($_POST['post_id'], $_SESSION['user']->getId(), $_POST['texto']);
    $newComment->save();
    header("Location: index.php");
    exit;
}

if(isset($_GET['delete'])){
    $comentId = $_GET['comentId'];
    Coments::deleteById($comentId);
    header("Location: index.php");
    exit;
}

?>
