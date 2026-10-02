<?php
    class Article{
        private $id;
        public $title;
        public $content;
        private $idUser;
        private $comments = []; 

        public function __construct($id, string $title, string $content, $idUser){
            $this->id = $id;
            $this->title = $title;
            $this->content = $content;
            $this->idUser = $idUser;
        }

        public function getId(){ 
            return $this->id; 
        }
        public function getTitle(){ 
            return $this->title; 
        }
        public function getContent(){ 
            return $this->content; 
        }
        public function getIdUser(){ 
            return $this->idUser; 
        }
        public function getComments(){
            return $this->comments; 
        }
        public function addComment($comment){
            $this->comments[] = $comment; 
        }

        public function setContent($content){
            $this->content = $content; 
        }
        public function setTitle($title){
            $this->title = $title; 
        }
    }
?>