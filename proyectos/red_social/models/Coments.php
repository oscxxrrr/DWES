<?php

class Coments {
    private $id;
    private $publicacion_id;
    private $usuario_id;
    private $username;
    private $texto;

    public function __construct($publicacion_id, $usuario_id, $texto, $username = "") {
        $this->publicacion_id = $publicacion_id;
        $this->usuario_id = $usuario_id;
        $this->texto = $texto;
        $this->username = $username;
    }
    public function getId() {
        return $this->id;
    }
    public function getTexto() {
        return $this->texto;
    }

    public function getUsername() {
        return $this->username;
    }

    public function save() {
        $db = DB::connect();
        $q = "INSERT INTO comentarios (publicacion_id, usuario_id, texto) VALUES (".$this->publicacion_id.", ".$this->usuario_id.", '".$this->texto."')";
        $db->query($q);
    }

    public static function getByPost($publicacion_id) {
        $db = DB::connect();
        $q = "SELECT comentarios.*, usuarios.nombre_usuario FROM comentarios JOIN usuarios ON comentarios.usuario_id = usuarios.id WHERE publicacion_id = $publicacion_id";
        $result = $db->query($q);
        $comentarios = [];
        while($row = $result->fetch_assoc()){
            $comentarios[] = new Coments($row['publicacion_id'], $row['usuario_id'], $row['texto'], $row['nombre_usuario']);
        }
        return $comentarios;
    }

    public static function deleteById($id){
        $db = DB::connect();
        $db->query("DELETE FROM comentarios WHERE id = $id");
        $db->query("SELECT * FROM comentarios");         
    }
}

?>
