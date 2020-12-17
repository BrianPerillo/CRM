<?php

include_once 'dbclass.php';


class Nota extends DB{
    private $id;
    private $usuario;
    private $asunto;
    private $cuerpo;
    private $created_at;
    private $usuario_id;


    // Constructor
    public function __construct($id, $usuario, $asunto, $cuerpo, $created_at, $usuario_id){
        $this->id = $id;
        $this->usuario = $usuario;
        $this->asunto = $asunto;
        $this->cuerpo = $cuerpo;
        $this->created_at = $created_at;
        $this->usuario_id = $usuario_id;

    }

    // Métodos

    public function getId(){
        return $this->id;
    }

    public function getUsuario(){ //
        return $this->usuario;
    }

    public function getAsunto(){
        return $this->asunto;
    }

    public function getCuerpo(){
        return $this->cuerpo;
    }

    public function getCreated_at(){
        return $this->created_at;
    }

    public function getUsuario_id(){
        return $this->usuario_id;
    }

}
 ?>
