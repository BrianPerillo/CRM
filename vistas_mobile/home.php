<?php
// Si no se guardaron datos en array $_GET (es decir que no se clickeo ninguna página (1-2-3...) - ver entre linea 123 y 136)
// entonces redirijo con header para agregar a la url ?pagina=1 (o sea agrego por GET pagina 1) y esto me sirve para que, por defecto
// aparezca resaltada la pag 1, en la parte de paginación.

  if(!$_GET){
    header('Location:index.php?pagina=1');
  }

?>

<?php  include("db.php")?>

<?php  include("includes/header.php")?>

<?php  $usuario = $user->getNombre()?>

      <?php

        if(!$_POST){
          $_POST['usuario']=null;
          $_POST['fecha']=null;
          $_POST['fecha_between_1']=null;
          $_POST['fecha_between_2']=null;
          $_POST["ver_todo"]=null;
        }

        //Si existe $_POST["ver_todo"] entonces $_SESSION['query_filtro']=null. Al "no haber" $_SESSION['query_filtro'] no se ejecutará el else if
        //de mas abajo. Este ver todo llega desde el form de header.
        if(isset($_POST["ver_todo"])){
          $_SESSION['query_filtro']=null;
        }

        //Variables para paginación
        $resultado_inicial = $_GET['pagina']-1; //De acá saco el N° para el LIMIT de la query, a partir del cual va a traer los datos.
        $resultado_inicial = $resultado_inicial * 2;

        //Querys iniciales
        $query_select_task="SELECT * FROM task WHERE id > 0 ";
        $query_orden_fecha="ORDER BY created_at DESC";

        if(isset($_POST['usuario'])){
          $nombre = $_POST['usuario'];
          $query_nombre="AND name = '$nombre' ";
          $query_select_task = "$query_select_task" . "$query_nombre";
         }

        if($_POST['fecha']){
          $fecha = $_POST['fecha'];
          $query_fecha="AND created_at > '$fecha' ";
          $query_select_task = "$query_select_task" . "$query_fecha";
          }

        if($_POST['fecha_between_1'] || $_POST['fecha_between_2']){
          $fecha_between_1 = $_POST['fecha_between_1'];
          $fecha_between_2 = $_POST['fecha_between_2'];
          $query_fecha_between = "AND created_at BETWEEN '$fecha_between_1' AND '$fecha_between_2' ";
          $query_select_task = "$query_select_task" . "$query_fecha_between";
          }

          if(isset($_POST['usuario']) || $_POST['fecha'] || $_POST['fecha_between_1'] || $_POST['fecha_between_2']){

            $query_select_task_final = "$query_select_task" . "$query_orden_fecha " . "LIMIT " . "$resultado_inicial,2";
            $consulta_resultados = mysqli_query($conn, $query_select_task_final);
            $query_paginacion =  "$query_select_task" . "$query_orden_fecha";
            //echo "QUERY PAG: " . $query_paginacion . "FIN";
            cargar_datos_card($consulta_resultados);
            //echo $query_select_task_final;
            //Guardo datos en session para que no se pierdan al recargar la web por navegar en la paginación. (Este if no se va ejecutar
            //nuevamente si se cambia de página usando el paginado ya que los datos que habían llegado por post se pierden al recargar la página)
            //((Los datos que llegan por post se pierden al recargar nuevamente la página¡!))
            $_SESSION['query_filtro'] = $query_select_task;
            $_SESSION['$query_paginacion'] = $query_paginacion;
        }
        // Si ya no hay datos en POST porque se recargó la web al cambiar página (paginación) pero quiero pasar página teniendo en cuenta los
        // filtros que se habían aplicado:
        else if(isset($_SESSION['query_filtro'])){
          $query_filtro = $_SESSION['query_filtro'] . "$query_orden_fecha " . "LIMIT " . "$resultado_inicial,2";
          $consulta_resultados = mysqli_query($conn, $query_filtro);
          $query_paginacion =  $_SESSION['$query_paginacion'];
          cargar_datos_card($consulta_resultados);
          //echo $query_filtro;
        }
        // En caso de no haber datos en POST ni en SESSION ejecuto consulta por defecto para traer todos los datos:
        else {
            $query = 'SELECT * FROM task ORDER BY created_at DESC LIMIT '.$resultado_inicial.',2';
            $consulta_resultados = mysqli_query($conn, $query);
            $query_paginacion = "SELECT * FROM task";
            cargar_datos_card($consulta_resultados);
            //echo $query;

}

      ?>

      <?php  function cargar_datos_card($consulta_resultados){?>

        <?php include("includes/menu_hamburguesa.php")?>

        <h5 style="text-align:center; margin-top:15px; color:red">Version Mobile en desarrollo!</h4>

        <div class="p-4" id="wrapper_mobile"> <!-- container para que quede centrado(agrega margenes) y p4 es un padding de 4px-->

          <div class="row">

            <div class="col-md-8">

      <?php

      //$query_x_defecto = 'SELECT * FROM task ORDER BY created_at DESC LIMIT '.$resultado_inicial.',2';
      //$consulta_resultados_x_pagina = mysqli_query($conn, $query_x_defecto);
      // el 1er numero del limit indica a partir de cual va a traer los datos
      // y el segundo indica cuantos va a traer, en este caso 3

      //
      $id = 0;
        while($datos = mysqli_fetch_array($consulta_resultados)){ // La condición a su vez la guardo dentro de 1 varialbe ($row)
      ?>
            <div class="card_tarea">
              <div class="card_tarea_data">
                <h4 style="text-align:center"><?php echo $datos['name']?></h4>
                <div class=""><strong>Tarea:</strong><p><?php echo $datos['title']?></p></div>
                <div class=""><strong>Descripción:</strong><p><?php echo $datos['description']?></p></div>
                <p></p>
                <div style="text-align:center">
                <a class="btn btn-primary" style="border:0px;" href="edit.php?id=<?php echo $datos['id'] ?>"><!-- agrego el id a la url (después lo recupero desde el array de GET) -->
                  <i class="fas fa-marker"></i> <!-- Uso clase de font awesome para crear botones (font awesome esta cargado por cdn en header.php igual que bootstrap) -->
                </a><!-- Tiene que sber cual es la tarea que tiene que editar, por eso le paso el id -->
                <a id="<?php echo $id ?>" class="btn btn-danger" style="border:0px;" href="" onclick="eliminar(<?php echo $datos['id']?>,<?php echo $id?>)">
                  <i class="far fa-trash-alt"></i>
                </a><!-- Tiene que saber cual es la tarea que tiene que editar, por eso le paso el id -->
                <!--<a href="#">Ver más</a>-->
              </div>
              </div>
            </div>

          <?php $id++;}} ?>

          </div> <!-- FIN COL MD 8 -->


          <!-- PAGINACIÓN --><!-- PAGINACIÓN --><!-- PAGINACIÓN --><!-- PAGINACIÓN --><!-- PAGINACIÓN -->

          <?php  //Paginación
          //Consulto cuantos resultados/datos hay, que necesaria para calcular el número de páginas que se tiene que mostrar
          //Creo la query:
          //$query_paginacion = "SELECT * FROM task"; // Acá queda comentado, la query se arma arriba en el else
          //Ejecuto la consulta que traerá un array con los datos:
          $result_tasks = mysqli_query($conn, $query_paginacion);
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

          <nav aria-label="Page navigation example" style="margin:0 auto">
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

          <p style="margin:0 auto;">Agregar Tarea</p>

          <div class="col-md-4" style="margin-top:10px">

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

            <div class="card card-body"><!-- tarjeta de bootstrap -->

              <form action="save.php" method="post"><!-- El action es a donde te redirige pero también a dÓnde manda los datos del array POST O GET -->

                <div class="form-group"> <!-- agrega margen bottom para que no se peguen los inputs -->

                  <select class="form-control" name="usuario" id="usuario" autofocus> <!-- form-control embellece el input -->
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

                <input type="submit" name="save_task" class="btn btn-success btn-block" value="Guardar"> <!-- btn-block sirve para que ocupe todo el ancho disponible -->

              </form>

            </div>

          </div> <!-- fin col md 4 -->


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
