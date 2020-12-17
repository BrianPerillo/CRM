

<div class="container p-4">
  <div class="row">
    <div class="col-md-4 mx-auto"> <!-- mx-auto lo que hace es centrar el elemento (el div) -->
      <div class="card card-body"> <!-- Creo una card -->
        <form class="" action="edit.php" method="post"> <!-- El form envía a este mismo php ya que además de traer los datos para mostrarlos en el form se va a encargar de modificarlos al darle al btn actualizar -->
          <div class="form-group">
            <input class="form-control" type="text" name="usuario" value="<?php echo "$usuario"; ?>" placeholder="Actualiza el nombre"> <!-- input cuyo valor es el titulo de la tarea para que el usuario vea el title actual a la hora de modificarlo -->
          </div>
          <div class="form-group">
            <input class="form-control" type="text" name="asunto" value="<?php echo "$asunto"; ?>" placeholder="Actualiza el asunto"> <!-- input cuyo valor es el titulo de la tarea para que el usuario vea el title actual a la hora de modificarlo -->
          </div>
          <div class="form-group">
            <textarea class="form-control" name="cuerpo" rows="10" placeholder="Actualiza la nota"><?php echo "$cuerpo"; ?></textarea>
          </div>
          <input class="form-control" type="text" name="id_nota" value="<?php echo $_GET['nota']; ?>" hidden>
          <button class="btn btn-success" type="submit" name="update_nota">Actualizar</button>
        </form>
      </div>
    </div>
  </div>
</div>
