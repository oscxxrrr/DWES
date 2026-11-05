<?php

class Likes {
    private $id;
    private $usuario_id;
    private $publicacion_id;

    public function __construct($usuario_id, $publicacion_id, $id = null) {
        $this->usuario_id = $usuario_id;
        $this->publicacion_id = $publicacion_id;
        $this->id = $id;
    }

    public function getId() { 
        return $this->id; 
    }
    public function getUsuario_id() { 
        return $this->usuario_id; 
    }
    public function getPublicacion_id() { 
        return $this->publicacion_id; 
    }

    public function save() {
        $db = DB::connect();
        $db->query("INSERT INTO likes (usuario_id, publicacion_id) VALUES ($this->usuario_id, $this->publicacion_id)");
    }

    public static function hasLiked($usuario_id, $publicacion_id) {
        $db = DB::connect();
        $res = $db->query("SELECT * FROM likes WHERE usuario_id = $usuario_id AND publicacion_id = $publicacion_id");
        return $res->num_rows > 0;
    }

    public static function alternar($usuario_id, $publicacion_id) {
        $db = DB::connect();
        if(Likes::hasLiked($usuario_id, $publicacion_id)) {
            $db->query("DELETE FROM likes WHERE usuario_id = $usuario_id AND publicacion_id = $publicacion_id");
            return false;
        } else {
            (new Likes($usuario_id, $publicacion_id))->save();
            return true;
        }
    }

    public static function countByPost($publicacion_id) {
        $db = DB::connect();
        $res = $db->query("SELECT count(*) as total FROM likes WHERE publicacion_id = $publicacion_id");
        return $res->fetch_assoc()['total'];
    }

    

    public static function hasLikedComment($usuario_id, $comentario_id) {
        $db = DB::connect();
        $res = $db->query("SELECT * FROM likes_comentarios WHERE usuario_id = $usuario_id AND comentario_id = $comentario_id");
        return $res->num_rows > 0;
    }

    public static function alternarComment($usuario_id, $comentario_id) {
        $db = DB::connect();
        if(Likes::hasLikedComment($usuario_id, $comentario_id)) {
            $db->query("DELETE FROM likes_comentarios WHERE usuario_id = $usuario_id AND comentario_id = $comentario_id");
            return false;
        } else {
            $db->query("INSERT INTO likes_comentarios (usuario_id, comentario_id) VALUES ($usuario_id, $comentario_id)");
            return true;
        }
    }

    public static function countByComment($comentario_id) {
        $db = DB::connect();
        $res = $db->query("SELECT count(*) as total FROM likes_comentarios WHERE comentario_id = $comentario_id");
        return $res->fetch_assoc()['total'];
    }
}

?>
