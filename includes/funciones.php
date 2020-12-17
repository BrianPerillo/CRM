<?php

$usuario_id = $user->getId();

    //Variables para paginación
    $resultado_inicial = $_GET['pagina']-1; //De acá saco el N° para el LIMIT de la query, a partir del cual va a traer los datos.
    $resultado_inicial = $resultado_inicial * 4;
    $resultados_x_pagina = 4;

    $query = 'SELECT * FROM task ORDER BY created_at DESC LIMIT '.$resultado_inicial.', '.$resultados_x_pagina.'';
    $consulta_resultados = mysqli_query($conn, $query);
    $query_paginacion = "SELECT * FROM task";
    $paginas = calcular_paginas($conn, $query_paginacion, $resultados_x_pagina);
    $no_hay_datos = null;
    if($consulta_resultados->num_rows==0){ // Si al hacer el num_rows da igual a 0 es porque no hay datos.
      $no_hay_datos = "No hay tareas guardadas";
    }
    cargar_datos_tabla($consulta_resultados, $paginas, $usuario_id, $no_hay_datos, $user);


    //Variables para paginación notas
    $resultado_inicial_notas = $_GET['pagina_notas']-1; //De acá saco el N° para el LIMIT de la query, a partir del cual va a traer los datos.
    $resultado_inicial_notas = $resultado_inicial_notas * 3;
    $resultados_x_pagina_notas = 3;

    $query = 'SELECT * FROM notas ORDER BY created_at DESC LIMIT '.$resultado_inicial_notas.', '.$resultados_x_pagina_notas.'';
    $consulta_resultados_notas = mysqli_query($conn, $query);
    $query_paginacion_notas = "SELECT * FROM notas";
    $paginas_notas = calcular_paginas($conn, $query_paginacion_notas, $resultados_x_pagina_notas);
    $no_hay_datos_notas = null;
    if($consulta_resultados->num_rows==0){ // Si al hacer el num_rows da igual a 0 es porque no hay datos.
      $no_hay_datos_notas = "No hay notas guardadas";
    }
    cargar_datos_cards_notas($consulta_resultados_notas, $paginas_notas, $usuario_id, $no_hay_datos_notas, $user);
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
  $total_resultados_tabla_tasks = mysqli_num_rows($result_tasks); // Cantidad de registros tabla task.
  //Uso la cant de resultados y la divido por la cant de reusltados que quiero por página
  $paginas = $total_resultados_tabla_tasks/$resultados_x_pagina; //resultados totales sobre la cantidad que quiero por página.
  $paginas = ceil($paginas); // Como $paginas puede dar número con coma uso función ceil() que redondea un número para arriba.
  return $paginas;
}

// FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN
// FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN
// FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN - FIN PAGINACIÓN

?>
