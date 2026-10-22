<?php
class MarkRepository {

    public static function getAllMarks(){
        $db = DB::connect();
        $query = "SELECT * FROM etiqueta";
        $result = $db->query($query);
        $marks = [];
        while($mark = $result->fetch_assoc()){
            $marks[] = new Mark($mark['id'], $mark['nombre']);
        }
        return $marks;
    }

    public static function getMarksByTaskId($taskId){
        $db = DB::connect();
        $query = "SELECT e.* FROM etiqueta e INNER JOIN task_etiqueta te ON e.id = te.etiqueta_id WHERE te.task_id = $taskId";
        $result = $db->query($query);   
        $marks = [];
        while($mark = $result->fetch_assoc()){
            $marks[] = new Mark($mark['id'], $mark['nombre']);
        }
        return $marks;
    }

    public static function addMarkToTask($taskId, $etiquetaId){
        $db = DB::connect();
        $db->query("INSERT INTO task_etiqueta (task_id, etiqueta_id) VALUES ($taskId, $etiquetaId)");
    }

    public static function deleteMarksByTaskId($taskId){
        $db = DB::connect();
        $db->query("DELETE FROM task_etiqueta WHERE task_id = $taskId");
    }

}
?>
