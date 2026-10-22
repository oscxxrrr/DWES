<?php

// 1. Filtrar por ETIQUETA (mark)
if(isset($_GET['mark'])){
    $todas = $_SESSION['user']->getAllTasks();

    if(!empty($_POST['etiqueta'])){
        $tareas = [];   
        foreach($todas as $tarea){
            if($tarea->hasMark($_POST['etiqueta'])){
                $tareas[] = $tarea;               
            }
        }
    }

    require_once("views/mainView.phtml");
    exit;
}

if(isset($_GET['state'])){
    $todas = $_SESSION['user']->getAllTasks();

    if(!empty($_POST['estado'])){
        $tareas = [];
        foreach($todas as $tarea){
            if($tarea->getEstado() != $_POST['estado']){
                $tareas[] = $tarea;
            }
        }
    }

    require_once("views/mainView.phtml");
    exit;
}

?>