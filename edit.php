<?php

  include("db.php"); //Tengo que incluir el db.php para incluir la conexión a la db

// Edit Tarea
    //include("includes/header.php");
  // Acá lo que voy a hacer es realizar la consulta de los datos vinculados al id recibido por GET para mostrarlos en el formulario que está más abajo.
  if(isset($_GET['id'])){ // Para consultar recibo por GET
    $id_tarea = $_GET['id'];                             // EL ID RECIBIDO X GET ES EL ID DE LA TAREA A EDITAR, Lo guardo en variable $id
    $query = "SELECT * FROM task WHERE id = $id_tarea";  // Armo una query para tomar las tareas que tengan ese id (asociado en la db) que está recibiendo.
    $result = mysqli_query($conn, $query);               // Para ejecutar todo esto hago un mysqli_query() y le paso la conexión ($conn) y la query ($query).
                                                         // Además estoy guardando el resultado de esto en la variable $result.
    if(mysqli_num_rows($result) >= 1){                   // Si hay almenos un resultado ... mysqli_num_rows lo uso para consultar cuantas filas tiene el resultado. (si hay almenos una fila entonces...)
      $row = mysqli_fetch_array($result);                // mysqli_fetch_array() para tener los datos dentro de un array que voy a llamar $row.
      $usuario = $row['usuario'];                           // De row saco el name y lo guardo en variable $name.
      $title = $row['title'];                            // Lo mismo con el title y la description.
      $description = $row['description'];
    }

    // En esta parte voy a crear un formulario para que el usuario pueda editar los datos

    include("includes/edit_task.php");

  }

  // Edit Nota

  // Acá lo que voy a hacer es realizar la consulta de los datos vinculados al id recibido por GET para mostrarlos en el formulario que está más abajo.
  else if(isset($_GET['nota'])){ // Para consultar recibo por GET
    $id_nota = $_GET['nota'];                             // EL ID RECIBIDO X GET ES EL ID DE LA TAREA A EDITAR, Lo guardo en variable $id
    $query = "SELECT * FROM notas WHERE id = $id_nota";  // Armo una query para tomar las tareas que tengan ese id (asociado en la db) que está recibiendo.
    $result = mysqli_query($conn, $query);               // Para ejecutar todo esto hago un mysqli_query() y le paso la conexión ($conn) y la query ($query).
                                                         // Además estoy guardando el resultado de esto en la variable $result.
    if(mysqli_num_rows($result) >= 1){                   // Si hay almenos un resultado ... mysqli_num_rows lo uso para consultar cuantas filas tiene el resultado. (si hay almenos una fila entonces...)
      $row = mysqli_fetch_array($result);                // mysqli_fetch_array() para tener los datos dentro de un array que voy a llamar $row.
      $usuario = $row['usuario'];                           // De row saco el name y lo guardo en variable $name.
      $asunto = $row['asunto'];                            // Lo mismo con el title y la description.
      $cuerpo = $row['cuerpo'];
    }

    // En esta parte voy a crear un formulario para que el usuario pueda editar los datos

    include("includes/edit_nota.php");

  }

  // Acá modifico los datos que recibo por POST

  else if (isset($_POST['update_tarea'])) {  // Para modificar recibo por POST
    //$id_tarea = $_GET['id'];
    $id_tarea =  $_POST['id_tarea'];
    $usuario = $_POST['usuario'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $query = "UPDATE task set title = '$title', description = '$description', usuario = '$usuario' WHERE id = $id_tarea";
    $result = mysqli_query($conn, $query); // Ejecuto la consulta por medio de mysqli_query().
    header("Location:index.php?pagina=1&&pagina_notas=1"); // Redirecciono nuevamente al index.php.
  }

  else if (isset($_POST['update_nota'])) {  // Para modificar recibo por POST
    //$id_nota = $_GET['nota'];
    $id_nota =  $_POST['id_nota'];
    $usuario = $_POST['usuario'];
    $asunto = $_POST['asunto'];
    $cuerpo = $_POST['cuerpo'];
    $query = "UPDATE notas set asunto = '$asunto', cuerpo = '$cuerpo', usuario = '$usuario' WHERE id = $id_nota";
    $result = mysqli_query($conn, $query); // Ejecuto la consulta por medio de mysqli_query().
    header("Location:index.php?pagina=1&&pagina_notas=1"); // Redirecciono nuevamente al index.php.
  }

?>



<?php //include("includes/footer.php"); ?>
