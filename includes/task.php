<?php

include_once 'dbclass.php';


class Task extends DB{
    private $id;
    private $usuario_id; //Es el id del usuario que asignó la tarea.
    private $usuario_tarea_id; //Es el id del usuario al que se le asignó la tarea.
    private $nombre;
    private $title;
    private $descripcion;
    private $created_at;

    // Constructor
    public function __construct($id, $usuario_id, $usuario_tarea_id, $nombre, $title, $descripcion, $created_at){
        $this->id = $id;
        $this->usuario_id = $usuario_id;
        $this->usuario_tarea_id = $usuario_tarea_id;
        $this->nombre = $nombre;
        $this->title = $title;
        $this->descripcion = $descripcion;
        $this->created_at = $created_at;

    }

    // Métodos
    public function setTaskPorId($idTask){
        $query = $this->connect()->prepare('SELECT * FROM task WHERE id = :idTask'); // Consulta a base de datos para settearle los datos al objeto.
        $query->execute(['idTask' => $idTask]); // Ejecuta la query.

        foreach ($query as $currentTask) { // Setea los datos.
            $this->id = $currentTask['id'];
            $this->usuario_id = $currentTask['usuario_id']; //Es el id del usuario que asignó la tarea.
            $this->usuario_tarea_id = $currentTask['usuario_tarea_id']; //Es el id del usuario al que se le asignó la tarea.
            $this->nombre = $currentTask['name'];
            $this->title = $currentTask['title'];
            $this->descripcion = $currentTask['description'];
            $this->fechaCreacion = $currentTask['created_at'];
        }
    }

    public function setTaskPorUsuario($data){
      // Setea los datos.
          $this->id = $data['id'];
          $this->usuario_id = $data['usuario_id']; //Es el id del usuario que asignó la tarea.
          $this->usuario_tarea_id = $data['usuario_tarea_id']; //Es el id del usuario al que se le asignó la tarea.
          $this->nombre = $data['name'];
          $this->title = $data['title'];
          $this->descripcion = $data['description'];
          $this->fechaCreacion = $data['created_at'];

    }

    public function getId(){
        return $this->id;
    }

    public function getUsuario_id(){ //
        return $this->usuario_id;
    }

    public function getUsuario_tarea_id(){
        return $this->usuario_tarea_id;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getDescripcion(){
        return $this->descripcion;
    }

    public function getFechaCreacion(){
        return $this->created_at;
    }

    public function obtenerTaskPorUsuario($usuario){
      $query = $this->connect()->prepare('SELECT * FROM task WHERE name  = :usuario'); // Consulta a base de datos para settearle los datos al objeto.
      $query->execute(['usuario' => $usuario]); // Ejecuta la query.
      $tareas = [];
      foreach ($query as $tarea) { // Setea los datos.
          $this->id = $tarea['id'];
          $this->idUsuarioGuardaTarea = $tarea['usuario_id'];
          $this->idUsuarioAlQueSeLeAsignaTarea = $tarea['usuario_tarea_id'];
          $this->nombre = $tarea['name'];
          $this->title = $tarea['title'];
          $this->descripcion = $tarea['description'];
          $this->fechaCreacion = $tarea['created_at'];
      }

    }

    public function obtenerTaskPorId($idUsuario){
      $query = $this->connect()->prepare('SELECT * FROM task WHERE usuario_tarea_id  = :idUsuario'); // Consulta a base de datos para settearle los datos al objeto.
      $query->execute(['idUsuario' => $idUsuario]); // Ejecuta la query.
      $tareas = [];
      foreach ($query as $tarea) { // Setea los datos.
          $this->id = $tarea['id'];
          $this->idUsuarioGuardaTarea = $tarea['usuario_id'];
          $this->idUsuarioAlQueSeLeAsignaTarea = $tarea['usuario_tarea_id'];
          $this->nombre = $tarea['name'];
          $this->title = $tarea['title'];
          $this->descripcion = $tarea['description'];
          $this->fechaCreacion = $tarea['created_at'];
      }
    }
}

?>
