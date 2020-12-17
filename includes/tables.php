<?php

class Table extends DB{

  public function getUsuarios(){
    $query = $this->connect()->prepare('SELECT * FROM usuarios');
    $query->execute();

    if($query->rowCount()){
      $usuarios = [];
      foreach ($query as $usuario) { // Setea los datos.
          $usuarios[$usuario['id']] = [
            'nombre' => $usuario['nombre'],
            'username' => $usuario['username'],
            'id' => $usuario['id'],
          ];
      }
      return $usuarios;
    }else{
        return false;
    }

  }

}





?>
