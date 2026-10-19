<?php
    class TaskRepository {
    
    public static function getAllTasksById($userId){
        $db=DB::connect();
        $query="SELECT * FROM task WHERE user_id=$userId";
        $result=$db->query($query);
        $tasks=[];
        while($task=$result->fetch_assoc()){
            $tasks[]=new Task ($task['id'] , $task['titulo'], $task['fecha_inicio'], $task['fecha_limite'], $task['estado'], $task['contenido'], $task['user_id']);
        }
        return $tasks;
    }

    public static function getTaskById($id){
        $db=DB::connect();
        $query="SELECT * FROM task WHERE id=$id";
        $result=$db->query($query);
        if($task=$result->fetch_assoc()){
            return new Task($task['id'], $task['titulo'], $task['fecha_inicio'], $task['fecha_limite'], $task['estado'], $task['contenido'], $task['user_id']);
        }
    }

    public static function getAllTasks(){
        $db=DB::connect();
        $query="SELECT * FROM task";
        $result=$db->query($query);
        $tasks=[];
        while($task=$result->fetch_assoc()){
            $tasks[]=new Task ($task['id'] , $task['titulo'], $task['fecha_inicio'], $task['fecha_limite'], $task['estado'], $task['contenido'], $task['user_id']);
        }
        return $tasks;
    }

    public static function shareTask($userId){
        $db=DB::connect();
        $query="INSERT INTO task(titulo, contenido, fecha_inicio, fecha_limite, estado, user_id) values ($task[titulo], $task[contenido], $task[fecha_inicio], $task[fecha_limite], $task[estado], $userId)";
        $result=$db->query($query);
    }
}
?>