

<div class="container p-4">
  <div class="row">
    <div class="col-md-4 mx-auto"> <!-- mx-auto lo que hace es centrar el elemento (el div) -->
      <div class="card card-body"> <!-- Creo una card -->
        <form class="" action="edit.php" method="post"> <!-- El form envía a este mismo php ya que además de traer los datos para mostrarlos en el form se va a encargar de modificarlos al darle al btn actualizar -->
          <div class="form-group">
            <input class="form-control" type="text" name="usuario" value="<?php echo "$usuario"; ?>" placeholder="Actualiza el nombre"> <!-- input cuyo valor es el titulo de la tarea para que el usuario vea el title actual a la hora de modificarlo -->
          </div>
          <div class="form-group">
            <input class="form-control" type="text" name="title" value="<?php echo "$title"; ?>" placeholder="Actualiza el titulo"> <!-- input cuyo valor es el titulo de la tarea para que el usuario vea el title actual a la hora de modificarlo -->
          </div>
          <div class="form-group">
            <textarea class="form-control" name="description" rows="10" placeholder="Actualiza la descripción"><?php echo "$description"; ?></textarea>
          </div>
          <input class="form-control" type="text" name="id_tarea" value="<?php echo $_GET['id']; ?>" hidden>
          <button class="btn btn-success" type="submit" name="update_tarea">Actualizar</button>
        </form>
      </div>
    </div>
  </div>
</div>
