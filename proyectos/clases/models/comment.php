<?php
class Comment {
        private $id;
        private $comentario;
        private $idUser;
        private $idArticulo;
        private $nombreUsuario;

        public function __construct($id, $comentario, $idUser, $idArticulo, $nombreUsuario = "") {
            $this->id = $id;
            $this->comentario = $comentario;
            $this->idUser = $idUser;
            $this->idArticulo = $idArticulo;
            $this->nombreUsuario = $nombreUsuario;
        }

        public function getId() { 
            return $this->id; 
        }
        public function getComentario() { 
            return $this->comentario; 
        }
        public function getIdUser() { 
            return $this->idUser; 
        }
        public function getIdArticulo() { 
            return $this->idArticulo; 
        }
        public function getNombreUsuario() { 
            return $this->nombreUsuario; 
        }
    }
?>