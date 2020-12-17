<?php

include_once 'dbclass.php';


class Task extends DB{
    private $id;
    private $usuario;
    private $comentario;
    private $created_at;
    private $taskid; // Id de la tarea
    private	$usuario_id_comentario; // Es el id del usuario al que le corresponde la tarea y lo saco de la tabla tareas ya que ahí está guardado ese dato.
    // Constructor
    public function __construct($id, $usuario_id, $usuario_tarea_id, $nombre, $title, $descripcion, $created_at){
        $this->id = $id;
        $this->usuario = $usuario;
        $this->comentario = $comentario;
        $this->created_at = $created_at;
        $this->taskid = $taskid;
        $this->usuario_id_comentario = $usuario_id_comentario;

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
