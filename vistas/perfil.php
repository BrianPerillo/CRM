
<?php  include("../db.php")?>
<?php  include("../includes/header.php")?>
<?php  include_once '../includes/user.php';?>
<?php  include_once '../includes/user_session.php';?>
<?php  include_once '../includes/tables.php';?>


<?php

  $usuario_id = $_GET["usuariolog"];

  // Acá hay que instanciar al usuario para poder acceder a sus datos que se encuentran en las distintas tablas ejemplo sus datos que estan en tabla
  // usuarios o sus tareas que estan en otra tabla que es tareas, si yo instancio al usuario le puedo hacer desp un ->obtenerTareas(); por ej.

  $user = new User();
  $user->setUserById($usuario_id);
  $nombre = $user->getNombre();

  echo "Nombre: " . $nombre;
?>

<?php  include("../includes/funciones.php")?>

<br>

<?php  function cargar_datos_tabla($consulta_resultados, $paginas, $usuario_id, $no_hay_datos, $user){ ?>

<?php // include("../includes/menu_hamburguesa.php");
//var_dump($user->getTareas());?>


  <div class="p-4" id="wrapper"> <!-- agrego estilo wrapper(propio) para que quede centrado y p4(de bootstrap) que es un padding de 4px-->

  <h2 style="text-align:center;margin-bottom:20px">Mis Tareas:</h2>

    <div class="container col-md-12">

      <table class="table table-hover table-dark">
         <thead>
            <tr>
              <th>Tarea</th>
              <th>Descripción</th>
              <th>Fecha de Creación</th>
              <th>Acciones</th>
            </tr>

            <tbody>
              <?php

              //$query_x_defecto = 'SELECT * FROM task ORDER BY created_at DESC LIMIT '.$resultado_inicial.',2';
              //$consulta_resultados_x_pagina = mysqli_query($conn, $query_x_defecto);
              // el 1er numero del limit indica a partir de cual va a traer los datos
              // y el segundo indica cuantos va a traer, en este caso 3

              //

              $i = 0;
                foreach ($user->getTareas() as $tarea) {
?>
                    <tr>
                      <td id="td_tarea" style="width:23%"><a id="tarea" href="detalle_tarea.php?id=<?php  ?>"><?php echo $tarea->getTitle() ?></a></td>
                      <td style="width:26%"><?php echo $tarea->getDescripcion() ?></td>
                      <td style="width:19%"><?php echo $tarea->getFechaCreacion() ?></td>
                      <td style="width:17%;">
                        <a class="btn btn-primary" style="border:0px;" href="edit.php?id=<?php   ?>"><!-- agrego el id a la url (después lo recupero desde el array de GET) -->
                          <i class="fas fa-marker"></i> <!-- Uso clase de font awesome para crear botones (font awesome esta cargado por cdn en header.php igual que bootstrap) -->
                        </a><!-- Tiene que sber cual es la tarea que tiene que editar, por eso le paso el id -->
                        <a id="<?php echo $id ?>" class="btn btn-danger" style="border:0px;" href="" onclick="eliminar(<?php ?>,<?php ?>)">
                          <i class="far fa-trash-alt"></i>
                        </a><!-- Tiene que saber cual es la tarea que tiene que editar, por eso le paso el id -->
                        <a id="" class="btn btn-warning" style="border:0px;color:white" href="">
                          <i class="fa fa-comment-alt"></i>
                        </a>
                      </td>
                    </tr>

                  <?php $i++;}?> <!-- FIN BUCLE -->
            </tbody>
         </thead>
      </table>
      <!-- En caso de que no haya tareas guardadas: -->
      <?php if($no_hay_datos!=null){?>
        <div style="text-align:center;">
          <p><?php echo $no_hay_datos; ?></p>
        </div>
      <?php } ?>
      <!-- PAGINACIÓN TAREAS--><!-- PAGINACIÓN TAREAS--><!-- PAGINACIÓN TAREAS--><!-- PAGINACIÓN TAREAS--><!-- PAGINACIÓN TAREAS-->
      <?php if($no_hay_datos==null){ ?>
      <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-end">
          <li class="page-item <?php if($_GET["pagina"]==1){?>disabled <?php } ?>"><a class="page-link" href="perfil.php?pagina=<?=$_GET["pagina"]-1?>&&pagina_notas=<?php echo $_GET["pagina_notas"]?>">Anterior</a></li><!-- ya que el previous lleva a pagina  anterior resta por get a pagina - 1 -->
          <?php for ($i=0; $i < $paginas; $i++) { ?> <!-- bucle para generar los li necesarios según los resultados que tengamos -->

          <!-- Creo el li que se va a aparecer o no y se va a repetir o no dependiendo si hay resultados y la cantidad de resultados, le agrego codigo
               para que se resalte la pagina seleccionada mediante clase active Y AGREGO/PASO NUMERO DE PÁGINA POR GET -->
          <li class="page-item pagina <?php if($_GET["pagina"]==$i+1){?>active <?php } ?>"><a class="page-link" href="perfil.php?pagina=<?=$i+1 ?>&&pagina_notas=<?php echo $_GET["pagina_notas"]?>"><?= $i+1 ?></a></li>

          <?php } ?> <!-- Fin bucle -->

          <li class="page-item <?php if($_GET["pagina"]==$paginas){?>disabled <?php } ?>"><a class="page-link" href="perfil.php?pagina=<?=$_GET["pagina"]+1?>&&pagina_notas=<?php echo $_GET["pagina_notas"]?>">Siguiente</a></li><!-- ya que el next lleva a siguiente pagina suma por get a pagina + 1 -->
        </ul>
      </nav>

      <!-- FIN PAGINACIÓN TAREAS--><!-- FIN PAGINACIÓN TAREAS--><!-- FIN PAGINACIÓN TAREAS--><!-- FIN PAGINACIÓN TAREAS--><!-- FIN PAGINACIÓN TAREAS-->

  <?php } ?> <!-- FIN CARGARGAR TABLA -->

  <?php } ?> <!-- FIN CARGARGAR TABLA -->

  </div><!-- FIN CONTAINER COL MD 12 -->

