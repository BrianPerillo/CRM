<?php

  include("db.php");
  include_once 'includes/user.php';
  include_once 'includes/user_session.php';
//Crear json que si esta vacio guarde los datos recibidos por post y si no está vació tome los datos y los guarde en variables,
//esto es por que de home a este php los datos llegan por post pero si se guarda un comentario, desde el save.php a este no puedo,
//traerle de nuevo esos datos necesesarios por post, entonces los toma del json donde previamente los había guardado.
//todo esto para evitar pasar estos datos (ids) "sensibles" por GET.

  // Acá lo que voy a hacer es realizar la consulta de los datos vinculados al id recibido por GET para mostrar los detalles de la tarea que corresponde.
  // Consigo los datos de la tarea y los guardo en variables poruqe necesito estos datos para guardarlos en la tabla comentarios.
   if($_GET['tarea']){ // Para consultar tomo el id de la tarea cargado en el GET.
    $id_tarea = $_GET['tarea'];
    $id_usuario_comenta = $_GET['usuariolog'];  // Lo guardo en variable $id. (EL ID ES EL ID DE LA TAREA)
    $user = new User();
    $user->setUserById($id_usuario_comenta);
    $query = "SELECT * FROM task WHERE id = $id_tarea";  // Armo una query para tomar las tareas que tengan ese id (asociado en la db) que está recibiendo.
    $result = mysqli_query($conn, $query);         // Para ejecutar todo esto hago un mysqli_query() y le paso la conexión ($conn) y la query ($query).
                                                   // Además estoy guardando el resultado de esto en la variable $result.
    if(mysqli_num_rows($result) >= 1){             // Si hay almenos un resultado ... mysqli_num_rows lo uso para consultar cuantas filas tiene el resultado. (si hay almenos una fila entonces...)
      $row = mysqli_fetch_array($result);          // mysqli_fetch_array() para tener los datos dentro de un array que voy a llamar $row.
      $usuario_tarea = $row['usuario'];                        // De row saco el name y lo guardo en variable $name.
      $title = $row['title'];                      // Lo mismo con el title y la description.
      $description = $row['description'];
      $fecha_creacion = $row['created_at'];
      }
    }



 ?>

 <?php
 // TRAIGO LOS COMENTARIOS
 $query_select_task="SELECT * FROM comentarios WHERE id > 0 AND task_id = " . "$id_tarea"; //($id CONTIENE EL ID DE LA TAREA NO DEL COMMENT)
 $query_orden_fecha=" ORDER BY created_at DESC";
 $query_comentarios = "$query_select_task" . "$query_orden_fecha";
 $consulta_resultados = mysqli_query($conn, $query_comentarios);



 ?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Detalle Tarea</title>
  </head>
  <body>
    <?php include("includes/header.php"); ?>
      <h1>Detalle Tarea</h1>

      <div class="col-md-8">
        <!-- MSJ DE SESSION - Zona en la que quiero mostrar el msj de success que se guardó en la SESSION que se inicia en db.php (session_start()).
        El msj se guarda en el save_task.php y acá solicito -->
        <?php
          if(isset($_SESSION['message_comment'])){?>
            <div class="alert alert-<?=$_SESSION['message_type_comment']?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['message_comment'] ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>
          <?php
            //session_unset();         // Elimino datos de session para que si recargo la página no siga apareciendo el mensaje de succes.
                                       // Al hacer esto se dejaría de cumplir la condición del if que está arribo, entonces no se genera ese cartel al recargar.
            $_SESSION['message_comment']=null; // Cambio en lugar de eliminar la session con session_unset(), igualo el message a nullo, y el efecto es el mismo
                                       // ya que de igual manera se deja de cumplir la condición del if isset...
            }
          ?>
        <table class="table table-bordered">
           <thead>
              <tr>
                <th>Nombre</th>
                <th>Tarea</th>
                <th>Descripción</th>
                <th>Fecha de Creación</th>
              </tr>

              <tbody>
                      <tr>
                        <td style="width:18%"><?php echo $usuario_tarea ?></td>
                        <td style="width:23%"><?php echo $title ?></a></td>
                        <td style="width:26%"><?php echo $description ?></td>
                        <td style="width:20%"><?php echo $fecha_creacion ?></td>
                      </tr>

              </tbody>
           </thead>
        </table>

      </div>

      <div class="">
        <?php

          while($datos_comentario = mysqli_fetch_array($consulta_resultados)){ // La condición a su vez la guardo dentro de 1 varialbe ($row)
            ?>
              <tr>
                <td style="width:18%"><?php echo $datos_comentario['name'] ?></td>
                <td style="width:23%"><?php echo $datos_comentario['comentario']?></a></td>
                <td style="width:20%"><?php echo $datos_comentario['created_at'] ?></td>
                <td style="width:13%">
                  <a class="btn btn-danger" style="border:0px;" href="delete.php?id=<?php echo $id_tarea ?>&&idcomment=<?php echo $datos_comentario['id']?>&&usuariolog=<?php echo $id_usuario_comenta ?>"><!--ACÁ SI EL ID ES EL DEL COMMENT-->
                    <i class="far fa-trash-alt"></i>
                  </a><!-- Tiene que saber cual es la tarea que tiene que editar, por eso le paso el id -->
                </td>
              </tr>
              <br>
            <?php } ?>
      </div>

      <div class="col-md-4 card-body">

        <form class="form-group" action="save.php" method="post">
          <div class="col-md-12">
            <textarea class="form-control" name="comment" rows="6" cols="12"></textarea>
          </div>
          <p></p>
          <!-- Envio también mediante un input hidden el -->
            <input hidden class="form-control btn btn-primary" name="name" type="text" value=<?php echo $user->getNombre() ?>>
            <input hidden class="form-control btn btn-primary" name="id_tarea" type="text" value=<?php echo $id_tarea ?>>
            <input hidden class="form-control btn btn-primary" name="id_usuario_comenta" type="text" value=<?php echo $id_usuario_comenta ?>>

          <!-- -->
          <div class="col-md-5">
            <input class="form-control btn btn-primary" name="save_comment" type="submit" value="Agregar Comentario">
          </div>


        </form>
      </div>

    <?php include("includes/footer.php"); ?>
  </body>
</html>
