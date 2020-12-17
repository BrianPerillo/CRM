<?php

include_once 'dbclass.php';
require 'task.php';
require 'nota.php';

class User extends DB{
    private $nombre;
    private $username;
    private $id;
    private $tareas = []; // Array de Tareas (Clase Tasks)
    private $notas = []; // Array de Tareas (Clase Notas)
    private $comentarios = []; // Array de Comentarios  (Clase Comentarios)

    public function userExists($user, $pass){
        $md5pass = /*md5(*/$pass/*)*/;
        $query = $this->connect()->prepare('SELECT * FROM usuarios WHERE username = :user AND password = :pass');
        $query->execute(['user' => $user, 'pass' => $md5pass]);

        if($query->rowCount()){
            return true;
        }else{
            return false;
        }
    }
//SELECT * FROM usuarios WHERE username = :user (query original) --  $query->execute(['user' => $user]); ( execute original)
    public function setUser($user){
        $query = $this->connect()->prepare("SELECT *,  tk.id as tarea_id, tk.usuario as usuario_tarea, tk.usuario_id as tareas_usuario_id ,u.id as user_id,
        n.id as user_notas_id, n.usuario_id as notas_usuario_id, n.usuario as usuario_nota
        FROM usuarios u
        LEFT JOIN task tk
        ON tk.usuario_tarea_id = u.id
        LEFT JOIN notas n
        ON n.usuario_id = tk.usuario_tarea_id
        WHERE username = :user");

        $query->execute(['user' => $user]); // Ejecuta la query.
        $result = $query->fetchAll(PDO::FETCH_ASSOC); //con el fetch se convierte el objeto que queda guardado en $query a un array
        //var_dump($result);
        //echo($result[0]['id']);
        // Seteo los datos
        $this->nombre = $result[0]['nombre']; // El fetch all puede traer mas de un resultado, por eso el [0] para indicarle en cual se tiene que fijar
        $this->usename = $result[0]['username']; // sino se le indica va a tirar error, (que no esxiste el index) y ya sea del 0 el 1 o el que sea,
        $this->id = $result[0]['user_id']; // estos datos (nombre, usename, id) no cambian, son fijos del usuario ya que siempre va a tener mismo id mismo nombre
                           //etc.

        // if para guardar tareas
        if($result[0]["tarea_id"]){
          $index_tarea=0;
          foreach ($result as $tarea) {
            $id = $tarea['tarea_id'];
            $usuario_id = $tarea['usuario_id'];
            $usuario_tarea_id = $tarea['usuario_tarea_id'];
            $usuario = $tarea['usuario_tarea'];
            $title = $tarea['title'];
            $descripcion = $tarea['description'];
            $created_at = $tarea['created_at'];
            $coincide = null;

            if(empty($this->tareas)){ // Si todavía no tareas[] no tiene Task guardadas... Siempre va a empezar cumpliéndose este if primero, porque la primera vez no va a haber ninguna tarea guardada.
              $task = new Task($id, $usuario_id, $usuario_tarea_id, $usuario, $title, $descripcion, $created_at);
              $this->tareas[$index_tarea] = $task;
              $index_tarea++;
            }
            if(!empty($this->tareas)){ // Si tiene tareas (tareas[] tiene Task guardadas)
              foreach ($this->tareas as $unatarea) {  // Recorro array de tareas para comprobar si ya existe la tarea que voy a agregar o no, asi no se agega
                  if($unatarea->getId() == $id){//echo ("id tarea instanciada: " . $unatarea->getId() . "id tarea de result: " . $id . "<br>"); // por duplicado una tarea que ya existe. Para esto consulto/comparo el id que viene desde $result
                    $coincide = true; //Una vez que encuentra un true (una coincidencia donde $unatarea->getId() == $id) entonces hago un break, porque a esa tarea entonces no hay que agregarla, si no hago el brek, sigue analizando y si
                    break;  // la siguiente comparación da false, se me cambia el valor de $coincide a false por lo que se se ejectura el if de abajo y la tarea se va a agregar igual a pesar de haber tenido un true anteriormente.
                  }         // Entonces yo necesito que al haber un true pum, ya se corte todo con un break y no se agregue la tarea en cuestión.
                  else{
                    $coincide = false;
                  }
              }
            }//FIN IF
            if($coincide==false){ // Si coincide == flase, significa que almenos con una de las tareas ya guardadas no coincidió. entonces
              $task = new Task($id, $usuario_id, $usuario_tarea_id, $usuario, $title, $descripcion, $created_at); // por duplicado una tarea que ya existe. Para esto consulto/comparo el id que viene desde $result
              $this->tareas[$index_tarea] = $task; // con el id de las tareas que ya haya guardadas.
              $index_tarea++;
            }
          }
        }

        // if para guardar notas
        if($result[0]["user_notas_id"]){
          $index_nota=0;
          foreach ($result as $nota) {
            $id_nota = $nota['user_notas_id'];
            $usuario = $nota['usuario'];
            $asunto = $nota['asunto'];
            $cuerpo = $nota['cuerpo'];
            $created_at = $nota['created_at'];
            $usuario_id = $nota['notas_usuario_id'];
            $coincide_nota = null;
            //var_dump($result);
            if(empty($this->notas)){ // Si todavía no tareas[] no tiene Task guardadas... Siempre va a empezar cumpliéndose este if primero, porque la primera vez no va a haber ninguna tarea guardada.
              $nota = new Nota($id_nota, $usuario, $asunto, $cuerpo, $created_at, $usuario_id);
              $this->notas[$index_nota] = $nota;
              $index_nota++;
            }
            if(!empty($this->notas)){ // Si tiene tareas (tareas[] tiene Task guardadas)
              foreach ($this->notas as $unanota) {  // Recorro array de tareas para comprobar si ya existe la tarea que voy a agregar o no, asi no se agega
                  if($unanota->getId() == $id_nota){//echo ("id tarea instanciada: " . $unatarea->getId() . "id tarea de result: " . $id . "<br>"); // por duplicado una tarea que ya existe. Para esto consulto/comparo el id que viene desde $result
                    $coincide_nota = true; //Una vez que encuentra un true (una coincidencia donde $unatarea->getId() == $id) entonces hago un break, porque a esa tarea entonces no hay que agregarla, si no hago el brek, sigue analizando y si
                    break;  // la siguiente comparación da false, se me cambia el valor de $coincide a false por lo que se se ejectura el if de abajo y la tarea se va a agregar igual a pesar de haber tenido un true anteriormente.
                  }         // Entonces yo necesito que al haber un true pum, ya se corte todo con un break y no se agregue la tarea en cuestión.
                  else{
                    $coincide_nota = false;
                  }
              }
            }//FIN IF
            if($coincide_nota==false){ // Si coincide == flase, significa que almenos con una de las tareas ya guardadas no coincidió. entonces
              $nota = new Nota($id_nota, $usuario, $asunto, $cuerpo, $created_at, $usuario_id); // por duplicado una tarea que ya existe. Para esto consulto/comparo el id que viene desde $result
              $this->notas[$index_nota] = $nota; // con el id de las tareas que ya haya guardadas.
              $index_nota++;
            }
          }
        }
    }

    public function setUserById($id_user_log=1){
        $query = $this->connect()->prepare("SELECT *,  tk.id as tarea_id, tk.usuario as usuario_tarea, tk.usuario_id as tareas_usuario_id ,u.id as user_id,
        n.id as user_notas_id, n.usuario_id as notas_usuario_id, n.usuario as usuario_nota
        FROM usuarios u
        LEFT JOIN task tk
        ON tk.usuario_tarea_id = u.id
        LEFT JOIN notas n
        ON n.usuario_id = tk.usuario_tarea_id
        WHERE u.id = :id_user_log");

        $query->execute(['id_user_log' => $id_user_log]); // Ejecuta la query.
        $result = $query->fetchAll(PDO::FETCH_ASSOC); //con el fetch se convierte el objeto que queda guardado en $query a un array
        //var_dump($result);
        //echo($result[0]['id']);
        // Seteo los datos
        $this->nombre = $result[0]['nombre']; // El fetch all puede traer mas de un resultado, por eso el [0] para indicarle en cual se tiene que fijar
        $this->usename = $result[0]['username']; // sino se le indica va a tirar error, (que no esxiste el index) y ya sea del 0 el 1 o el que sea,
        $this->id = $result[0]['user_id']; // estos datos (nombre, usename, id) no cambian, son fijos del usuario ya que siempre va a tener mismo id mismo nombre
                           //etc.

        // if para guardar tareas
        if($result[0]["tarea_id"]){
          $index_tarea=0;
          foreach ($result as $tarea) {
            $id = $tarea['tarea_id'];
            $usuario_id = $tarea['usuario_id'];
            $usuario_tarea_id = $tarea['usuario_tarea_id'];
            $usuario = $tarea['usuario_tarea'];
            $title = $tarea['title'];
            $descripcion = $tarea['description'];
            $created_at = $tarea['created_at'];
            $coincide = null;

            if(empty($this->tareas)){ // Si todavía no tareas[] no tiene Task guardadas... Siempre va a empezar cumpliéndose este if primero, porque la primera vez no va a haber ninguna tarea guardada.
              $task = new Task($id, $usuario_id, $usuario_tarea_id, $usuario, $title, $descripcion, $created_at);
              $this->tareas[$index_tarea] = $task;
              $index_tarea++;
            }
            if(!empty($this->tareas)){ // Si tiene tareas (tareas[] tiene Task guardadas)
              foreach ($this->tareas as $unatarea) {  // Recorro array de tareas para comprobar si ya existe la tarea que voy a agregar o no, asi no se agega
                  if($unatarea->getId() == $id){//echo ("id tarea instanciada: " . $unatarea->getId() . "id tarea de result: " . $id . "<br>"); // por duplicado una tarea que ya existe. Para esto consulto/comparo el id que viene desde $result
                    $coincide = true; //Una vez que encuentra un true (una coincidencia donde $unatarea->getId() == $id) entonces hago un break, porque a esa tarea entonces no hay que agregarla, si no hago el brek, sigue analizando y si
                    break;  // la siguiente comparación da false, se me cambia el valor de $coincide a false por lo que se se ejectura el if de abajo y la tarea se va a agregar igual a pesar de haber tenido un true anteriormente.
                  }         // Entonces yo necesito que al haber un true pum, ya se corte todo con un break y no se agregue la tarea en cuestión.
                  else{
                    $coincide = false;
                  }
              }
            }//FIN IF
            if($coincide==false){ // Si coincide == flase, significa que almenos con una de las tareas ya guardadas no coincidió. entonces
              $task = new Task($id, $usuario_id, $usuario_tarea_id, $usuario, $title, $descripcion, $created_at); // por duplicado una tarea que ya existe. Para esto consulto/comparo el id que viene desde $result
              $this->tareas[$index_tarea] = $task; // con el id de las tareas que ya haya guardadas.
              $index_tarea++;
            }
          }
        }

        // if para guardar notas
        if($result[0]["user_notas_id"]){
          $index_nota=0;
          foreach ($result as $nota) {
            $id_nota = $nota['user_notas_id'];
            $usuario = $nota['usuario'];
            $asunto = $nota['asunto'];
            $cuerpo = $nota['cuerpo'];
            $created_at = $nota['created_at'];
            $usuario_id = $nota['notas_usuario_id'];
            $coincide_nota = null;
            //var_dump($result);
            if(empty($this->notas)){ // Si todavía no tareas[] no tiene Task guardadas... Siempre va a empezar cumpliéndose este if primero, porque la primera vez no va a haber ninguna tarea guardada.
              $nota = new Nota($id_nota, $usuario, $asunto, $cuerpo, $created_at, $usuario_id);
              $this->notas[$index_nota] = $nota;
              $index_nota++;
            }
            if(!empty($this->notas)){ // Si tiene tareas (tareas[] tiene Task guardadas)
              foreach ($this->notas as $unanota) {  // Recorro array de tareas para comprobar si ya existe la tarea que voy a agregar o no, asi no se agega
                  if($unanota->getId() == $id_nota){//echo ("id tarea instanciada: " . $unatarea->getId() . "id tarea de result: " . $id . "<br>"); // por duplicado una tarea que ya existe. Para esto consulto/comparo el id que viene desde $result
                    $coincide_nota = true; //Una vez que encuentra un true (una coincidencia donde $unatarea->getId() == $id) entonces hago un break, porque a esa tarea entonces no hay que agregarla, si no hago el brek, sigue analizando y si
                    break;  // la siguiente comparación da false, se me cambia el valor de $coincide a false por lo que se se ejectura el if de abajo y la tarea se va a agregar igual a pesar de haber tenido un true anteriormente.
                  }         // Entonces yo necesito que al haber un true pum, ya se corte todo con un break y no se agregue la tarea en cuestión.
                  else{
                    $coincide_nota = false;
                  }
              }
            }//FIN IF
            if($coincide_nota==false){ // Si coincide == flase, significa que almenos con una de las tareas ya guardadas no coincidió. entonces
              $nota = new Nota($id_nota, $usuario, $asunto, $cuerpo, $created_at, $usuario_id); // por duplicado una tarea que ya existe. Para esto consulto/comparo el id que viene desde $result
              $this->notas[$index_nota] = $nota; // con el id de las tareas que ya haya guardadas.
              $index_nota++;
            }
          }
        }
    }

    public function getId(){
        return $this->id;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getTareas(){
        return $this->tareas;
    }

    public function getNotas(){
        return $this->notas;
    }

/*
// Obtengo las tareas de un usuario a través de su id -- tareas que tiene asignadas no importa si se las asignó el mismo o se las cargó otra persona.
    public function obtenerTareas($idUsuario){
      $query = $this->connect()->prepare('SELECT * FROM task WHERE usuario_tarea_id = :idUsuario');
      $query->execute(['idUsuario' => $idUsuario]);
      $tareas = array();
      foreach ($query as $data) {
         $tarea=new Task();
         $tarea->setTaskPorUsuario($data);
         $tareas[] = $tarea;
      }
      $returnValue = $tareas;
      return $returnValue;

    }
*/
    public function obtenerNotas(){

    }

    public function obtenerComentarios(){

    }

    public function obtenerMails(){

    }



}

?>
