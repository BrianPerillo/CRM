<?php  include("db.php")?>

<?php  include("includes/header.php")?>

      <?php

        if(!$_POST){
          $_POST['usuario']=null;
          $_POST['fecha']=null;
          $_POST['fecha_between_1']=null;
          $_POST['fecha_between_2']=null;
        }

        if($_POST['usuario']){
          $nombre = $_POST['usuario'];
          $query_resultados_filtro_nombre = "SELECT * FROM task WHERE name = '$nombre' ORDER BY created_at DESC";
          $consulta_resultados_usuario = mysqli_query($conn, $query_resultados_filtro_nombre);
          //echo "QUERY_NOMBRE: " . $query_resultados_filtro_nombre;
            while ($datos_usuario = mysqli_fetch_array($consulta_resultados_usuario)){
              echo "Nombre: " . $datos_usuario['name'];
              echo "<br>";
              echo "Tarea: " . $datos_usuario['title'];
              echo "<br>";
              echo "Descripción: " . $datos_usuario['description'];
              echo "<br>";
              echo "Fecha: " . $datos_usuario['created_at'];
            }

        }

        if($_POST['fecha']){
          $fecha = $_POST['fecha'];
          $query_resultados_filtro_fecha = "SELECT * FROM task WHERE created_at > '$fecha' ORDER BY created_at DESC";
          $consulta_resultados_fecha = mysqli_query($conn, $query_resultados_filtro_fecha);

            while ($datos_fecha = mysqli_fetch_array($consulta_resultados_fecha)){
              echo "Nombre: " . $datos_fecha['name'];
              echo "<br>";
              echo "Tarea: " . $datos_fecha['title'];
              echo "<br>";
              echo "Descripción: " . $datos_fecha['description'];
              echo "<br>";
              echo "Fecha: " . $datos_fecha['created_at'];
            }

        }

        if($_POST['fecha_between_1'] || $_POST['fecha_between_2'] ){
          $fecha_between_1 = $_POST['fecha_between_1'];
          $fecha_between_2 = $_POST['fecha_between_2'];
          $query_resultados_filtro_fecha_between = "SELECT * FROM task WHERE created_at BETWEEN '$fecha_between_1' AND '$fecha_between_2' ORDER BY created_at DESC";
          // echo "QUERY: " . $query_resultados_filtro_fecha_between;
          //echo "fecha1: " . $_POST['fecha_between_1'];
          //echo "fecha2: " . $_POST['fecha_between_2'];
          $consulta_resultados_fecha_between = mysqli_query($conn, $query_resultados_filtro_fecha_between);

            while ($datos_fecha_between = mysqli_fetch_array($consulta_resultados_fecha_between)){
              echo "Nombre: " . $datos_fecha_between['name'];
              echo "<br>";
              echo "Tarea: " . $datos_fecha_between['title'];
              echo "<br>";
              echo "Descripción: " . $datos_fecha_between['description'];
              echo "<br>";
              echo "Fecha: " . $datos_fecha_between['created_at'];
            }

        }

      ?>

      <?php
      // Si no se guardaron datos en array $_GET (es decir que no se clickeo ninguna página (1-2-3...) - ver entre linea 123 y 136)
      // entonces redirijo con header para agregar a la url ?pagina=1 (o sea agrego por GET pagina 1) y esto me sirve para que, por defecto
      // aparezca resaltada la pag 1, en la parte de paginación.

        if(!$_GET){
          header('Location:index.php?pagina=1');
        }

      ?>

      <div class="p-4" id="wrapper"> <!-- container para que quede centrado(agrega margenes) y p4 es un padding de 4px-->

        <div class="row">

          <div class="col-md-4">

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
                session_unset(); // Elimino datos de session para que si recargo la página no siga apareciendo el mensaje de succes.
                                 // Al hacer esto se dejaría de cumplir la condición del if que está arribo, entonces no se genera ese cartel al recargar.
                }
              ?>


            <!-- FIN MSJ DE SESSION -->

            <div class="card card-body"><!-- tarjeta de bootstrap -->

              <form action="save_task.php" method="post"><!-- El action es a donde te redirige pero también a dÓnde manda los datos del array POST O GET -->

                <div class="form-group"> <!-- agrega margen bottom para que no se peguen los inputs -->

                  <input class="form-control" type="text" name="name" value="" placeholder="Nombre" autofocus> <!-- form-control embellece el input -->

                </div>

                <div class="form-group"> <!-- agrega margen bottom para que no se peguen los inputs -->

                  <input class="form-control" type="text" name="title" value="" placeholder="Tarea"> <!-- form-control embellece el input -->

                </div>

                <div class="form-group">

                  <textarea class="form-control" name="description" rows="3" placeholder="Descripción"></textarea> <!-- form-control embellece el input -->

                </div>

                <input type="submit" name="save_task" class="btn btn-success btn-block" value="Guardar"> <!-- btn-block sirve para que ocupe todo el ancho disponible -->

              </form>

            </div>

          </div>

          <div class="col-md-8">

            <table class="table table-bordered">
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
                    $resultado_inicial = $_GET['pagina']-1; //De acá saco el N° para el LIMIT de la query, a partir del cual va a traer los datos.
                    $resultado_inicial = $resultado_inicial * 2;
                    $query_resultados_x_pagina = 'SELECT * FROM task ORDER BY created_at DESC LIMIT '.$resultado_inicial.',2';
                    $consulta_resultados_x_pagina = mysqli_query($conn, $query_resultados_x_pagina);
                    // el 1er numero del limit indica a partir de cual va a traer los datos
                    // y el segundo indica cuantos va a traer, en este caso 3

                  //
                      while($row = mysqli_fetch_array($consulta_resultados_x_pagina)){ // La condición a su vez la guardo dentro de 1 varialbe ($row)
                    ?>
                          <tr>
                            <td style="width:18%"><?php echo $row['name'] ?></td>
                            <td style="width:23%"><?php echo $row['title'] ?></td>
                            <td style="width:26%"><?php echo $row['description'] ?></td>
                            <td style="width:20%"><?php echo $row['created_at'] ?></td>
                            <td style="width:13%">
                              <a class="btn btn-primary" style="border:0px;" href="edit.php?id=<?php echo $row['id'] ?>"><!-- agrego el id a la url (después lo recupero desde el array de GET) -->
                                <i class="fas fa-marker"></i> <!-- Uso clase de font awesome para crear botones (font awesome esta cargado por cdn en header.php igual que bootstrap) -->
                              </a><!-- Tiene que sber cual es la tarea que tiene que editar, por eso le paso el id -->
                              <a class="btn btn-danger" style="border:0px;" href="delete.php?id=<?php echo $row['id'] ?>">
                                <i class="far fa-trash-alt"></i>
                              </a><!-- Tiene que sber cual es la tarea que tiene que editar, por eso le paso el id -->
                            </td>
                          </tr>

                    <?php } ?>
                  </tbody>
               </thead>
            </table>

            <!-- PAGINACIÓN --><!-- PAGINACIÓN --><!-- PAGINACIÓN --><!-- PAGINACIÓN --><!-- PAGINACIÓN -->

            <?php  //Paginación
            //Consulto cuantos resultados/datos hay, que necesaria para calcular el número de páginas que se tiene que mostrar
            //Creo la query:
            $query_trae_todo_de_task = "SELECT * FROM task";
            //Ejecuto la consulta que traerá un array con los datos:
            $result_tasks = mysqli_query($conn, $query_trae_todo_de_task);
            //$conn la está trayendo el db.php que esta incluido en este index (include()) y tiene la conexión a la db
            // Uso mysqli_fetch_array para que los datos de la consulta $result_tasks se guarden en un array.
            // y uso while(){} para traer los resultados del array uno a uno

            $resultados_x_pagina = 2;
            //Usando funcion mysqli_num_rows() consulto la cantidad de resultados, es decir arroja u número x.
            $total_resultados_tabla_tasks = mysqli_num_rows($result_tasks); // Cantidad de registros tabla task.
            //Uso la cant de resultados y la divido por la cant de reusltados que quiero por página
            $paginas = $total_resultados_tabla_tasks/$resultados_x_pagina; //resultados totales sobre la cantidad que quiero por página.
            $paginas = ceil($paginas); // Como $paginas puede dar número con coma uso función ceil() que redondea un número para arriba.

            ?>

            <nav aria-label="Page navigation example">
              <ul class="pagination">
                <li class="page-item <?php if($_GET["pagina"]==1){?>disabled <?php } ?>"><a class="page-link" href="index.php?pagina=<?=$_GET["pagina"]-1?>">Anterior</a></li><!-- ya que el previous lleva a pagina  anterior resta por get a pagina - 1 -->
                <?php for ($i=0; $i < $paginas; $i++) { ?> <!-- bucle para generar los li necesarios según los resultados que tengamos -->

                <!-- Creo el li que se va a aparecer o no y se va a repetir o no dependiendo si hay resultados y la cantidad de resultados, le agrego codigo
                     para que se resalte la pagina seleccionada mediante clase active Y AGREGO/PASO NUMERO DE PÁGINA POR GET -->
                <li class="page-item pagina <?php if($_GET["pagina"]==$i+1){?>active <?php } ?>"><a class="page-link" href="index.php?pagina=<?=$i+1 ?>"><?= $i+1 ?></a></li>

                <?php } ?> <!-- Fin bucle -->

                <li class="page-item <?php if($_GET["pagina"]==$paginas){?>disabled <?php } ?>"><a class="page-link" href="index.php?pagina=<?=$_GET["pagina"]+1?>">Siguiente</a></li><!-- ya que el next lleva a siguiente pagina suma por get a pagina + 1 -->
              </ul>
            </nav>

            <!-- FIN PAGINACIÓN --><!-- FIN PAGINACIÓN --><!-- FIN PAGINACIÓN --><!-- FIN PAGINACIÓN --><!-- FIN PAGINACIÓN -->

          </div>

        </div>

      </div>


      <?php  include("includes/footer.php")?>


</html>
