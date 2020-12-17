<?php

  include("db.php"); //Tengo que incluir el db.php para incluir la conexión a la db

//ELIMINAR TAREA ----------------------
  if(isset($_GET['tarea'])){       // Si hay un id en GET (URL)
    $id_tarea = $_GET['tarea'];                               // Lo guardo en variable $id
    $query_delete_task = "DELETE FROM task WHERE id = $id_tarea";   // Armo la query para que elimine las tareas que tengan ese id (asociado en la db) que está recibiendo.
//
    $query_consulta_comments = "SELECT * from comentarios WHERE task_id = $id_tarea"; // Query para consultar si la tarea tiene comentarios asociados
    $result = mysqli_query($conn, $query_consulta_comments);                    // Hago la consulta. Para ejecutar todo esto hago un mysqli_query()...
                                                                                // explicado mas abajo.
    if($result){ //si hay resultados (comentarios asociados)...
      $query_delete_comment = "DELETE from comentarios WHERE task_id = $id_tarea";
      $result = mysqli_query($conn, $query_delete_comment); // Los elimino.
    }

    $result = mysqli_query($conn, $query_delete_task);        // Para ejecutar todo esto hago un mysqli_query() y le paso la conexión ($conn) y la query ($query).
                                                              // Además estoy guardando el resultado de esto en la variable $result.
    if(!$result){                                             // Si $result queda vacio (que pasaría en caso de que haya fallado el proceso)
      die("Query failed");                                    // mato la app mostrando msj "Query failed".
    }

    $_SESSION['message'] = "Tarea eliminada exitosamente"; // Creo msj con su tipo (si ya existía uno, lo pisa, cosa que esta bien para este fin)
    $_SESSION['message_type'] = "danger";
    header("Location:index.php?pagina=1&&pagina_notas=1");                 // Si todo salió bien se redirigirá a index.php

  }

//ELIMINAR COMENTARIO ----------------------
  else if(isset($_GET['idcomment'])){
    $id_tarea = $_GET['id']; // (id task)
    $idcomment = $_GET['idcomment'];
    $id_usuario_comenta = $_GET['usuariolog'];
    $query = "DELETE FROM comentarios WHERE id = $idcomment";
    $result = mysqli_query($conn, $query);

    if(!$result){
      die("Query failed");
    }


    $_SESSION['message_comment'] = "Comentario eliminado";
    $_SESSION['message_type_comment'] = "danger";
    header("Location:detalle_tarea.php?tarea=$id_tarea&&usuariolog=$id_usuario_comenta");

  }

//ELIMINAR NOTAS ----------------------
else if(isset($_GET['nota'])){
  $id_nota = $_GET['nota']; // (id task)
  $query = "DELETE FROM notas WHERE id = $id_nota";
  $result = mysqli_query($conn, $query);

  if(!$result){
    die("Query failed");
  }


  $_SESSION['message_nota'] = "Comentario eliminado";
  $_SESSION['message_type_nota'] = "danger";
  header("Location:index.php?pagina=1&&pagina_notas=1");

}

?>
