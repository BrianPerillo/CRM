<?php

include("db.php");
  // Si llegaron los datos por POST:
  if(isset($_POST['save_task'])){
    // 1- Los guardo en variables.
    $usuario = $_POST['usuario'];// porque el name="" del nombre en el index es "usuario"
    $title = $_POST['title'];// porque el name="" del titulo en el index es "title"
    $description = $_POST['description'];// porque el name="" de la descripción es "description"
    $usuario_id = $_POST['usuario_id'];
    //echo "Title:" . $title . "<br>";
    //echo "Description:" .$description;

    // Consulto el id del usuario al que le asignan la Tarea
    $query = "SELECT id FROM usuarios WHERE nombre = '$usuario'"; // $usuario en este caso tuvo que ir entre comillas simples, sino tiraba error
    $result = mysqli_query($conn, $query);
    // Si hubo un error le digo que termine con la aplicación - die().
      if($result){
        $row = mysqli_fetch_array($result);
        $usuario_tarea_id = $row['id'];
      }
      else if(mysqli_error($conn)){
        die("Query Failed. Falló la Query para obtener el id del usuario al que le asignan la Tarea - Error: " . mysqli_error($conn));
      }


  // Guardo los datos en la db
    $query = "INSERT INTO task(usuario, title, description, usuario_id, usuario_tarea_id) VALUES ('$usuario', '$title', '$description', '$usuario_id', '$usuario_tarea_id')"; // INSERTA VALUES EN LA TABLA TASK
  // Consulto si se guardaron los valores / si todo salió bien. Si resulto no devuelve nada es porque hubo algún problema/error
    $result = mysqli_query($conn, $query);
  // Si hubo un error le digo que termine con la aplicación - die().
    if(mysqli_error($conn)){
      die("Query Failed. Falló la Query para insertar la tarea - Error: " . mysqli_error($conn));
    }

    // Almaceno un mensaje en la sesión (ver db.php, ahí se inicia la sesión al principio de todo).
    // Estos datos los uso en el index.php para mostrar el msj.
    $_SESSION['message'] = "Tarea guardada exitosamente"; // msj.
    $_SESSION['message_type'] = "success" ; // Dato para que luego use bootstrap y darle un estilo al msj.

    header("Location:index.php?pagina=1&&pagina_notas=1"); // Redirecciono nuevamente al index.php.

  }

// GUARDAR COMENTARIOS

  else if(isset($_POST['save_comment'])){

        // 1- Los guardo en variables.
        $usuario = $_POST['name'];
        $comment = $_POST['comment'];
        $id_tarea = $_POST['id_tarea'];
        $id_usuario_comenta = $_POST['id_usuario_comenta'];

        // Guardo los datos en la db
          $query = "INSERT INTO comentarios(name, comentario, task_id, id_usuario_comentario) VALUES ('$usuario', '$comment', '$id_tarea', '$id_usuario_comenta')"; // INSERTA VALUES EN LA TABLA TASK
        // Consulto si se guardaron los valores / si todo salió bien. Si resulto no devuelve nada es porque hubo algún problema/error
          $result = mysqli_query($conn, $query);
        // Si hubo un error le digo que termine con la aplicación - die().
          if(mysqli_error($conn)){
            die("Query Failed. Falló la Query para insertar la tarea - Error: " . mysqli_error($conn));
          }

          $_SESSION['message_comentario'] = "Comentario guardado exitosamente"; // msj.
          $_SESSION['message_comentario_type'] = "success" ; // Dato para que luego use bootstrap y darle un estilo al msj.

          header("Location:detalle_tarea.php?tarea=$id_tarea&&usuariolog=$id_usuario_comenta"); // Redirecciono nuevamente al index.php.

      }

// GUARDAR NOTAS

  // Si llegaron los datos por POST:
  else if(isset($_POST['save_nota'])){
    // 1- Los guardo en variables.
    $usuario = $_POST['usuario'];// porque el name="" del nombre en el index es "usuario"
    $asunto = $_POST['asunto'];// porque el name="" del titulo en el index es "title"
    $cuerpo = $_POST['cuerpo'];// porque el name="" de la descripción es "cuerpo"
    $usuario_id = $_POST['usuario_id'];
    //echo "Title:" . $title . "<br>";
    //echo "Description:" .$description;

        // Consulto el id del usuario al que le asignan la Tarea
        $query = "SELECT id FROM usuarios WHERE username = '$usuario'"; // $usuario en este caso tuvo que ir entre comillas simples, sino tiraba error
        $result = mysqli_query($conn, $query);
        // Si hubo un error le digo que termine con la aplicación - die().
          if($result){
            $row = mysqli_fetch_array($result);
            $usuario_tarea_id = $row['id'];//id del usuario al que le asignaron la tarea
            //echo $usuario_tarea_id; die();
          }
          else if(mysqli_error($conn)){
            die("Query Failed. Falló la Query para obtener el id del usuario al que le asignan la Tarea - Error: " . mysqli_error($conn));
          }

  // Guardo los datos en la db
    $query = "INSERT INTO notas(usuario, asunto, cuerpo, usuario_id) VALUES ('$usuario', '$asunto', '$cuerpo', '$usuario_tarea_id')"; // INSERTA VALUES EN LA TABLA NOTAS
  // Consulto si se guardaron los valores / si todo salió bien. Si resulto no devuelve nada es porque hubo algún problema/error
    $result = (mysqli_query($conn, $query));
  // Si hubo un error le digo que termine con la aplicación - die().
    if(mysqli_error($conn)){
      die("Query Failed. Falló la Query para insertar la nota en la db - Error: " . mysqli_error($conn));
    }

    // Almaceno un mensaje en la sesión (ver db.php, ahí se inicia la sesión al principio de todo).
    // Estos datos los uso en el index.php para mostrar el msj.
    $_SESSION['message'] = "Nota guardada exitosamente"; // msj.
    $_SESSION['message_type'] = "success" ; // Dato para que luego use bootstrap y darle un estilo al msj.

    header("Location:index.php?pagina=1&&pagina_notas=1"); // Redirecciono nuevamente al index.php.

}

else {
  $random = "No llegaron los datos";
  echo $random;
}


?>
