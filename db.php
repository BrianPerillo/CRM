<?php

if(session_status() != PHP_SESSION_ACTIVE){ // Inicio una sesión para guardar datos, de esta manera se guardarán dentro del servidor, no de la db. Está bien porque es solo
  session_start();                          // para guardar msjs. La sesión se inicia siempre al principio del documento.
}


$conn = mysqli_connect(     // función para conectar con la db
  'localhost',              // donde esta la db  // para el localhost es: 'localhost'
  'root',                   // nombre usuario    // para el localhost es: 'root'
  '',                       // contraseña        // para el localhost es: ' ' (no tiene)
  'php_mysql_crud'          // nombre db         // para el local host es: 'php_mysql_crud'
);

 ?>
