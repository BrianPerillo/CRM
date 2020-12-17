<?php
// Si no se guardaron datos en array $_GET (es decir que no se clickeo ninguna página (1-2-3...) - ver entre linea 123 y 136)
// entonces redirijo con header para agregar a la url ?pagina=1 (o sea agrego por GET pagina 1) y esto me sirve para que, por defecto
// aparezca resaltada la pag 1, en la parte de paginación.

  if(!$_GET){
    header('Location:index.php?pagina=1&&pagina_notas=1');
  }

?>
<?php $usuario = $user->getNombre(); $usuario_id = $user->getId(); ?>
<?php $usuarios = $tables->getUsuarios();?>

<?php  include("db.php")?>
<?php  include("includes/header.php")?>
<?php  include("includes/funciones_home.php")?>

      <?php  function cargar_datos_tabla($consulta_resultados, $paginas, $usuario_id, $no_hay_datos){?>

      <?php  include("includes/menu_hamburguesa.php");?>


        <div class="p-4" id="wrapper"> <!-- agrego estilo wrapper(propio) para que quede centrado y p4(de bootstrap) que es un padding de 4px-->

          <!-- MSJ DE SESSION - Zona en la que quiero mostrar el msj de success que se guardó en la SESSION que se inicia en db.php (session_start()).
          El msj se guarda en el save_task.php y acá solicito -->
          <?php
            if(isset($_SESSION['message'])){?>
              <div class="alert alert-<?=$_SESSION['message_type']?> alert-dismissible fade show" role="alert">
              <?= $_SESSION['message'] ?>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              </div>
            <?php
              //session_unset();         // Elimino datos de session para que si recargo la página no siga apareciendo el mensaje de succes.
                                         // Al hacer esto se dejaría de cumplir la condición del if que está arribo, entonces no se genera ese cartel al recargar.
              $_SESSION['message']=null; // Cambio en lugar de eliminar la session con session_unset(), igualo el message a nullo, y el efecto es el mismo
                                         // ya que de igual manera se deja de cumplir la condición del if isset...
              }
            ?>


          <!-- FIN MSJ DE SESSION -->

        <h2 style="text-align:center;margin-bottom:20px">Tareas:</h2>

          <div class="container col-md-12">

            <table class="table table-hover table-dark">
               <thead>
                  <tr>
                    <th>Nombre</th>
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

                    $id = 0;
                      while($datos = mysqli_fetch_array($consulta_resultados)){ // La condición a su vez la guardo dentro de 1 varialbe ($row)
?>

                          <tr>
                            <td style="width:15%"><?php echo $datos['usuario'] ?></td>
                            <td id="td_tarea" style="width:23%"><a id="tarea" href="detalle_tarea.php?tarea=<?php echo $datos['id'] . "&&usuariolog=$usuario_id" ?>"><?php echo $datos['title'] ?></a></td>
                            <td style="width:26%"><?php echo $datos['description'] ?></td>
                            <td style="width:19%"><?php echo $datos['created_at'] ?></td>
                            <td style="width:17%;">
                              <a class="btn btn-primary" style="border:0px;" href="edit.php?id=<?php echo $datos['id'] ?>"><!-- agrego el id a la url (después lo recupero desde el array de GET) -->
                                <i class="fas fa-marker"></i> <!-- Uso clase de font awesome para crear botones (font awesome esta cargado por cdn en header.php igual que bootstrap) -->
                              </a><!-- Tiene que sber cual es la tarea que tiene que editar, por eso le paso el id -->
                              <a id="<?php echo $id ?>" class="btn btn-danger" style="border:0px;" href="" onclick="eliminar(<?php echo $datos['id']?>,<?php echo $id?>)">
                                <i class="far fa-trash-alt"></i>
                              </a><!-- Tiene que saber cual es la tarea que tiene que editar, por eso le paso el id -->
                              <a id="" class="btn btn-warning" style="border:0px;color:white" href="detalle_tarea.php?tarea=<?php echo $datos['id'] . "&&usuariolog=$usuario_id" ?>">
                                <i class="fa fa-comment-alt"></i>
                              </a>
                            </td>
                          </tr>

                        <?php $id++;}?> <!-- FIN BUCLE -->
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
                <li class="page-item <?php if($_GET["pagina"]==1){?>disabled <?php } ?>"><a class="page-link" href="index.php?pagina=<?=$_GET["pagina"]-1?>&&pagina_notas=<?php echo $_GET["pagina_notas"]?>">Anterior</a></li><!-- ya que el previous lleva a pagina  anterior resta por get a pagina - 1 -->
                <?php for ($i=0; $i < $paginas; $i++) { ?> <!-- bucle para generar los li necesarios según los resultados que tengamos -->

                <!-- Creo el li que se va a aparecer o no y se va a repetir o no dependiendo si hay resultados y la cantidad de resultados, le agrego codigo
                     para que se resalte la pagina seleccionada mediante clase active Y AGREGO/PASO NUMERO DE PÁGINA POR GET -->
                <li class="page-item pagina <?php if($_GET["pagina"]==$i+1){?>active <?php } ?>"><a class="page-link" href="index.php?pagina=<?=$i+1 ?>&&pagina_notas=<?php echo $_GET["pagina_notas"]?>"><?= $i+1 ?></a></li>

                <?php } ?> <!-- Fin bucle -->

                <li class="page-item <?php if($_GET["pagina"]==$paginas){?>disabled <?php } ?>"><a class="page-link" href="index.php?pagina=<?=$_GET["pagina"]+1?>&&pagina_notas=<?php echo $_GET["pagina_notas"]?>">Siguiente</a></li><!-- ya que el next lleva a siguiente pagina suma por get a pagina + 1 -->
              </ul>
            </nav>

            <!-- FIN PAGINACIÓN TAREAS--><!-- FIN PAGINACIÓN TAREAS--><!-- FIN PAGINACIÓN TAREAS--><!-- FIN PAGINACIÓN TAREAS--><!-- FIN PAGINACIÓN TAREAS-->

        <?php } ?> <!-- FIN CARGARGAR TABLA -->

        <?php } ?> <!-- FIN CARGARGAR TABLA -->

        </div><!-- FIN CONTAINER COL MD 12 -->



        <?php  function cargar_datos_cards_notas($consulta_resultados_notas, $paginasNotas){
          $paginasNotas=$paginasNotas?>

        <section id="notas" style="margin-top:50px;">

          <h2 style="text-align:center">Notas:</h2>

          <div class="row">

            <div class="col-md-12 p-4">
                <div class="card-deck">

                  <?php

                  $idNota = 0;
                    while($datosNotas = mysqli_fetch_array($consulta_resultados_notas)){ // La condición a su vez la guardo dentro de 1 varialbe ($row)
                  ?>

                  <div class="card text-white bg-dark">
                    <div class="card-body">
                      <!--<img class="card-img-top" src="..." alt="Card image cap">-->
                      <h5 class="card-title"><?php echo $datosNotas['asunto'] ?></h5>
                      <p class="card-text"><?php echo $datosNotas['cuerpo'] ?></p>
                      <footer class="blockquote-footer">
                          Autor: <cite title="Source Title"><?php echo $datosNotas['usuario'] ?></cite>
                        <div class="" style="float:right">
                        <a class="btn btn-primary" style="border:0px;" href="edit.php?nota=<?php echo $datosNotas['id'] ?>"><!-- agrego el id a la url (después lo recupero desde el array de GET) -->
                          <i class="fas fa-marker"></i> <!-- Uso clase de font awesome para crear botones (font awesome esta cargado por cdn en header.php igual que bootstrap) -->
                        </a><!-- Tiene que sber cual es la tarea que tiene que editar, por eso le paso el id -->
                        <a id="<?php echo "nota" . $idNota ?>" class="btn btn-danger" style="border:0px;" href="" onclick="eliminar_nota(<?php echo $datosNotas['id']?>,<?php echo $idNota ?>)">
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

        <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-end">
            <li class="page-item <?php if($_GET["pagina_notas"]==1){?>disabled <?php } ?>"><a class="page-link" href="index.php?pagina=<?=$_GET["pagina"]?>&&pagina_notas=<?php echo $_GET["pagina_notas"]-1?>">Anterior</a></li><!-- ya que el previous lleva a pagina  anterior resta por get a pagina - 1 -->
            <?php for ($i=0; $i < $paginasNotas; $i++) { ?> <!-- bucle para generar los li necesarios según los resultados que tengamos -->

            <!-- Creo el li que se va a aparecer o no y se va a repetir o no dependiendo si hay resultados y la cantidad de resultados, le agrego codigo
                 para que se resalte la pagina seleccionada mediante clase active Y AGREGO/PASO NUMERO DE PÁGINA POR GET -->
            <li class="page-item pagina <?php if($_GET["pagina_notas"]==$i+1){?>active <?php } ?>"><a class="page-link" href="index.php?pagina=<?=$_GET["pagina"]?>&&pagina_notas=<?=$i+1 ?>"><?= $i+1 ?></a></li>

            <?php } ?> <!-- Fin bucle -->

            <li class="page-item <?php if($_GET["pagina_notas"]==$paginasNotas){?>disabled <?php } ?>"><a class="page-link" href="index.php?pagina=<?=$_GET["pagina"]?>&&pagina_notas=<?php echo $_GET["pagina_notas"]+1?>">Siguiente</a></li><!-- ya que el next lleva a siguiente pagina suma por get a pagina + 1 -->
          </ul>
        </nav>

        <!-- FIN PAGINACIÓN TAREAS--><!-- FIN PAGINACIÓN TAREAS--><!-- FIN PAGINACIÓN TAREAS--><!-- FIN PAGINACIÓN TAREAS--><!-- FIN PAGINACIÓN TAREAS-->
      <?php } ?>
      </div>

      <!-- FORMULARIO SAVES -->

      <section>

        <div class="row" style="margin-top:50px;background-color: #343a40; color:white;margin-right:0px">

          <div class="row" id="wrapper_agregar" style="margin:0 auto">

            <div id="agregar_tarea" class="col-md-5 p-5">

              <h2 style="margin-bottom:40px; text-align:center">Agregar Tarea</h2>

              <div><!-- antes este div era una tarjeta de bootstrap ya que tenia esta clase => class="card card-body" que le da un borde -->

                <form action="save.php" method="post"><!-- El action es a donde te redirige pero también a dÓnde manda los datos del array POST O GET -->

                  <div class="form-group"> <!-- agrega margen bottom para que no se peguen los inputs -->

                    <select class="form-control" name="usuario" id="usuario"> <!-- form-control embellece el input -->
                        <option selected value="" disabled>Seleccionar Nombre</option>
                        <option value="Peralta">Peralta</option>
                        <option value="Ozia5">Ozia5</option>
                        <option value="Ceci">Ceci</option>
                        <option value="Bolas">Bolas</option>
                        <option value="Palona">Palona</option>
                        <option value="Lashata">Lashata</option>
                        <option value="Heladera">Heladera</option>
                        <option value="Gordilla">Gordilla</option>
                    </select>

                  </div>

                  <div class="form-group"> <!-- agrega margen bottom para que no se peguen los inputs -->

                    <input class="form-control" type="text" name="title" value="" placeholder="Tarea"> <!-- form-control embellece el input -->

                  </div>

                  <div class="form-group">

                    <textarea class="form-control" name="description" rows="3" placeholder="Descripción"></textarea> <!-- form-control embellece el input -->

                  </div>
                  <input type="text" name="usuario_id" value="<?php echo $usuario_id ?>" hidden ><!-- Evío el id de usuario QUE agregó la taera-->
                  <input type="submit" name="save_task" class="btn btn-success btn-block" value="Guardar Tarea"> <!-- btn-block sirve para que ocupe todo el ancho disponible -->

                </form>

              </div>

            </div>



            <div id="agregar_nota" class="col-md-5 p-5" style="text-align:center">

            <h2  style="margin-bottom:40px">Agregar Nota</h2>

            <form action="save.php" method="post"><!-- El action es a donde te redirige pero también a dÓnde manda los datos del array POST O GET -->

              <div class="form-group"> <!-- agrega margen bottom para que no se peguen los inputs -->

                <select class="form-control" name="usuario" id="usuario"> <!-- form-control embellece el input -->
                    <option selected value="" disabled>Seleccionar Nombre</option>
                    <option value="Peralta">Peralta</option>
                    <option value="Ozia5">Ozia5</option>
                    <option value="Ceci">Ceci</option>
                    <option value="Bolas">Bolas</option>
                    <option value="Palona">Palona</option>
                    <option value="Lashata">Lashata</option>
                    <option value="Heladera">Heladera</option>
                    <option value="Gordilla">Gordilla</option>
                </select>

              </div>

              <div class="form-group"> <!-- agrega margen bottom para que no se peguen los inputs -->

                <input class="form-control" type="text" name="asunto" value="" placeholder="Asunto"> <!-- form-control embellece el input -->

              </div>

              <div class="form-group">

                <textarea class="form-control" name="cuerpo" rows="3" placeholder="Nota"></textarea> <!-- form-control embellece el input -->

              </div>
              <input type="text" name="usuario_id" value="<?php echo $usuario_id ?>" hidden>
              <input type="submit" name="save_nota" class="btn btn-success btn-block" value="Guardar Nota"> <!-- btn-block sirve para que ocupe todo el ancho disponible -->

            </form>

      </div>
    </div>
      </div> <!--FIN ROW AGREGAR-->

      </section>



      <?php  include("includes/footer.php")?>

      <!--Notificación-->

      <?php
        echo "<script>
        Push.create('$usuario',{
          body: 'msj random',
          icon: 'img/logo.png',
          //timeout: 6000,
          onClick: function () {
            window.open('https://www.youtube.com/watch?v=ebHed_7cIDc?autoplay=1', '_blank');
            this.close();
          }
        });
      </script>";

      ?>

</html>
