
<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <!-- viewport con ancho del dispositivo()100% y un initial scale de 1.0 que controla el nivel de zoom -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Task Manager</title>
    <!-- Css Propio -->
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <!-- Css Menu Lateral -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
      integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
      crossorigin="anonymous">
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
      integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p"
      crossorigin="anonymous"/>
  </head>
  <body>

    <nav id="nav_header" class="navbar" style=""> <!-- permiten un nav de estilo oscuro/dark -->
      <div class=""> <!-- container permite que esté centrado el contenido -->
         <a href="index.php" class="navbar-brand" style="margin:0 auto;padding-left:20px"><img class="img-fluid" src="img/logo.png" alt="gids" style="width:90px;"></a>
      </div>
      <div>
          <a href="vistas/perfil.php?pagina=1&&pagina_notas=1&&usuariolog=<?php if(isset($_GET['usuariolog'])){echo $_GET['usuariolog'];}else{echo $usuario_id;}?>">
          <i class="fa fa-user" style="margin-right:10px"></i><strong>Ver Perfil</strong></a>
          </a>
      </div>
    </nav>

<!-- Formulario Filtros-->

    <header>

    </header>

<!-- Fin Formulario Filtros-->
