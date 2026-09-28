<?php
    class User{
        private $id;
        public $username;
        public $password;
        public $email; 
        protected $state = 0;

        // Añadimos el email en el constructor
        public function __construct($id = 0, string $username = "", string $password = "", string $email = ""){
            $this->id = $id;
            $this->username = $username;
            $this->password = $password;
            $this->email = $email;
            $this->state = 1;
        }

        public function getId(){ 
            return $this->id; 
        }
        public function getUsername(){ 
            return $this->username; 
        }
        public function getPassword(){ 
            return $this->password; 
        }
        public function getEmail(){ 
            return $this->email; 
        } 
        public function getState(){ 
            return $this->state; 
        }
        public function setId($id){ 
            $this->id = $id; 
        }
        public function setUsername($username){ 
            $this->username = $username; 
        }
        public function setPassword($password){ 
            $this->password = $password; 
        }
        public function setEmail($email){ 
            $this->email = $email; 
        } 
    }
?>