<br>

<!-- FIN SECCIÓN TAREAS - FIN SECCIÓN TAREAS - FIN SECCIÓN TAREAS - FIN SECCIÓN TAREAS - FIN SECCIÓN TAREAS -->
<!-- FIN SECCIÓN TAREAS - FIN SECCIÓN TAREAS - FIN SECCIÓN TAREAS - FIN SECCIÓN TAREAS - FIN SECCIÓN TAREAS -->

<!-- SECCIÓN NOTAS - SECCIÓN NOTAS - SECCIÓN NOTAS - SECCIÓN NOTAS - SECCIÓN NOTAS - SECCIÓN NOTAS - SECCIÓN NOTAS - --->
<!-- SECCIÓN NOTAS - SECCIÓN NOTAS - SECCIÓN NOTAS - SECCIÓN NOTAS - SECCIÓN NOTAS - SECCIÓN NOTAS - SECCIÓN NOTAS - --->

  <?php  function cargar_datos_cards_notas($consulta_resultados_notas, $paginas_notas, $usuario_id, $no_hay_datos_notas, $user){?>

  <h2 style="text-align:center;margin-bottom:20px">Mis Notas:</h2>

  <section id="notas" style="margin-top:50px;">

    <div class="row">

      <div class="col-md-12 p-4">
          <div class="card-deck">

            <?php

            $idNota = 0;
              foreach($user->getNotas() as $nota){ // La condición a su vez la guardo dentro de 1 varialbe ($row)
            ?>

            <div class="card text-white bg-dark">
              <div class="card-body">
                <!--<img class="card-img-top" src="..." alt="Card image cap">-->
                <h5 class="card-title"><?php echo $nota->getAsunto() ?></h5>
                <p class="card-text"><?php echo $nota->getCuerpo() ?></p>
                <footer class="blockquote-footer">
                    Autor: <cite title="Source Title"><?php echo $nota->getUsuario() ?></cite>
                  <div class="" style="float:right">
                  <a class="btn btn-primary" style="border:0px;" href="edit_notas.php?id=<?php ?>"><!-- agrego el id a la url (después lo recupero desde el array de GET) -->
                    <i class="fas fa-marker"></i> <!-- Uso clase de font awesome para crear botones (font awesome esta cargado por cdn en header.php igual que bootstrap) -->
                  </a><!-- Tiene que sber cual es la tarea que tiene que editar, por eso le paso el id -->
                  <a id="<?php echo $idNota ?>" class="btn btn-danger" style="border:0px;" href="" onclick="eliminar(<?php ?>)">
                    <i class="far fa-trash-alt"></i>
                  </a><!-- Tiene que saber cual es la tarea que tiene que editar, por eso le paso el id -->
                </div>
                </footer>
              </div>
            </div>
                  <?php $idNota++;} ?>
          </div>
          <!-- PAGINACIÓN TAREAS--><!-- PAGINACIÓN TAREAS--><!-- PAGINACIÓN TAREAS--><!-- PAGINACIÓN TAREAS--><!-- PAGINACIÓN TAREAS-->

  </section>
  <!-- En caso de que no haya notas guardadas: -->
  <?php if($no_hay_datos_notas!=null){?>
    <div style="text-align:center;">
      <p><?php echo $no_hay_datos_notas; ?></p>
    </div>
  <?php } ?>
  <!-- PAGINACIÓN TAREAS--><!-- PAGINACIÓN TAREAS--><!-- PAGINACIÓN TAREAS--><!-- PAGINACIÓN TAREAS--><!-- PAGINACIÓN TAREAS-->
  <?php if($no_hay_datos_notas==null){ ?>
  <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-end">
      <li class="page-item <?php if($_GET["pagina_notas"]==1){?>disabled <?php } ?>"><a class="page-link" href="index.php?pagina=<?=$_GET["pagina"]?>&&pagina_notas=<?php echo $_GET["pagina_notas"]-1?>">Anterior</a></li><!-- ya que el previous lleva a pagina  anterior resta por get a pagina - 1 -->
      <?php for ($i=0; $i < $paginas_notas; $i++) { ?> <!-- bucle para generar los li necesarios según los resultados que tengamos -->

      <!-- Creo el li que se va a aparecer o no y se va a repetir o no dependiendo si hay resultados y la cantidad de resultados, le agrego codigo
           para que se resalte la pagina seleccionada mediante clase active Y AGREGO/PASO NUMERO DE PÁGINA POR GET -->
      <li class="page-item pagina <?php if($_GET["pagina_notas"]==$i+1){?>active <?php } ?>"><a class="page-link" href="index.php?pagina=<?=$_GET["pagina"]?>&&pagina_notas=<?=$i+1 ?>"><?= $i+1 ?></a></li>

      <?php } ?> <!-- Fin bucle -->

      <li class="page-item <?php if($_GET["pagina_notas"]==$paginas_notas){?>disabled <?php } ?>"><a class="page-link" href="index.php?pagina=<?=$_GET["pagina"]?>&&pagina_notas=<?php echo $_GET["pagina_notas"]+1?>">Siguiente</a></li><!-- ya que el next lleva a siguiente pagina suma por get a pagina + 1 -->
    </ul>
  </nav>
  <?php } ?> <!-- FIN IF NO HAY DATOS NOTAS == NULL -->
  <!-- FIN PAGINACIÓN TAREAS--><!-- FIN PAGINACIÓN TAREAS--><!-- FIN PAGINACIÓN TAREAS--><!-- FIN PAGINACIÓN TAREAS--><!-- FIN PAGINACIÓN TAREAS-->
<?php } ?>

</div>


<?php
/*
  $array = objectToArray($tareas);

  var_dump($tareas);

  function objectToArray ( $object ) {

    if(!is_object($object) && !is_array($object)) {

      return $object;

    }

    return array_map( 'objectToArray', (array) $object );

  }
*/
?>
