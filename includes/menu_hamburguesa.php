    <!-- MENU LATERAL -->

    <input type="checkbox" id="check">
    <label id="label_menu_hamurguesa" for="check">
      <i class="fas fa-bars icono_menu_hamburguesa" id="btn"></i>
      <i class="fas fa-times icono_menu_hamburguesa" id="cancel"></i>
    </label>
    <div class="sidebar">
          <form action="index.php?pagina=1&&pagina_notas=1" method="post">
          <ul style="margin-bottom:0px">
            <li class="submenu"><a class="more" href="#" style="text-decoration:none"><i class="fas fa-filter fa-xs"></i>Filtros</a><ul style="margin-bottom:0px">
            <li>
              <br>
              <div class="col-md-11 form-control" style="margin:0 auto">
                <input class="" type="radio" name="ver_todo" value="ver_todo"> Eliminar Filtros
              </div>
            </li>
            <li>
              <div class="col-md-12">
                <p>Filtro por Usuario:</p>
                <select class="form-control" name="usuario" id="usuario">
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
            </li>
            <li>
              <div class="col-md-12">
                <p>Filtro Fecha Desde:</p>
                <input class="form-control" type="date" name="fecha" value="">
              </div>
            </li>
            <p></p>
            <li>
              <div class="col-md-12">
                <p>Filtro Entre Fechas:</p>
                <input class="form-control" type="date" name="fecha_between_1" value="">
                <br>
                <input class="form-control" type="date" name="fecha_between_2" value="">
              </div>
            </li>
            <p></p>
            <li>
              <div class="col-md-12">
                <input class="form-control btn btn-primary btn-block" type="submit" value="Enviar">
              </div>
            </li>
            <br>
            </ul>
            </li>
            </ul>
          </form>
      <form id="opciones_menu" class="" action="vistas/mail.php" method="post">
        <input type="text" name="usuario_id" value="<?php echo $usuario_id; ?>" hidden>
        <button type="submit" name="button" style="padding: 0;border: none; background: none; width:100%; text-align:left"><a style="text-decoration: none"><i class="fa fa-envelope"></i>Enviar Correo</a></button>
      </form>
      <div>
          <a href="includes/logout.php"><i class="fa fa-user"></i>Cerrar sesión</a>
      </div>
    </div>

    <script>
    //console.log("asd");
        window.onload = init;
    function init(){
        document.querySelectorAll(".more")[0].addEventListener("click",submenu);
        document.querySelector(".submenu > ul").style.display = "none";
    }

    function submenu(){
        var estado = document.querySelector(".submenu > ul").style.display;
        if (estado == "none"){
            document.querySelector(".submenu > ul").style.display = "block";
        }else{
            document.querySelector(".submenu > ul").style.display = "none";
        };

    }

    </script>

    <!-- FIN MENU LATERAL -->
