<?php

// FILTROS - FILTROS - FILTROS - FILTROS - FILTROS - FILTROS - FILTROS - FILTROS - FILTROS - FILTROS - FILTROS - FILTROS - FILTROS - FILTROS
$usuario_id = $user->getId();

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
        $resultado_inicial = $resultado_inicial * 4;
        $resultados_x_pagina = 4;

        //Variables para paginación notas
        $resultado_inicial_notas = $_GET['pagina_notas']-1; //De acá saco el N° para el LIMIT de la query, a partir del cual va a traer los datos.
        $resultado_inicial_notas = $resultado_inicial_notas * 3;
        $resultados_x_pagina_notas = 3;

        //Querys iniciales
        $query_select_task="SELECT * FROM task WHERE id > 0 ";
        $query_orden_fecha="ORDER BY created_at DESC";

        if(isset($_POST['usuario'])){
          $nombre = $_POST['usuario'];
          $query_nombre="AND usuario = '$nombre' ";
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

            $query_select_task_final = "$query_select_task" . "$query_orden_fecha " . "LIMIT " . "$resultado_inicial,$resultados_x_pagina";
            $consulta_resultados = mysqli_query($conn, $query_select_task_final);
            $query_paginacion =  "$query_select_task" . "$query_orden_fecha";
            $paginas = calcular_paginas($conn, $query_paginacion, $resultados_x_pagina);
            //echo "QUERY PAG: " . $query_paginacion . "FIN";
            $no_hay_datos = null;
            if($consulta_resultados->num_rows==0){ // Si al hacer el num_rows da igual a 0 es porque no hay datos.
              $no_hay_datos = "No hay tareas guardadas";
            }
            cargar_datos_tabla($consulta_resultados, $paginas, $usuario_id, $no_hay_datos);
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
          $query_filtro = $_SESSION['query_filtro'] . "$query_orden_fecha " . "LIMIT " . "$resultado_inicial,$resultados_x_pagina";
          $consulta_resultados = mysqli_query($conn, $query_filtro);
          $query_paginacion =  $_SESSION['$query_paginacion'];
          $paginas = calcular_paginas($conn, $query_paginacion, $resultados_x_pagina);
          $no_hay_datos = null;
          if($consulta_resultados->num_rows==0){ // Si al hacer el num_rows da igual a 0 es porque no hay datos.
            $no_hay_datos = "No hay tareas guardadas";
          }
          cargar_datos_tabla($consulta_resultados, $paginas, $usuario_id, $no_hay_datos);
          //echo $query_filtro;
        }
        // En caso de no haber datos en POST ni en SESSION ejecuto consulta por defecto para traer todos los datos:
        else {
            $query = 'SELECT * FROM task ORDER BY created_at DESC LIMIT '.$resultado_inicial.', '.$resultados_x_pagina.'';
            $consulta_resultados = mysqli_query($conn, $query);
            $query_paginacion = "SELECT * FROM task";
            $paginas = calcular_paginas($conn, $query_paginacion, $resultados_x_pagina);
            $no_hay_datos = null;
            if($consulta_resultados->num_rows==0){ // Si al hacer el num_rows da igual a 0 es porque no hay datos.
              $no_hay_datos = "No hay tareas guardadas";
            }
            cargar_datos_tabla($consulta_resultados, $paginas, $usuario_id, $no_hay_datos);
            //echo $query;


}

// FIN FILTROS - FIN FILTROS - FIN FILTROS - FIN FILTROS - FIN FILTROS - FIN FILTROS - FIN FILTROS - FIN FILTROS
// FIN FILTROS - FIN FILTROS - FIN FILTROS - FIN FILTROS - FIN FILTROS - FIN FILTROS - FIN FILTROS - FIN FILTROS
// FIN FILTROS - FIN FILTROS - FIN FILTROS - FIN FILTROS - FIN FILTROS - FIN FILTROS - FIN FILTROS - FIN FILTROS

          $query = 'SELECT * FROM notas ORDER BY created_at DESC LIMIT '.$resultado_inicial_notas.', '.$resultados_x_pagina_notas.'';
          $consulta_resultados_notas = mysqli_query($conn, $query);
          $query_paginacion_notas = "SELECT * FROM notas";
          $paginas_notas = calcular_paginas($conn, $query_paginacion_notas, $resultados_x_pagina_notas);
          cargar_datos_cards_notas($consulta_resultados_notas, $paginas_notas);
          //echo $query;


// PAGINACIÓN - PAGINACIÓN - PAGINACIÓN - PAGINACIÓN - PAGINACIÓN - PAGINACIÓN - PAGINACIÓN - PAGINACIÓN - PAGINACIÓN - PAGINACIÓN
// PAGINACIÓN - PAGINACIÓN - PAGINACIÓN - PAGINACIÓN - PAGINACIÓN - PAGINACIÓN - PAGINACIÓN - PAGINACIÓN - PAGINACIÓN - PAGINACIÓN
// PAGINACIÓN - PAGINACIÓN - PAGINACIÓN - PAGINACIÓN - PAGINACIÓN - PAGINACIÓN - PAGINACIÓN - PAGINACIÓN - PAGINACIÓN - PAGINACIÓN

function calcular_paginas($conn, $query_paginacion, $resultados_x_pagina){
  //Paginación
  //Consulto cuantos resultados/datos hay, que necesaria para calcular el número de páginas que se tiene que mostrar
  //Creo la query:
  //$query_paginacion = "SELECT * FROM task"; // Acá queda comentado, la query se arma arriba en el else
  //Ejecuto la consulta que traerá un array con los datos:
  $result_tasks = mysqli_query($conn, $query_paginacion);
  //$conn la está trayendo el db.php que esta incluido en este index (include()) y tiene la conexión a la db
  // Uso mysqli_fetch_array para que los datos de la consulta $result_tasks se guarden en un array.
  // y uso while(){} para traer los resultados del array uno a uno

  //$resultados_x_pagina = 4;
  //Usando funcion mysqli_num_rows() consulto la cantidad de resultados, es decir arroja u número x.
  if(!empty($result_tasks) AND mysqli_num_rows($result_tasks) > 0){
  $total_resultados_tabla_tasks = mysqli_num_rows($result_tasks); // Cantidad de registros tabla task.

  //Uso la cant de resultados y la divido por la cant de reusltados que quiero por página
  $paginas = $total_resultados_tabla_tasks/$resultados_x_pagina; //resultados totales sobre la cantidad que quiero por página.
  $paginas = ceil($paginas); // Como $paginas puede dar número con coma uso función ceil() que redondea un número para arriba.
  return $paginas;}
}

// FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN
// FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN
// FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN

?>
