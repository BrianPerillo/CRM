<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php $usuario_id = $_POST['usuario_id']; ?>
    <?php  include("../includes/header.php")?>

    <h1>ENVIAR MAIL</h1>
    <div class="p-4" id="wrapper"> <!-- container para que quede centrado(agrega margenes) y p4 es un padding de 4px-->

      <div class="row">

        <div class="col-md-4">

          <div class="card card-body"><!-- tarjeta de bootstrap -->

            <form action="../enviar_mail.php" method="post"><!-- El action es a donde te redirige pero también a dÓnde manda los datos del array POST O GET -->

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

                <input class="form-control" type="text" name="correo" value="" placeholder="Email"> <!-- form-control embellece el input -->

              </div>

              <div class="form-group"> <!-- agrega margen bottom para que no se peguen los inputs -->

                <input class="form-control" type="text" name="asunto" value="" placeholder="Asunto"> <!-- form-control embellece el input -->

              </div>

              <div class="form-group">

                <textarea class="form-control" name="mensaje" rows="3" placeholder="Mensaje"></textarea> <!-- form-control embellece el input -->

              </div>
              <input type="text" name="usuario_id" value="<?php echo $usuario_id ?>" hidden>
              <input type="submit" name="enviar_mail" class="btn btn-success btn-block" value="Enviar"> <!-- btn-block sirve para que ocupe todo el ancho disponible -->

            </form>

          </div>
        </div>
      </div>
    </div>

  </body>

</html>

      <?php  include("../includes/footer.php")?>
