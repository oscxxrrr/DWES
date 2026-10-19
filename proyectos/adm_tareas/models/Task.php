<?php

class Task{

    private $id;
    private $titulo;
    private $fecha_inicio;
    private $fecha_limite;
    private $estado;
    private $contenido;
    private $usuario;
  
    public function __construct($id, $titulo, $fecha_inicio, $fecha_limite, $estado = 'pendiente', $contenido = '', $idUsuario = null) {
        $this->id = $id;
        $this->titulo = $titulo;    
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_limite = $fecha_limite;
        $this->estado = $estado;
        $this->contenido = $contenido;
        $this->usuario = UserRepository::getUserById($idUsuario);
    }
    
    public function getId() {
        return $this->id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getfecha_inicio() {
        return $this->fecha_inicio;
    }

    public function getfecha_limite() {
        return $this->fecha_limite;
    }
    
    public function getEstado() {
        return $this->estado;
    }

    public function getContenido() {
        return $this->contenido;
    }  
    
}